<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    protected $casts = [
        'paid_at' => 'datetime: j F Y, H:i:s',
    ];

    public function transactionable(): MorphTo {
        return $this->morphTo();
    }
}
