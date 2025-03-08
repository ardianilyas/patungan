<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Withdraw extends Model
{
    /** @use HasFactory<\Database\Factories\WithdrawFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    public function transaction(): MorphOne {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
