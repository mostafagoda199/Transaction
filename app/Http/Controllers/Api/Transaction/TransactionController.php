<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Domain\Service\Interfaces\ITransactionService;
use App\Domain\Shared\Responder\Interfaces\IApiHttpResponder;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionReportResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{

    public function __construct(
        private readonly ITransactionService $transactionService,
        private readonly IApiHttpResponder $apiHttpResponder
    ){
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', [Transaction::class]);
        $transactions = $this->transactionService->listTransactions();
        return TransactionResource::collection($transactions);
    }

    public function store(TransactionRequest $transactionRequest): JsonResponse
    {
        $this->transactionService->storeTransaction($transactionRequest->validated());
        return $this->apiHttpResponder->response(
            message: trans('Payment submitted successfully.'),
            status: Response::HTTP_CREATED);
    }

    public function getTransactionReportForPeriod(): AnonymousResourceCollection
    {
        return TransactionReportResource::collection($this->transactionService->generateTransactionReport()->values());
    }
}
