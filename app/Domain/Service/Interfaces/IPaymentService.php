<?php

namespace App\Domain\Service\Interfaces;

interface IPaymentService
{
    public function recordPayment(array $paymentData): void;
}
