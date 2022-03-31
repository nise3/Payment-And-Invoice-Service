<?php

namespace App\Listeners;

use App\Events\PaymentSuccessEvent;
use App\Facade\RabbitMQFacade;
use App\Services\RabbitMQService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Connectors\RabbitMQConnector;

class PaymentSuccessListener implements ShouldQueue
{

    private RabbitMQConnector $connector;
    private RabbitMQService $rabbitmqService;
    /**
     * @throws Exception
     */
    public function __construct(RabbitMQConnector $connector, RabbitMQService $rabbitmqService)
    {

        $this->connector = $connector;
        $this->rabbitmqService = $rabbitmqService;

        RabbitMQFacade::publishEvent(
            $this->connector,
            $this->rabbitmqService,
            request()->offsetGet('exchange_name'),
            request()->offsetGet('queue_config_name'),
            request()->offsetGet('retry_mechanism'),
        );
    }

    public function handle(PaymentSuccessEvent $paymentSuccessEvent)
    {

    }

}
