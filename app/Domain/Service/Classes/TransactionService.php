<?php

namespace App\Domain\Service\Classes;

use App\Domain\Repositories\Interfaces\ITransactionRepository;
use App\Domain\Service\Interfaces\ITransactionService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionService implements ITransactionService
{
    private const GUEST_ROLE = 'customer';

    public function __construct(
        private readonly ITransactionRepository $transactionRepository
    ){
    }

    public function listTransactions(): LengthAwarePaginator
    {
       if (auth()->user()->role->slug === self::GUEST_ROLE){
           return $this->transactionRepository->retrieve(conditions: [
               'user_id' => auth()->user()->id
           ],relations: ['payer','payments']);
       }
       return $this->transactionRepository->retrieve(relations: ['payer']);
    }

    public function storeTransaction(array $transactionRequest): void
    {
        $transactionRequest['user_id'] = $transactionRequest['payer'];
        $this->transactionRepository->create($transactionRequest);
    }

    public function generateTransactionReport()
    {
       return $this->transactionRepository->generateTransactionReportByDateRange();
    }
}
