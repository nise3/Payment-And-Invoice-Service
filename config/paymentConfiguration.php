<?php
return [
    "transaction_currency" => 'BDT',
    "ek_pay" => [
        "sandbox" => [
            'ipn_email' => 'noreply@nise.gov.bd',
            'mer_info' => [
                'mer_reg_id' => 'nise_test',
                'mer_pas_key' => 'NiSe@TsT11'
            ]
        ],
        "production" => [
            'ipn_email' => 'noreply@nise.gov.bd',
            'mer_info' => [
                'mer_reg_id' => 'nise_mer',
                'mer_pas_key' => 'NiscE@ekP02'
            ]
        ],
    ],
    "ssl_commerz" => [
        'sandbox' => [
            'apiCredentials' => [
                'store_id' => 'nise6213e7cbf22a4',
                'store_password' => 'nise6213e7cbf22a4@ssl',
            ]
        ],
        'production' => [
            'apiCredentials' => [
                'store_id' => 'nasciborgbdlive',
                'store_password' => '612234D7EAA9D58156',
            ]
        ]
    ]
];
