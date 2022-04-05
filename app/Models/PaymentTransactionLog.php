<?php

namespace App\Models;

use Carbon\Carbon;
use Psy\Util\Json;

/**
 * Class PaymentTransactionLog
 * @property int id
 * @property int payment_transaction_history_id
 * @property string invoice
 * @property string mer_trnx_id
 * @property string trnx_id
 * @property int payment_purpose_related_id
 * @property int payment_purpose
 * @property int payment_gateway_type
 * @property double amount
 * @property double paid_amount
 * @property string trnx_currency
 * @property Json request_payload
 * @property Json response_message
 * @property int status
 * @property string ipn_uri_secret_token
 * @property Carbon transaction_created_at
 * @property Carbon transaction_completed_at
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class PaymentTransactionLog extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE;

    protected $casts = [
        "request_payload" => 'array',
        "response_message" => "array"
    ];
}
