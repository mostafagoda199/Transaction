<?php

namespace App\Domain\Enum;

enum TransactionStatusEnum : string
{
    case PAID = 'paid';
    case OUTSTANDING = 'outstanding';
    case OVERDUE = 'overdue';
}
