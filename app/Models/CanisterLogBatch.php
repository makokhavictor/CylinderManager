<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanisterLogBatch extends Model
{
    use HasFactory;

    public function canisterLogs() {
        return $this->hasMany(CanisterLog::class);
    }
}
