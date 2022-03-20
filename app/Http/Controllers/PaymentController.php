<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function ipnHandler(Request $request)
    {

    }
}
