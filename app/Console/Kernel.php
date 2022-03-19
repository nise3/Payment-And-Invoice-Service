<?php

namespace App\Console;

use App\Console\Commands\PaymentSubscriber;
use App\Models\PaymentPurpose;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Redis;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       PaymentSubscriber::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    }
}
