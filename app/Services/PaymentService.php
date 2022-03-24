<?php

namespace App\Services;

use App\Helpers\Classes\PaymentHelper;
use App\Models\PaymentPurpose;
use App\Models\PaymentTransactionLog;
use App\Services\EkPay\EkPayPaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class PaymentService
{

    /**
     * @throws Throwable
     */
    public function processing(array $data): array
    {
        $gatewayType = $data['payment_config']['gateway_type'];
        $paymentConfig = $this->getPaymentConfig($data);
        $invoice = InvoiceGeneratorService::getNewInvoiceCode($data['payment_config']['purpose']);
        $paymentConfig['transaction_id'] = $invoice;
        $paymentConfig['ipn_url'] = config('paymentConfiguration.ipn_url');
        $requestPayload = [];
        $redirectUri = null;
        $status = false;
        if ($gatewayType == PaymentHelper::GATEWAY_EKPAY) {
            [$requestPayload, $redirectUri] = app(EkPayPaymentService::class)->ekPay($data, $paymentConfig);
            $status = (bool)$redirectUri;
            $message = "Success";
            if ($status) {
                $parts = explode('/', $requestPayload['ipn_info']['ipn_uri']);
                $ipnUriSecretToken = end($parts);
                /** Data store in history log */
                $data['invoice'] = $invoice;
                $data['payment_purpose'] = $data['payment_config']['purpose'];
                $data['payment_purpose_related_id'] = $data['payment_config']['purpose_related_id'];
                $data['payment_gateway_type'] = $gatewayType;
                $data['transaction_currency'] = $requestPayload['trns_info']['trnx_currency'];
                $data['amount'] = $requestPayload['trns_info']['trnx_amt'];
                $data['ipn_uri_secret_token'] = $ipnUriSecretToken;
                $data['request_payload'] = $requestPayload;
                $data['transaction_created_at'] = Carbon::now();
                $this->storeDataInPaymentLog($data);
            }
        } elseif ($gatewayType == PaymentHelper::GATEWAY_SSLCOMMERZ) {
            [$requestPayload, $redirectUri] = app(EkPayPaymentService::class)->ekPay($data, $paymentConfig);
            $status = (bool)$redirectUri;
            $message = "Success";
        } else {
            $message = "The Payment gateway is not found";
        }

        return [
            $status,
            $message,
            $redirectUri
        ];
    }

    private function storeDataInPaymentLog(array $data, bool $isUpdate = false)
    {

        $paymentLog = $isUpdate ? PaymentTransactionLog::where('invoice', $data['transaction_id'])->where("amount", $data['amount'])->where("transaction_currency", $data['transaction_currency'])->first() : new PaymentTransactionLog();
        if ($paymentLog) {
            $paymentLog->fill($data);
            $paymentLog->save();
        } else {
            Log::debug('The payment_traction_log payload is not valid, here is the payload: ', $data);
        }

    }

    private function getPaymentConfig(array $data): array
    {
        $paymentConfig = PaymentPurpose::where('code', $data['payment_config']['purpose'])->firstOrFail();
        $paymentConfigData = $paymentConfig->paymentConfigurations($data['payment_config']['gateway_type'])->firstOrFail()->toArray();
        $configChild = env('IS_SANDBOX', false) ? "sandbox" : "production";
        return $paymentConfigData['configuration'][$configChild];
    }

    public static function checkSecretToken(string $secretToken): bool
    {
        return (bool)PaymentTransactionLog::where('ipn_uri_secret_token', $secretToken)->count('ipn_uri_secret_token');
    }

    public function handleIpn(Request $request, string $secretToken)
    {
        $paymentGatewayType = $this->getPaymentGateway($secretToken);
        $response = [];
        if ($paymentGatewayType == PaymentHelper::GATEWAY_EKPAY) {
            $response = app(EkPayPaymentService::class)->ipnResponseProcessing($request);
        }

    }

    private function getPaymentGateway(string $secretToken): string
    {
        return PaymentTransactionLog::where("ipn_uri_secret_token")->findOrfail()->payment_gateway_type;
    }

    public function validation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "payment_config.accessor" => [
                "required",
                Rule::in(array_keys(PaymentHelper::ALL_ACCESSORS))
            ],
            "payment_config.accessor_id" => [
                "required",
                Rule::exists('payment_configurations', 'accessor_id')
                    ->where('accessor', $request->get('payment_config')['accessor']),
            ],
            "payment_config.gateway_type" => [
                "required",
                Rule::in(array_keys(PaymentHelper::ALL_PAYMENT_GATEWAYS))
            ],
            "payment_config.purpose" => [
                "required",
                Rule::in(PaymentHelper::ALL_PURPOSES)
            ],
            "payment_config.purpose_related_id" => [
                "required",
            ],
            "feed_uri" => [
                "required",
                "array"
            ],
            "customer_info" => [
                "required",
                "array"
            ],
            "transaction_info" => [
                "required",
                "array"
            ]
        ];

        return Validator::make($request->all(), $rules);
    }


}
