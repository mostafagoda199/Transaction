<?php

namespace App\Models;

use App\Events\UpdateTransactionStatusEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id','amount','pay_on','details'];

    protected $dispatchesEvents = [
        'saved' => UpdateTransactionStatusEvent::class,
    ];
}
