<?php

namespace App\Services;

use App\Events\PaymentSuccessEvent;
use App\Helpers\Classes\PaymentHelper;
use App\Models\PaymentConfiguration;
use App\Models\PaymentPurpose;
use App\Models\PaymentTransactionHistory;
use App\Models\PaymentTransactionLog;
use App\Services\EkPay\EkPayPaymentService;
use App\Services\SslCommerz\SslCommerzPaymentGatewayService;
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
        [$paymentConfig, $paymentBaseConfiguration] = $this->getPaymentConfig($data);
        $gatewayType = $paymentConfig['gateway_type'];
        $invoice = InvoiceGeneratorService::getNewInvoiceCode($data['payment_config']['purpose']);
        $paymentBaseConfiguration['transaction_id'] = $invoice;
        $paymentBaseConfiguration['ipn_url'] = config('paymentConfiguration.ipn_url');
        $requestPayload = [];
        $redirectUri = null;
        $status = false;
        $paymentLog = [];

        if ($gatewayType == PaymentHelper::GATEWAY_EKPAY) {
            [$requestPayload, $redirectUri] = app(EkPayPaymentService::class)->ekPay($data, $paymentBaseConfiguration);
            $status = (bool)$redirectUri;
            $message = "Success";
            if ($status) {
                /** Data store in history log */
                app(EkPayPaymentService::class)->paymentLogPayloadBuilder($requestPayload, $paymentLog);
            }
        } elseif ($gatewayType == PaymentHelper::GATEWAY_SSLCOMMERZ) {
            [$requestPayload, $redirectUri] = app(SslCommerzPaymentGatewayService::class)->sslCommerzPay($data, $paymentBaseConfiguration);
            $status = (bool)$redirectUri;
            $message = "Success";

            if ($status) {
                /** Data store in history log */
                app(SslCommerzPaymentGatewayService::class)->paymentLogPayloadBuilder($requestPayload, $paymentLog);
            }

        } else {
            $message = "The Payment gateway is not found";
        }

        /** Data Store in payment Log */
        if ($paymentLog) {
            $parts = explode('/',  $paymentBaseConfiguration['ipn_url']);
            $ipnUriSecretToken = end($parts);
            $paymentLog['invoice'] = $invoice;
            $paymentLog['payment_purpose'] = $data['payment_config']['purpose'];
            $paymentLog['payment_purpose_related_id'] = $data['payment_config']['purpose_related_id'];
            $paymentLog['payment_gateway_type'] = $gatewayType;
            $paymentLog['ipn_uri_secret_token'] = $ipnUriSecretToken;
            $this->storeDataInPaymentLog($paymentLog);
        }


        return [
            $status,
            $message,
            $redirectUri
        ];
    }


    /**
     * IPN Handler for payment confirmation
     * @param Request $request
     * @param string $secretToken
     * @return void
     */
    public function handleIpn(Request $request, string $secretToken)
    {
        $paymentGatewayType = $this->getPaymentGateway($secretToken);

        $response = [];
        if ($paymentGatewayType == PaymentHelper::GATEWAY_EKPAY) {
            app(EkPayPaymentService::class)->paymentLogPayloadBuilder($request->all(), $response, false);
        }else if($paymentGatewayType == PaymentHelper::GATEWAY_SSLCOMMERZ){
            app(SslCommerzPaymentGatewayService::class)->paymentLogPayloadBuilder($request->all(), $response, false);
        }
        $paymentLog = $this->storeDataInPaymentLog($response, true);

        if (!empty($paymentLog)) {
            $this->paymentEventFire($paymentLog);
        }
    }

    /**
     * Payment Gateway config by payment purpose
     * @param array $data
     * @return array
     */
    public function getPaymentConfigByPaymentPurpose(array $data): array
    {
        $paymentConfig = PaymentPurpose::where('code', $data['payment_purpose'])->firstOrFail();
        $paymentConfigData = $paymentConfig->paymentConfigurations()->get();

        $paymentConfigData = $paymentConfigData->map(function ($item, $key) {
            return [
                'payment_config_id' => $item->id,
                'gateway_type' => $item->gateway_type,
            ];
        });
        return $paymentConfigData->toArray();
    }


    private function getPaymentConfig(array $data): array
    {
        $paymentConfig = PaymentConfiguration::findOrFail($data['payment_config']['payment_config_id'])->toArray();
        $configChild = env('IS_SANDBOX', false) ? "sandbox" : "production";
        return [
            $paymentConfig,
            $paymentConfig['configuration'][$configChild]
        ];
    }

    /**
     * Payment Verification using generated secrete token
     * @param string $secretToken
     * @return bool
     */
    public static function checkSecretToken(string $secretToken): bool
    {
        return (bool)PaymentTransactionLog::where('ipn_uri_secret_token', $secretToken)->count('ipn_uri_secret_token');
    }

    /**
     * Store and Update the PaymentTractionLog and PaymentTransaction History
     * @param array $data
     * @param bool $isUpdate
     * @return array
     */
    private function storeDataInPaymentLog(array $data, bool $isUpdate = false): array
    {
        $paymentHistory = [];
        $paymentLog = $isUpdate ? PaymentTransactionLog::where('invoice', $data['invoice'])->where("transaction_amount", $data['transaction_amount'])->where("transaction_currency", $data['transaction_currency'])->first() : new PaymentTransactionLog();
        if ($paymentLog) {
            $paymentLog->fill($data);
            $paymentLog->save();
            Log::info("Data is updated or stored in PaymentTransactionLog");
            if ($isUpdate && !empty($data['payment_status']) && $data['payment_status'] == PaymentHelper::PAYMENT_STATUS_SUCCESS) {
                $paymentHistoryPayload = $paymentLog->toArray();
                $paymentHistory = PaymentTransactionHistory::create($paymentHistoryPayload)->toArray();
                Log::info("Data is  stored in PaymentTransactionHistory");
            }
        } else {
            Log::debug('The payment_traction_log payload is not valid, here is the payload: ', $data);
        }
        return $paymentHistory;
    }

    /**
     * Retrieve the payment gateway type by secretToken
     * @param string $secretKey
     * @return string
     */
    private function getPaymentGateway(string $secretKey): string
    {
        return PaymentTransactionLog::where("ipn_uri_secret_token", $secretKey)->firstOrfail()->payment_gateway_type;
    }

    private function paymentEventFire(array $data)
    {
        $purposeRelatedQueue = PaymentPurpose::where("code", $data['payment_purpose'])->firstOrFail()->payment_related_queue_name;

        request()->offsetSet('exchange_name', $purposeRelatedQueue);
        request()->offsetSet('queue_config_name', $purposeRelatedQueue);
        request()->offsetSet('retry_mechanism', true);
        unset($data['request_payload']);
        unset($data['response_message']);
        event(new PaymentSuccessEvent($data));
    }

    public function validation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "payment_config.payment_config_id" => [
                "required",
                "exists:payment_configurations,id,deleted_at,NULL"
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

    public function paymentConfigValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "payment_purpose" => [
                "required",
                Rule::in(PaymentHelper::ALL_PURPOSES)
            ]
        ];

        return Validator::make($request->all(), $rules);
    }


}
