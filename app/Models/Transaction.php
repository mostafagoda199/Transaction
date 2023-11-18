<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'user_id' , 'due_on', 'vat', 'is_vat_inclusive', 'status'];

    public function payer(): BelongsTo
    {
       return $this->belongsTo(User::class,'user_id','id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class,'transaction_id','id');
    }
}
