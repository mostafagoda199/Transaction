<?php

namespace App\Domain\Repositories\Interfaces;

interface ITransactionRepository
{
    public function generateTransactionReportByDateRange();
}
