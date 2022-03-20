<?php

namespace App\Services\EkPay;

use App\Exceptions\HttpErrorException;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class EkPayPaymentService
{

    /**
     * @throws RequestException
     * @throws ValidationException
     */
    public function ekPay(array $data, array $paymentConfig): array
    {
        $paymentConfig['ipn_channel'] = config('ekpay.ipn_channel');
        $paymentConfig['mac_address'] = env('IS_SANDBOX', false) ? config('ekpay.sandbox.mac_addr') : config('ekpay.production.mac_addr');
        $url = env('IS_SANDBOX', false) ? config('ekpay.sandbox.ekpay_base_uri') : config('ekpay.production.ekpay_base_uri');
        $paymentInitUrl = $url . "/merchant-api";
        $validatedData = $this->validation($data)->validate();
        $payload = $this->buildPayload($validatedData, $paymentConfig);

        $response = Http::withoutVerifying()
            ->withHeaders([
                "Content-Type" => 'application/json'
            ])
            ->timeout(10)
            ->post($paymentInitUrl, $payload)
            ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($paymentInitUrl) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $paymentInitUrl . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json(); //secure_token

        Log::info("Http-log: " . json_encode($response));

        $redirectUri = null;
        if (!empty($response['secure_token'])) {
            $redirectUri = $url . '?sToken=' . $response['secure_token'] . '&trnsID=' . $payload['trns_info']['trnx_id'];
        }
        return [
            $payload,
            $redirectUri
        ];
    }

    private function validation(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "feed_uri.success" => [
                "required",
                "string"
            ],
            "feed_uri.failed" => [
                "required",
                "string"
            ],
            "feed_uri.cancel" => [
                "required",
                "string"
            ],
            "customer_info.id" => [
                "required"
            ],
            "customer_info.name" => [
                "required"
            ],
            "customer_info.email" => [
                "required"
            ],
            "customer_info.mobile_no" => [
                "required"
            ],
            "customer_info.address" => [
                "nullable"
            ],
            "transaction_info.amount" => [
                "required",
                "numeric",
                "gt:0"
            ],
            "transaction_info.currency" => [
                "required",
                "string",
                Rule::in([
                    "BDT"
                ])
            ],
            "transaction_info.order_detail" => [
                "nullable",
                "string"
            ]
        ];

        return Validator::make($data, $rules);
    }

    #[ArrayShape(['mer_info' => "array", 'feed_uri' => "array", 'req_timestamp' => "string", 'cust_info' => "array", 'trns_info' => "array", 'ipn_info' => "array", 'mac_addr' => "mixed"])]
    private function buildPayload(array $data, array $paymentConfig): array
    {
        $time = Carbon::now()->format('Y-m-d H:i:s');
        return [
            'mer_info' => [
                'mer_reg_id' => $paymentConfig['api_credential']['merchant_id'],
                'mer_pas_key' => $paymentConfig['api_credential']['password']
            ],
            'feed_uri' => [
                's_uri' => $data['feed_uri']['success'],
                'f_uri' => $data['feed_uri']['failed'],
                'c_uri' => $data['feed_uri']['cancel'],
            ],
            'req_timestamp' => $time . ' GMT+6',
            'cust_info' => [
                'cust_id' => $data['customer_info']['id'],
                'cust_name' => preg_replace('/[^A-Za-z0-9 \-\.]/', '', $data['customer_info']['name']),
                'cust_mobo_no' => $data['customer_info']['mobile_no'],
                'cust_email' => $data['customer_info']['email'],
                'cust_mail_addr' => $data['customer_info']['address'] ?? ""
            ],
            'trns_info' => [
                'trnx_id' => $paymentConfig['transaction_id'],
                'trnx_amt' => $data['transaction_info']['amount'],
                'trnx_currency' => $data['transaction_info']['currency'],
                'ord_id' => $paymentConfig['transaction_id'],
                'ord_det' => $data['transaction_info']['order_detail'] ?? "",
            ],
            'ipn_info' => [
                'ipn_channel' => $paymentConfig['ipn_channel'],
                'ipn_email' => $paymentConfig['ipn_email'] ?? 'noreply@nise.gov.bd',
                'ipn_uri' => $paymentConfig['ipn_url'],
            ],
            'mac_addr' => $paymentConfig['mac_address']
        ];
    }

}
