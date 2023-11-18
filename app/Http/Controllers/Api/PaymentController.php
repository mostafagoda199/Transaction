<?php

namespace App\Http\Controllers\Api;

use App\Domain\Service\Interfaces\IPaymentService;
use App\Domain\Shared\Responder\Interfaces\IApiHttpResponder;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRecordRequest;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function __construct(private readonly IApiHttpResponder $apiHttpResponder, private readonly IPaymentService $paymentService){
    }

    public function store(PaymentRecordRequest $paymentRecordRequest): JsonResponse
    {
        $this->paymentService->recordPayment($paymentRecordRequest->validated());

        return $this->apiHttpResponder->response(message: trans('Payment submitted successfully.'));
    }

}
