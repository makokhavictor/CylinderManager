<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanisterLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'canister_log_batch_id',
        'toable_id',
        'fromable_id',
        'toable_type',
        'fromable_type',
        'canister_id',
        'filled',
        'released_at',
        'user_id'
    ];

    public function canister()
    {
        return $this->belongsTo(Canister::class);
    }

    public function canisterLogBatch() {
        return $this->belongsTo(CanisterLogBatch::class);
    }

    public function toable()
    {
        return $this->morphTo();
    }

}
