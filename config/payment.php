<?php

/** Payment Gateways */

use Ramsey\Uuid\Uuid;

const GATEWAY_EKPAY = 'EKPAY';
const GATEWAY_SSLCOMMERZ = 'SSLCOMMERZ';
const GATEWAY_BKASH = 'BKASH';
const GATEWAY_NAGAD = 'NAGAD';
const GATEWAY_PORTWALLET = 'PORTWALLET';
const GATEWAY_SHURJOPAY = 'SHURJOPAY';
const GATEWAY_AAMARPAY = 'AAMARPAY';
const GATEWAY_2CHECKOUT = '2CHECKOUT';
const GATEWAY_AUTHORIZEDOTNET = 'AUTHORIZEDOTNET';
const GATEWAY_STRIPE = 'STRIPE';
const GATEWAY_PAYPAL = 'PAYPAL';

/** Payment Purposes */
const PURPOSE_COURSE_ENROLLMENT = 'COURSE_ENROLLMENT';
const PURPOSE_ASSOCIATION_MEMBERSHIP = 'ASSOCIATION_MEMBERSHIP';
const PURPOSE_RPL_CERTIFICATION_APPLICATION = 'RPL_CERTIFICATION_APPLICATION';
const PURPOSE_RTO_TO_BTEB = 'RTO_TO_BTEB';

/** Payment Config Accessors */

const PAYMENT_CONFIG_ACCESSOR_INDUSTRY_ASSOCIATION = "INDUSTRY_ASSOCIATION";
const PAYMENT_CONFIG_ACCESSOR_INDUSTRY = "INDUSTRY";
const PAYMENT_CONFIG_ACCESSOR_INSTITUTE = "INSTITUTE";
const PAYMENT_CONFIG_ACCESSOR_RTO = "RTO";

return [
    'all_payment_gateways' => [
        GATEWAY_EKPAY => 'Ekpay',
        GATEWAY_SSLCOMMERZ => 'SSLCOMMERZ',
        GATEWAY_BKASH => 'bKash',
        GATEWAY_NAGAD => 'Nagad',
        GATEWAY_PORTWALLET => 'PortWallet',
        GATEWAY_SHURJOPAY => 'ShurjaPay',
        GATEWAY_AAMARPAY => 'Aamarpay',
        GATEWAY_2CHECKOUT => '2Checkout',
        GATEWAY_AUTHORIZEDOTNET => 'Authorize.net',
        GATEWAY_STRIPE => 'Stripe',
        GATEWAY_PAYPAL => 'Paypal'
    ],
    'all_payment_purposes' => [
        PURPOSE_COURSE_ENROLLMENT,
        PURPOSE_ASSOCIATION_MEMBERSHIP,
        PURPOSE_RPL_CERTIFICATION_APPLICATION,
        PURPOSE_RTO_TO_BTEB,
    ],
    'all_accessors' => [
        PAYMENT_CONFIG_ACCESSOR_INDUSTRY_ASSOCIATION => "Industry Association",
        PAYMENT_CONFIG_ACCESSOR_INDUSTRY => "Industry",
        PAYMENT_CONFIG_ACCESSOR_INSTITUTE => "Institute",
        PAYMENT_CONFIG_ACCESSOR_RTO => "RTO",
    ],
    "purpose_related_invoice_prefix"=>[
            PURPOSE_COURSE_ENROLLMENT => "EN",
            PURPOSE_ASSOCIATION_MEMBERSHIP => "NM",
            PURPOSE_RPL_CERTIFICATION_APPLICATION => "RA",
            PURPOSE_RTO_TO_BTEB => "OP",
    ],
    "payment_gateways" => [
        "ipn_url" => env("IPN_URL", 'https://apim-gateway.nise.gov.bd/payment-gateway-ipn-endpoint/1.0.0/public/ipn') . '/' . Uuid::uuid4(),
        "transaction_currency" => 'BDT',
        GATEWAY_EKPAY => [
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
        GATEWAY_SSLCOMMERZ => [
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
