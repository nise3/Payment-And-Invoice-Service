<?php

namespace App\Models;


class PaymentConfiguration extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;

    protected $casts = [
        "configuration" => "array"
    ];

}
