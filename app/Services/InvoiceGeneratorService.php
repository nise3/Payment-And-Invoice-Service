<?php

namespace App\Services;

use App\Facade\ServiceToServiceCall;
use App\Helpers\Classes\PaymentHelper;
use App\Models\BaseModel;
use App\Models\InvoicePessimisticLocking;
use App\Models\PaymentPurpose;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 *
 */
class InvoiceGeneratorService
{


    /**
     * @throws Throwable
     */
    public static function getNewInvoiceCode(string $purpose): string
    {
        DB::beginTransaction();
        try {
            $paymentPurpose = PaymentPurpose::where('code', $purpose)->firstOrFail();
            /** @var InvoicePessimisticLocking $existingSSPCode */
            $existingCode = InvoicePessimisticLocking::lockForUpdate()->first();
            $code = !empty($existingCode) && $existingCode->last_incremental_value ? $existingCode->last_incremental_value : 0;
            $code = $code + 1;
            $invoicePrefix= $paymentPurpose->invoice_prefix;
            $invoiceSize = $paymentPurpose->invoice_key_size ?: PaymentHelper::INVOICE_SIZE;
            $padSize = $invoiceSize - strlen($code);
            /**
             * Prefix+000000N. Ex: EN+incremental number
             */
            $invoice = str_pad($invoicePrefix, $padSize, '0', STR_PAD_RIGHT) . $code;

            /**
             * Code Update
             */
            if ($existingCode) {
                $existingCode->last_incremental_value = $code;
                $existingCode->save();
            } else {
                InvoicePessimisticLocking::create([
                    "last_incremental_value" => $code
                ]);
            }
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            throw $throwable;
        }
        return $invoice;
    }
}
