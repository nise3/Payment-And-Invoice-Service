<?php

namespace Database\Seeders;

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
                "code" => PaymentPurpose::PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT,
                "title" => "Course Enrollment Payment",
                "title_en" => "Course Enrollment Payment"
            ],
            [
                "id" => 2,
                "code" => PaymentPurpose::PAYMENT_PURPOSE_CODE_NASCIB_MEMBERSHIP_PAYMENT,
                "title" => "Nascib Membership Payment",
                "title_en" => "Nascib Membership Payment"
            ],
            [
                "id" => 3,
                "code" => PaymentPurpose::PAYMENT_PURPOSE_CODE_RTO_APPLICATION,
                "title" => "RTO Application Payment",
                "title_en" => "RTO Application Payment"
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
