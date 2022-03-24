<?php

namespace App\Models;

use Carbon\Carbon;
use PHPUnit\Util\Json;

/**
 * Class PaymentTransactionHistory
 * @property int id
 * @property string invoice
 * @property string mer_trnx_id
 * @property string trnx
 * @property int payment_purpose_related_id
 * @property int payment_purpose_code
 * @property int payment_gateway_type
 * @property string customer_identity_code
 * @property string customer_name
 * @property string customer_mobile
 * @property string customer_email
 * @property double amount
 * @property double paid_amount
 * @property string trnx_currency
 * @property json request_payload
 * @property json response_message
 * @property int status
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class PaymentTransactionHistory extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE;
    protected $casts = [
        "request_payload" => 'array',
        "response_message" => "array"
    ];
}
