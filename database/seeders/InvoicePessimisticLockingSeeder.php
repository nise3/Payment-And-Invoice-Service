<?php

namespace Database\Seeders;

use App\Helpers\Classes\PaymentHelper;
use App\Models\InvoicePessimisticLocking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class InvoicePessimisticLockingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        InvoicePessimisticLocking::query()->truncate();
        $purposeRelatedInvoiceInitialData = [
            [
                "last_incremental_value" => 50
            ]
        ];
        InvoicePessimisticLocking::insert($purposeRelatedInvoiceInitialData);
    }
}
