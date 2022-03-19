<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use phpDocumentor\Reflection\Types\Context;

class PaymentPurpose extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE;
    public const PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT = "COURSE_ENROLLMENT";
    public const PAYMENT_PURPOSE_CODE_NASCIB_MEMBERSHIP_PAYMENT = "NASCIB_MEMBERSHIP_PAYMENT";
    public const PAYMENT_PURPOSE_CODE_RTO_APPLICATION = "RTO_APPLICATION";
    public const PAYMENT_PURPOSE_CODE_OTHER = "OTHER";

    public function paymentConfigurations(): BelongsToMany
    {
        return $this->belongsToMany(PaymentConfiguration::class, "payment_purpose_configuration");
    }

    public const PURPOSE_RELATED_INVOICE_PREFIX = [
        self::PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT => "EN",
        self::PAYMENT_PURPOSE_CODE_NASCIB_MEMBERSHIP_PAYMENT => "NM",
        self::PAYMENT_PURPOSE_CODE_RTO_APPLICATION => "RA",
        self::PAYMENT_PURPOSE_CODE_OTHER => "OP",
    ];

}
