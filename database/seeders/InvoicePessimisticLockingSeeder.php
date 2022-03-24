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
                "last_incremental_value" => 0,
                "purpose" => PaymentHelper::PURPOSE_COURSE_ENROLLMENT
            ],
            [
                "last_incremental_value" => 0,
                "purpose" => PaymentHelper::PURPOSE_RPL_CERTIFICATION_APPLICATION
            ],
            [
                "last_incremental_value" => 0,
                "purpose" => PaymentHelper::PURPOSE_RTO_TO_BTEB
            ],
            [
                "last_incremental_value" => 0,
                "purpose" => PaymentHelper::PURPOSE_ASSOCIATION_NASCIB_MEMBERSHIP
            ],
        ];
        InvoicePessimisticLocking::insert($purposeRelatedInvoiceInitialData);
    }
}
