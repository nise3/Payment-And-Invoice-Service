<?php

return [
    "ipn_url" => env('SSL_COMMERZ_IPN_FOR_MEMBERSHIP_PAYMENT_SANDBOX', 'https://apim-gateway.nise.gov.bd/org-payment-gateway-ipn-endpoint/1.0.0/public/nascib-members/payment/pay-via-ssl/ipn'),
    'apiUrl' => [
        'make_payment' => '/gwprocess/v4/api.php',
        'refund_status' => '/validator/api/merchantTransIDvalidationAPI.php',
        'order_validate' => '/validator/api/validationserverAPI.php',
        'refund_payment' => '/validator/api/merchantTransIDvalidationAPI.php',
        'transaction_status' => '/validator/api/merchantTransIDvalidationAPI.php',
    ],
    'projectPath' => '',
    'sandbox' => [
        'apiDomain' => 'https://sandbox.sslcommerz.com'
    ],
    'production' => [
        'apiDomain' => 'https://merchant.sslcommerz.com',
    ]
];
