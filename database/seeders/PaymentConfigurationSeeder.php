<?php

namespace Database\Seeders;

use App\Models\PaymentConfiguration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PaymentConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        PaymentConfiguration::query()->truncate();

    }
}
