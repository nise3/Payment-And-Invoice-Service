<?php

namespace App\Providers;

use App\Events\PaymentSuccessEvent;
use App\Listeners\PaymentSuccessListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PaymentSuccessEvent::class => [
            PaymentSuccessListener::class
        ]
    ];
}
