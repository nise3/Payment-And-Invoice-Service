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

    public const PAYMENT_PURPOSES = [
        self::PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT => "Course Enrollment Payment",
        self::PAYMENT_PURPOSE_CODE_NASCIB_MEMBERSHIP_PAYMENT => "Nascib Membership Payment",
        self::PAYMENT_PURPOSE_CODE_RTO_APPLICATION => "RTO Application Payment",
        self::PAYMENT_PURPOSE_CODE_OTHER => "Other Payment",
    ];

    public const PURPOSE_RELATED_INVOICE_PREFIX = [
        self::PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT => "EN",
        self::PAYMENT_PURPOSE_CODE_NASCIB_MEMBERSHIP_PAYMENT => "NM",
        self::PAYMENT_PURPOSE_CODE_RTO_APPLICATION => "RA",
        self::PAYMENT_PURPOSE_CODE_OTHER => "OP",
    ];

    public const PURPOSE_RELATED_INVOICE_SIZE = [
        self::PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT => 36,
        self::PAYMENT_PURPOSE_CODE_NASCIB_MEMBERSHIP_PAYMENT =>36,
        self::PAYMENT_PURPOSE_CODE_RTO_APPLICATION => 36,
        self::PAYMENT_PURPOSE_CODE_OTHER => 36,
    ];

    public function paymentConfigurations(string $gatewayType = null): BelongsToMany
    {
        $relation = $this->belongsToMany(PaymentConfiguration::class, "payment_purpose_configuration");
        if ($gatewayType) {
            $relation->where("payment_configurations.gateway_type", $gatewayType);
        }
        return $relation;
    }

}
