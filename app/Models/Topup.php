<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topup extends Model
{
    /** @use HasFactory<\Database\Factories\TopupFactory> */
    use HasFactory, HasUuids;

    protected $guarded = ['id'];

    protected $casts = [
        'paid_at' => 'datetime: j F Y, H:i:s',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
