<?php

namespace Database\Seeders;

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
        $configurations = [
            ["id" => 1,
                "accessor" => PaymentConfiguration::PAYMENT_CONFIG_ACCESSOR_INDUSTRY_ASSOCIATION,
                "accessor_id" => 1,
                "gateway_type" => PaymentConfiguration::EK_PAY_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::EK_PAY_LABEL))
            ],
            [
                "id" => 2,
                "accessor" => PaymentConfiguration::PAYMENT_CONFIG_ACCESSOR_INDUSTRY_ASSOCIATION,
                "accessor_id" => 1,
                "gateway_type" => PaymentConfiguration::SSLCOMMERZ_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::SSLCOMMERZ_LABEL))
            ],

            [
                "id" => 3,
                "accessor" => PaymentConfiguration::PAYMENT_CONFIG_ACCESSOR_INDUSTRY,
                "accessor_id" => 1,
                "gateway_type" => PaymentConfiguration::EK_PAY_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::EK_PAY_LABEL))
            ],
            [
                "id" => 4,
                "accessor" => PaymentConfiguration::PAYMENT_CONFIG_ACCESSOR_INDUSTRY,
                "accessor_id" => 1,
                "gateway_type" => PaymentConfiguration::SSLCOMMERZ_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::SSLCOMMERZ_LABEL))
            ],
            [
                "id" => 5,
                "accessor" => PaymentConfiguration::PAYMENT_CONFIG_ACCESSOR_INSTITUTE,
                "accessor_id" => 1,
                "gateway_type" => PaymentConfiguration::EK_PAY_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::EK_PAY_LABEL))
            ],
            [
                "id" => 6,
                "accessor" => PaymentConfiguration::PAYMENT_CONFIG_ACCESSOR_INSTITUTE,
                "accessor_id" => 1,
                "gateway_type" => PaymentConfiguration::SSLCOMMERZ_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::SSLCOMMERZ_LABEL))
            ],
            [
                "id" => 7,
                "accessor" => PaymentConfiguration::PAYMENT_CONFIG_ACCESSOR_RTO,
                "accessor_id" => 1,
                "gateway_type" => PaymentConfiguration::EK_PAY_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::EK_PAY_LABEL))
            ],
            [
                "id" => 8,
                "accessor" => PaymentConfiguration::PAYMENT_CONFIG_ACCESSOR_RTO,
                "accessor_id" => 1,
                "gateway_type" => PaymentConfiguration::SSLCOMMERZ_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::SSLCOMMERZ_LABEL))
            ]
        ];

        PaymentConfiguration::insert($configurations);
        Schema::enableForeignKeyConstraints();

    }
}
