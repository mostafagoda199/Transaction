<?php

namespace App\Domain\Service\Classes;

use App\Domain\Repositories\Interfaces\IPaymentRepository;
use App\Domain\Repositories\Interfaces\ITransactionRepository;
use App\Domain\Service\Interfaces\IPaymentService;
use App\Exceptions\ApiCustomException;
use Throwable;

class PaymentService implements IPaymentService
{
    public function __construct(private readonly IPaymentRepository $paymentRepository)
    {
    }

    /**
     * @throws Throwable
     */
    public function recordPayment(array $paymentData): void
    {
        $transaction = resolve(ITransactionRepository::class)->firstOrFail(conditions: ['id' => $paymentData['transaction_id']],relations:['payments']);
        $totalAmountPaidOnTransaction = $transaction->payments->pluck('amount')->sum();
        $remainingAmountNotPaid = $transaction->amount - $totalAmountPaidOnTransaction;
        $amountWantToPay = $paymentData['amount'];
        throw_if($amountWantToPay > $remainingAmountNotPaid, new ApiCustomException(trans('payment should be less than '.$remainingAmountNotPaid)));
        $this->paymentRepository->create($paymentData);
    }
}
