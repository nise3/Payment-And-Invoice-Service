<?php

use App\Helpers\Classes\PaymentHelper;
use Ramsey\Uuid\Uuid;

return [
    "ipn_url" => env("IPN_URL", 'https://apim-gateway.nise.gov.bd/payment-gateway-ipn-endpoint/1.0.0/public/ipn') . '/' . Uuid::uuid4(),
    "payment_gateways" => [
        "transaction_currency" => 'BDT',
        PaymentHelper::GATEWAY_EKPAY => [
            "sandbox" => [
                'ipn_email' => 'noreply@nise.gov.bd',
                'api_credential' => [
                    'merchant_id' => 'nise_test', //mer_reg_id
                    'password' => 'NiSe@TsT11' //mer_pass_key
                ]
            ],
            "production" => [
                'ipn_email' => 'noreply@nise.gov.bd',
                'api_credential' => [
                    'merchant_id' => 'nise_mer',
                    'password' => 'NiscE@ekP02'
                ]
            ],
        ],
        PaymentHelper::GATEWAY_SSLCOMMERZ => [
            'sandbox' => [
                'api_credential' => [
                    'merchant_id' => 'nise6213e7cbf22a4', //store_id
                    'password' => 'nise6213e7cbf22a4@ssl', //store_password
                ]
            ],
            'production' => [
                'api_credential' => [
                    'merchant_id' => 'nasciborgbdlive',
                    'password' => '612234D7EAA9D58156',
                ]
            ]
        ]
    ]
];
