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
                "configuration_owner" => PaymentConfiguration::PAYMENT_CONFIG_OWNER_INDUSTRY_ASSOCIATION,
                "configuration_owner_id" => 1,
                "payment_gateway_type" => PaymentConfiguration::EK_PAY_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::EK_PAY_LABEL))
            ],
            [
                "id" => 2,
                "configuration_owner" => PaymentConfiguration::PAYMENT_CONFIG_OWNER_INDUSTRY_ASSOCIATION,
                "configuration_owner_id" => 1,
                "payment_gateway_type" => PaymentConfiguration::SSLCOMMERZ_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::SSLCOMMERZ_LABEL))
            ],

            [
                "id" => 3,
                "configuration_owner" => PaymentConfiguration::PAYMENT_CONFIG_OWNER_INDUSTRY,
                "configuration_owner_id" => 1,
                "payment_gateway_type" => PaymentConfiguration::EK_PAY_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::EK_PAY_LABEL))
            ],
            [
                "id" => 4,
                "configuration_owner" => PaymentConfiguration::PAYMENT_CONFIG_OWNER_INDUSTRY,
                "configuration_owner_id" => 1,
                "payment_gateway_type" => PaymentConfiguration::SSLCOMMERZ_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::SSLCOMMERZ_LABEL))
            ],
            [
                "id" => 5,
                "configuration_owner" => PaymentConfiguration::PAYMENT_CONFIG_OWNER_INSTITUTE,
                "configuration_owner_id" => 1,
                "payment_gateway_type" => PaymentConfiguration::EK_PAY_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::EK_PAY_LABEL))
            ],
            [
                "id" => 6,
                "configuration_owner" => PaymentConfiguration::PAYMENT_CONFIG_OWNER_INSTITUTE,
                "configuration_owner_id" => 1,
                "payment_gateway_type" => PaymentConfiguration::SSLCOMMERZ_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::SSLCOMMERZ_LABEL))
            ],
            [
                "id" => 7,
                "configuration_owner" => PaymentConfiguration::PAYMENT_CONFIG_OWNER_RTO,
                "configuration_owner_id" => 1,
                "payment_gateway_type" => PaymentConfiguration::EK_PAY_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::EK_PAY_LABEL))
            ],
            [
                "id" => 8,
                "configuration_owner" => PaymentConfiguration::PAYMENT_CONFIG_OWNER_RTO,
                "configuration_owner_id" => 1,
                "payment_gateway_type" => PaymentConfiguration::SSLCOMMERZ_LABEL,
                "configuration" => json_encode(config('paymentConfiguration.payment_gateways.' . PaymentConfiguration::SSLCOMMERZ_LABEL))
            ]
        ];

        PaymentConfiguration::insert($configurations);
        Schema::enableForeignKeyConstraints();

    }
}
