<?php
return [
    'ipn_uri' => 'http://localhost:8001/api/v1/course-enrollment/payment-by-ek-pay/ipn-handler/{secretToken}',
    "ipn_channel" => '1',
    "sandbox" => [
        "ekpay_base_uri" => 'https://sandbox.ekpay.gov.bd/ekpaypg/v1',
        "mac_addr" => '1.1.1.1'
    ],
    "production" => [
        "ekpay_base_uri" => 'https://pg.ekpay.gov.bd/ekpaypg/v1',
        "mac_addr" => '180.148.214.186',
    ]

];
