<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Donation extends Model
{
    /** @use HasFactory<\Database\Factories\DonationFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    public function sender(): BelongsTo {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function transaction(): MorphOne {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
}
