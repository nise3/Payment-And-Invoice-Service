<?php

namespace Database\Seeders;

use App\Helpers\Classes\PaymentHelper;
use App\Models\PaymentPurpose;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaymentPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        PaymentPurpose::query()->truncate();
        DB::table('payment_purpose_configuration')->truncate();
        $purposes = [
            [
                "id" => 1,
                "code" => PaymentHelper::PURPOSE_COURSE_ENROLLMENT,
                "title" => "Course Enrollment Payment",
                "title_en" => "Course Enrollment Payment",
                "invoice_prefix"=>PaymentHelper::PURPOSE_RELATED_INVOICE_PREFIX[PaymentHelper::PURPOSE_COURSE_ENROLLMENT],
                "invoice_key_size"=>PaymentHelper::INVOICE_SIZE
            ],
            [
                "id" => 2,
                "code" => PaymentHelper::PURPOSE_ASSOCIATION_NASCIB_MEMBERSHIP,
                "title" => "Nascib Membership Payment",
                "title_en" => "Nascib Membership Payment",
                "invoice_prefix"=>PaymentHelper::PURPOSE_RELATED_INVOICE_PREFIX[PaymentHelper::PURPOSE_ASSOCIATION_NASCIB_MEMBERSHIP],
                "invoice_key_size"=>PaymentHelper::INVOICE_SIZE
            ],
            [
                "id" => 3,
                "code" => PaymentHelper::PURPOSE_RPL_CERTIFICATION_APPLICATION,
                "title" => "RTO Application Payment",
                "title_en" => "RTO Application Payment",
                "invoice_prefix"=>PaymentHelper::PURPOSE_RELATED_INVOICE_PREFIX[PaymentHelper::PURPOSE_RPL_CERTIFICATION_APPLICATION],
                "invoice_key_size"=>PaymentHelper::INVOICE_SIZE
            ]
        ];

        PaymentPurpose::insert($purposes);

        /** Associate Data Sync */
        DB::table('payment_purpose_configuration')->insert([
            [
                "payment_purpose_id" => 1,
                "payment_configuration_id" => 5 //Ek Pay PaymentGateway
            ],
            [
                "payment_purpose_id" => 2,
                "payment_configuration_id" => 1 //SSL Commerz PaymentGateway
            ],
            [
                "payment_purpose_id" => 3,
                "payment_configuration_id" => 7 ////Ek Pay PaymentGateway
            ]
        ]);

        Schema::enableForeignKeyConstraints();

    }
}
