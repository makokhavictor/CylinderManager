<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanisterLogBatch extends Model
{
    protected $fillable = [
        'toable_id',
        'toable_type',
        'fromable_id',
        'fromable_type',
        'transporter_id',
    ];
    use HasFactory;

    public function canisterLogs() {
        return $this->hasMany(CanisterLog::class);
    }
}
