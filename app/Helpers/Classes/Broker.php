<?php

namespace App\Helpers\Classes;

class Broker extends KafkaConnector
{
    public function publishOn(string $topic, mixed $message)
    {
        if (is_array($message)) {
            $message = json_encode($message);
        }
        $topic = $this->connectionBuilder()->createTopic($topic);
        $message = $this->connectionBuilder()->createMessage($message);
        $this->connectionBuilder()->createProducer()->send($topic, $message);
    }

    public function subscribeOn(string $topic, string $broker = null): \Enqueue\RdKafka\RdKafkaConsumer|\Interop\Queue\Consumer
    {
        $topic = $this->connectionBuilder()->createQueue($topic);
        return $this->connectionBuilder()->createConsumer($topic);
        // Enable async commit to gain better performance (true by default since version 0.9.9).
        //$consumer->setCommitAsync(true);

    }
}
