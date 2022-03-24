<?php

namespace App\Helpers\Classes;

use Enqueue\RdKafka\RdKafkaConnectionFactory;

abstract class KafkaConnector
{
    public array $config;

    public function __construct()
    {
        $this->config = [
            'global' => [
                'group.id' => "group",
                'metadata.broker.list' => 'localhost:9092',
                'enable.auto.commit' => 'false',
            ],
            'topic' => [
                'auto.offset.reset' => 'beginning',
            ],
        ];
    }

    public function connectionBuilder(): \Interop\Queue\Context|\Enqueue\RdKafka\RdKafkaContext
    {
        $connectionFactory = new RdKafkaConnectionFactory($this->config);
        return $connectionFactory->createContext();
    }
}
