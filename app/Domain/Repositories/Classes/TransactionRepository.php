<?php

namespace App\Domain\Repositories\Classes;

use App\Domain\Repositories\Interfaces\ITransactionRepository;
use Carbon\Carbon;

class TransactionRepository extends AbstractRepository implements ITransactionRepository
{

    public function generateTransactionReportByDateRange()
    {
        $startDate = request()->input('start_date');
        $endDate = request()->input('end_date');
        $transactions = $this->model->whereBetween('due_on', [$startDate, $endDate])->with(['payments'])->get()->groupBy(function ($transaction) {
            return Carbon::parse($transaction->due_on)->format('Y-m');
        });

        return $transactions->map(function ($transaction,$dateGroup){
            $date = Carbon::createFromFormat('Y-m', $dateGroup);
            $outstanding = $transaction->where('status','outstanding');
            $overdue = $transaction->where('status','overdue');
            return [
                'month' => $date->format('m'),
                'year' => $date->format('Y'),
                'paid' => array_sum(data_get($transaction, '*.payments.*.amount')),
                'outstanding' => array_sum(data_get($outstanding, '*.amount')) - array_sum(data_get($outstanding, '*.payments.*.amount')),
                'overdue' => array_sum(data_get($overdue, '*.amount')) - array_sum(data_get($overdue, '*.payments.*.amount')),
            ];
        });
    }
}
