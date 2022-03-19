<?php

namespace App\Services\EkPay\Lib;

use App\Models\PaymentTransactionHistory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

abstract class AbstractEkPayService implements EkPayInterface
{

    public function validation(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "payment_purpose" => [
                "required",
                "string"
            ],
            "payment_purpose_related_id" => [
                "required"
            ],
            "feed_uri.success" => [
                "required",
                "string"
            ],
            "feed_uri.failed" => [
                "required",
                "string"
            ],
            "feed_uri.cancel" => [
                "required",
                "string"
            ],
            "customer_id" => [
                "required"
            ],
            "customer_name" => [
                "required"
            ],
            "customer_email" => [
                "required"
            ],
            "customer_mobile_no" => [
                "required"
            ],
            "customer_mail_address" => [
                "nullable"
            ],
            "transaction_amount" => [
                "required",
                "numeric",
                "gt:0"
            ],
            "transaction_currency" => [
                "required",
                "string",
                Rule::in([
                    "BDT"
                ])
            ],
            "order_detail" => [
                "nullable",
                "string"
            ]
        ];

        return Validator::make($data, $rules);
    }

    public function buildPayload(array $data)
    {

    }
}
