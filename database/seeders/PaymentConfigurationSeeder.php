<?php

namespace Database\Seeders;

use App\Helpers\Classes\PaymentHelper;
use App\Models\PaymentConfiguration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PaymentConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        PaymentConfiguration::query()->truncate();
        $defaultConfiguration= [
            [
                "id" => 1,
                "accessor" => PaymentHelper::PAYMENT_CONFIG_ACCESSOR_NISE,
                "gateway_type" => PaymentHelper::GATEWAY_EKPAY,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentHelper::GATEWAY_EKPAY))
            ]
        ];

        $configurations=[
            [
                "id" => 2,
                "accessor" => PaymentHelper::PAYMENT_CONFIG_ACCESSOR_INDUSTRY_ASSOCIATION,
                "accessor_id" => 1,
                "gateway_type" => PaymentHelper::GATEWAY_SSLCOMMERZ,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentHelper::GATEWAY_SSLCOMMERZ))
            ],

            [
                "id" => 3,
                "accessor" => PaymentHelper::PAYMENT_CONFIG_ACCESSOR_INDUSTRY,
                "accessor_id" => 1,
                "gateway_type" => PaymentHelper::GATEWAY_EKPAY,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentHelper::GATEWAY_EKPAY))
            ],
            [
                "id" => 4,
                "accessor" => PaymentHelper::PAYMENT_CONFIG_ACCESSOR_INDUSTRY,
                "accessor_id" => 1,
                "gateway_type" => PaymentHelper::GATEWAY_SSLCOMMERZ,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentHelper::GATEWAY_SSLCOMMERZ))
            ],
            [
                "id" => 5,
                "accessor" => PaymentHelper::PAYMENT_CONFIG_ACCESSOR_INSTITUTE,
                "accessor_id" => 1,
                "gateway_type" => PaymentHelper::GATEWAY_EKPAY,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentHelper::GATEWAY_EKPAY))
            ],
            [
                "id" => 6,
                "accessor" => PaymentHelper::PAYMENT_CONFIG_ACCESSOR_INSTITUTE,
                "accessor_id" => 1,
                "gateway_type" => PaymentHelper::GATEWAY_SSLCOMMERZ,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentHelper::GATEWAY_SSLCOMMERZ))
            ],
            [
                "id" => 7,
                "accessor" => PaymentHelper::PAYMENT_CONFIG_ACCESSOR_RTO,
                "accessor_id" => 1,
                "gateway_type" => PaymentHelper::GATEWAY_EKPAY,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentHelper::GATEWAY_EKPAY))
            ],
            [
                "id" => 8,
                "accessor" => PaymentHelper::PAYMENT_CONFIG_ACCESSOR_RTO,
                "accessor_id" => 1,
                "gateway_type" => PaymentHelper::GATEWAY_SSLCOMMERZ,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentHelper::GATEWAY_SSLCOMMERZ))
            ]
        ];

        PaymentConfiguration::insert($defaultConfiguration);
        PaymentConfiguration::insert($configurations);
        Schema::enableForeignKeyConstraints();

    }
}
