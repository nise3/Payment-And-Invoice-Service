<?php

namespace App\Services\SslCommerz;

use App\Helpers\Classes\PaymentHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use const Widmogrod\Functional\concat;

class SslCommerzPaymentGatewayService
{

    public function sslCommerzPay(array $data, array $paymentConfig): array
    {
        $baseUrl = env('IS_SANDBOX', false) ? config('sslcommerz.sandbox.apiDomain') : config('sslcommerz.production.apiDomain');
        $paymentInitUrl = $baseUrl . config('sslcommerz.apiUrl.make_payment');
        $validatedData = $this->validation($data)->validate();
        $payload = $this->buildPayload($validatedData, $paymentConfig);
        $redirectUri = $this->callApi($paymentInitUrl, $payload);
        return [
            $payload,
            $redirectUri
        ];
    }


    public function callApi(string $url, array $payload)
    {
        $gatewayUrl = null;

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, $this->isVerify()); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC

        $content = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslCommerzResponse = json_decode($content, true);
            $gatewayUrl = $sslCommerzResponse['GatewayPageURL'] ?? null;
            Log::info("Http-log: " . json_encode($sslCommerzResponse));
        } else {
            curl_close($handle);
        }
        return $gatewayUrl;
    }

    public function paymentLogPayloadBuilder(array $payload, array &$response, bool $isInit = true)
    {
        if ($isInit) {
            $response = [
                "customer_name" => $payload['cus_name'],
                "customer_mobile" => $payload['cus_phone'],
                "customer_email" => $payload['cus_email'],
                "transaction_amount" => $payload['total_amount'],
                "transaction_currency" => $payload['currency'],
                "request_payload" => $payload,
                'transaction_created_at' => Carbon::now()
            ];
        } else {
            $response = [
                "invoice" => $payload['tran_id'],
                "transaction_amount" => $payload['amount'],
                "transaction_currency" => $payload['currency'],
                "response_message" => $payload,
                "payment_status" => $this->getPaymentStatus($payload['status']),
                "transaction_completed_at" => Carbon::now()
            ];
        }
    }

    /**
     * @param string $msgCode
     * @return int
     */
    private function getPaymentStatus(string $msgCode): int
    {
        if ($msgCode == PaymentHelper::SSL_PAYMENT_VALID) {
            return PaymentHelper::PAYMENT_STATUS_SUCCESS;
        } elseif ($msgCode == PaymentHelper::SSL_PAYMENT_FAILED) {
            return PaymentHelper::PAYMENT_STATUS_FAILED;
        } elseif ($msgCode == PaymentHelper::SSL_PAYMENT_CANCELLED) {
            return PaymentHelper::PAYMENT_STATUS_CANCEL;
        } else {
            return PaymentHelper::PAYMENT_STATUS_PENDING;
        }

    }


    public function orderValidation(Request $request, array $paymentConfig): bool
    {
        if ($this->sslCommerzHashVerify($request, $paymentConfig['api_credential']['password'])) {
            $valId = urlencode($request->offsetGet('val_id'));
            $storeId = urlencode($paymentConfig['api_credential']['merchant_id']);
            $storePassword = urlencode($paymentConfig['api_credential']['password']);
            $baseUrl = env('IS_SANDBOX', false) ? config('sslcommerz.sandbox.apiDomain') : config('sslcommerz.production.apiDomain');

            $requestedUrl = $baseUrl . config('sslcommerz.apiUrl.order_validate') . "?val_id=" . $valId . "&store_id=" . $storeId . "&store_passwd=" . $storePassword . "&v=1&format=json";

            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $requestedUrl);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, $this->isVerify()); # IF YOU RUN FROM LOCAL PC
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, $this->isVerify()); # IF YOU RUN FROM LOCAL PC

            $result = curl_exec($handle);
            Log::info("Order Validation Info:" . json_encode($result));

            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $result = json_decode($result, true);
            if ($code == 200 && !(curl_errno($handle)) && $result['status'] == (PaymentHelper::SSL_PAYMENT_VALID || PaymentHelper::SSL_PAYMENT_VALIDATED)) {
                return true;
            }

        } else {
            Log::info("Unable to ssl commerz hash verify");
        }
        return false;

    }

    /**
     * @param Request $request
     * @param string $storePassword
     * @return bool
     */
    private function sslCommerzHashVerify(Request $request, string $storePassword = ""): bool
    {
        if (!empty($request->offsetGet('verify_sign')) && !empty($request->offsetGet('verify_key'))) {
            $preDefineKey = explode(',', $request->offsetGet('verify_key'));
            $newData = array();
            if (!empty($preDefineKey)) {
                foreach ($preDefineKey as $value) {
                    if ($request->has($value)) {
                        $newData[$value] = $request->offsetGet($value);
                    }
                }
            }
            # ADD MD5 OF STORE PASSWORD
            $newData['store_passwd'] = md5($storePassword);
            # SORT THE KEY AS BEFORE
            ksort($newData);
            $hashString = "";
            foreach ($newData as $key => $value) {
                $hashString .= $key . '=' . ($value) . '&';
            }
            $hashString = rtrim($hashString, '&');
            if (md5($hashString) == $request->offsetGet('verify_sign')) {
                return true;
            } else {
                return false;
            }
        } else return false;
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

    private function buildPayload(array $data, array $paymentConfig): array
    {
        return [
            "store_id" => $paymentConfig['api_credential']['merchant_id'],
            "store_passwd" => $paymentConfig['api_credential']['password'],

            /** transaction amount */
            "tran_id" => $paymentConfig['transaction_id'],
            "total_amount" => $data['transaction_info']['amount'],
            "currency" => $data['transaction_info']['currency'],

            /**  Feed Uri */
            "success_url" => $paymentConfig['ipn_url'],//$data['feed_uri']['success'],
            "fail_url" => $data['feed_uri']['failed'],
            "cancel_url" => $data['feed_uri']['cancel'],
            "ipn_url" => $paymentConfig['ipn_url'],

            /** Customer Info */
            "cus_name" => $data['customer_info']['name'],
            "cus_email" => $data['customer_info']['email'],
            "cus_phone" => $data['customer_info']['mobile_no'],
            "cus_add1" => $data['customer_info']['address'] ?? "",
            "cus_city" => $data['customer_info']['city'] ?? "",
            "cus_country" => $data['customer_info']['country'] ?? "",

            "shipping_method" => "NO",
            "product_name" => "NO",
            "product_category" => "application fee",
            "product_profile" => PaymentHelper::SSL_COM_PRODUCT_PROFILE[PaymentHelper::NON_PHYSICAL_GOODS],

        ];
    }

    private function isVerify(): bool
    {
        return request()->getHost() != ("localhost" || "127.0.0.1");
    }
}
