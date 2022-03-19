<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class PaymentSubscriber extends Command
{
    protected $signature = 'payment:subscriber';

    protected $description = 'Payment Status Change';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Redis::psubscribe(['payment.*'], function ($message, $channel) {
            Log::info("redis- " . json_encode([$message, $channel]));
        });
    }
}
