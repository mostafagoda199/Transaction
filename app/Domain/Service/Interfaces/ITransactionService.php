<?php

namespace App\Domain\Service\Interfaces;

interface ITransactionService
{
    public function listTransactions();
    public function storeTransaction(array $transactionRequest);
    public function generateTransactionReport();
}
