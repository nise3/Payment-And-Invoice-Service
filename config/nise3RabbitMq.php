<?php

use App\Helpers\Classes\PaymentHelper;

return [
    'exchanges' => [
        PaymentHelper::INDUSTRY_ASSOCIATION_PAYMENT => [
            'name' => PaymentHelper::INDUSTRY_ASSOCIATION_PAYMENT.'.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => PaymentHelper::INDUSTRY_ASSOCIATION_PAYMENT.'.alternate.x',
                'type' => 'fanout',
                'durable' => true,
                'autoDelete' => false,
                'queue' => PaymentHelper::INDUSTRY_ASSOCIATION_PAYMENT.'.alternate.q',
                'queueDurable' => true,
                'queueAutoDelete' => false,
                'queueMode' => 'lazy',
            ],
            'dlx' => [
                'name' => PaymentHelper::INDUSTRY_ASSOCIATION_PAYMENT.'.dlx',
                'type' => 'topic',
                'durable' => true,
                'autoDelete' => false
            ],
            'queue' => [
                PaymentHelper::INDUSTRY_ASSOCIATION_PAYMENT => [
                    'name' => PaymentHelper::INDUSTRY_ASSOCIATION_PAYMENT.'.q',
                    'binding' => PaymentHelper::INDUSTRY_ASSOCIATION_PAYMENT,
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' => PaymentHelper::INDUSTRY_ASSOCIATION_PAYMENT.'.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ]
            ],
        ],
        PaymentHelper::INSTITUTE_PAYMENT => [
            'name' =>  PaymentHelper::INSTITUTE_PAYMENT.'.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' =>  PaymentHelper::INSTITUTE_PAYMENT.'.alternate.x',
                'type' => 'fanout',
                'durable' => true,
                'autoDelete' => false,
                'queue' =>  PaymentHelper::INSTITUTE_PAYMENT.'.alternate.q',
                'queueDurable' => true,
                'queueAutoDelete' => false,
                'queueMode' => 'lazy',
            ],
            'dlx' => [
                'name' =>  PaymentHelper::INSTITUTE_PAYMENT.'.dlx',
                'type' => 'topic',
                'durable' => true,
                'autoDelete' => false
            ],
            'queue' => [
                PaymentHelper::INSTITUTE_PAYMENT => [
                    'name' =>  PaymentHelper::INSTITUTE_PAYMENT.'.q',
                    'binding' =>  PaymentHelper::INSTITUTE_PAYMENT,
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' =>  PaymentHelper::INSTITUTE_PAYMENT.'.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ]
            ],
        ],
    ],
    'consume' => 'payment_institute.q,payment_industry_association.q'
];
