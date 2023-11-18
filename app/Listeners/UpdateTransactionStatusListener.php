<?php

namespace App\Listeners;

use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\Repositories\Interfaces\ITransactionRepository;
use App\Events\UpdateTransactionStatusEvent;

class UpdateTransactionStatusListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateTransactionStatusEvent $updateTransactionStatusEvent): void
    {
        $transactionId = $updateTransactionStatusEvent->payment?->transaction_id ?? null;

        if ($transactionId) {
            $transaction = resolve(ITransactionRepository::class)->firstOrFail(conditions: ['id' => $transactionId], relations: ['payments']);
            $totalAmountPaidOnTransaction = $transaction->payments->pluck('amount')->sum();

            $status = '';
            if ($totalAmountPaidOnTransaction === $transaction->amount) {
                $status = TransactionStatusEnum::PAID->value;
            } elseif ($totalAmountPaidOnTransaction < $transaction->amount) {
                if ($transaction->due_on > now()) {
                    $status = TransactionStatusEnum::OUTSTANDING->value;
                } else {
                    $status = TransactionStatusEnum::OVERDUE->value;
                }
            }
            $transaction->update(['status' => $status]);

        }

    }
}
