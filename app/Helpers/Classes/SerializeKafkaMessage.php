<?php

namespace App\Helpers\Classes;
use Enqueue\RdKafka\Serializer;
use Enqueue\RdKafka\RdKafkaMessage;
class SerializeKafkaMessage implements Serializer
{

    public function toString(RdKafkaMessage $message): string
    {
        // TODO: Implement toString() method.
    }

    public function toMessage(string $string): RdKafkaMessage
    {
        // TODO: Implement toMessage() method.
    }
}
