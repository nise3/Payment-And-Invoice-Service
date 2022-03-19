<?php

namespace Database\Seeders;

use App\Models\InvoicePessimisticLocking;
use App\Models\PaymentPurpose;
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
                "purpose" => PaymentPurpose::PAYMENT_PURPOSE_CODE_OTHER
            ],
            [
                "last_incremental_value" => 0,
                "purpose" => PaymentPurpose::PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT
            ],
            [
                "last_incremental_value" => 0,
                "purpose" => PaymentPurpose::PAYMENT_PURPOSE_CODE_NASCIB_MEMBERSHIP_PAYMENT
            ],
            [
                "last_incremental_value" => 0,
                "purpose" => PaymentPurpose::PAYMENT_PURPOSE_CODE_RTO_APPLICATION
            ],
        ];
        InvoicePessimisticLocking::insert($purposeRelatedInvoiceInitialData);
    }
}
