<?php

namespace App\Models;

use App\Traits\IsStation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
    use HasFactory, IsStation;

    protected $fillable = ['name', 'code'];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function receivedCanisterLogs() {
        return $this->hasMany(CanisterLog::class, 'to_transporter_id');
    }
}
