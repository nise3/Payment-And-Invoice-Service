<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use phpDocumentor\Reflection\Types\Context;

class PaymentPurpose extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE;

    public function paymentConfigurations(string $gatewayType = null): BelongsToMany
    {
        $relation = $this->belongsToMany(PaymentConfiguration::class, "payment_purpose_configuration");
        if ($gatewayType) {
            $relation->where("payment_configurations.gateway_type", $gatewayType);
        }
        return $relation;
    }

}
