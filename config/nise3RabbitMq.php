<?php

use App\Helpers\Classes\PaymentHelper;

return [
    'exchanges' => [
        PaymentHelper::PURPOSE_COURSE_ENROLLMENT => [
            'name' => 'payment.course-enrollment.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'payment.course-enrollment.alternate.x',
                'type' => 'fanout',
                'durable' => true,
                'autoDelete' => false,
                'queue' => 'payment.course-enrollment.alternate.q',
                'queueDurable' => true,
                'queueAutoDelete' => false,
                'queueMode' => 'lazy',
            ],
            'dlx' => [
                'name' => 'payment.course-enrollment.dlx',
                'type' => 'topic',
                'durable' => true,
                'autoDelete' => false
            ],
            'queue' => [
                'demo' => [
                    'name' => 'payment.course-enrollment.q',
                    'binding' => 'payment.course-enrollment',
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' => 'payment.course-enrollment.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ]
            ],
        ],
        PaymentHelper::PURPOSE_ASSOCIATION_NASCIB_MEMBERSHIP => [
            'name' => 'payment.association-nascib-membership.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'payment.association-nascib-membership.alternate.x',
                'type' => 'fanout',
                'durable' => true,
                'autoDelete' => false,
                'queue' => 'payment.association-nascib-membership.alternate.q',
                'queueDurable' => true,
                'queueAutoDelete' => false,
                'queueMode' => 'lazy',
            ],
            'dlx' => [
                'name' => 'payment.association-nascib-membership.dlx',
                'type' => 'topic',
                'durable' => true,
                'autoDelete' => false
            ],
            'queue' => [
                'demo' => [
                    'name' => 'payment.association-nascib-membership.q',
                    'binding' => 'payment.association-nascib-membership',
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' => 'payment.association-nascib-membership.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ]
            ],
        ],
        PaymentHelper::PURPOSE_RPL_CERTIFICATION_APPLICATION => [
            'name' => 'payment.rpl-certification-application.x',
            'type' => 'topic',
            'durable' => true,
            'autoDelete' => false,
            'alternateExchange' => [
                'name' => 'payment.rpl-certification-application.alternate.x',
                'type' => 'fanout',
                'durable' => true,
                'autoDelete' => false,
                'queue' => 'payment.rpl-certification-application.alternate.q',
                'queueDurable' => true,
                'queueAutoDelete' => false,
                'queueMode' => 'lazy',
            ],
            'dlx' => [
                'name' => 'payment.rpl-certification-application.dlx',
                'type' => 'topic',
                'durable' => true,
                'autoDelete' => false
            ],
            'queue' => [
                'demo' => [
                    'name' => 'payment.rpl-certification-application.q',
                    'binding' => 'payment.rpl-certification-application',
                    'durable' => true,
                    'autoDelete' => false,
                    'queueMode' => 'lazy',
                    'dlq' => [
                        'name' => 'payment.rpl-certification-application.dlq',
                        'x_message_ttl' => 50000,
                        'durable' => true,
                        'autoDelete' => false,
                        'queueMode' => 'lazy'
                    ],
                ]
            ],
        ],
    ],
    'consume' => 'institute.course.enrollment.q,institute.batch.calender.q'
];
