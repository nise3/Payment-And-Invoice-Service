<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            PaymentConfigurationSeeder::class,
            PaymentPurposeSeeder::class,
            InvoicePessimisticLockingSeeder::class //run seed for first time
        ]);

    }
}
