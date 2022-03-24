<?php

namespace App\Http\Controllers;

use App\Facade\ServiceToServiceCall;
use App\Models\PaymentTransactionHistory;
use App\Models\PaymentTransactionLog;
use App\Models\RplApplication;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class PaymentController extends Controller
{
    public PaymentService $paymentService;
    public Carbon $startTime;

    /**
     * @param PaymentService $paymentService
     * @param Carbon $startTime
     */
    public function __construct(PaymentService $paymentService, Carbon $startTime)
    {
        $this->paymentService = $paymentService;
        $this->startTime = Carbon::now();
    }


    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function payNow(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $this->paymentService->validation($request)->validate();
        [$status, $message, $gatewayUrl] = $this->paymentService->processing($validatedData);
        $responseStatusCode = $status ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;
        if ($status) {
            $response['gateway_url'] = $gatewayUrl;
        }
        $response['_response_status'] = [
            "success" => $status,
            "code" => $responseStatusCode,
            "message" => $message,
            "query_time" => $this->startTime->diffInSeconds(\Illuminate\Support\Carbon::now()),
        ];
        return Response::json($response, $responseStatusCode);

    }

    public function ipn(Request $request, string $secretToken)
    {
        Log::debug("ipn-response", $request->all());

        if (PaymentService::checkSecretToken($secretToken)) {
            DB::beginTransaction();
            try {
                $this->paymentService->handleIpn($request,$secretToken);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                throw $exception;
            }
        } else {
            Log::debug('ipn-handler-secret-token-info', $request->all());
        }
    }
}
