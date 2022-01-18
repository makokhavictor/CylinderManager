<?php

namespace App\Models;

use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanisterLogBatch extends Model
{
    protected $fillable = [
        'order_id',
        'toable_id',
        'toable_type',
        'fromable_id',
        'fromable_type',
        'transporter_id',
    ];
    use HasFactory, Paginatable;

    public function canisterLogs() {
        return $this->hasMany(CanisterLog::class);
    }
}
