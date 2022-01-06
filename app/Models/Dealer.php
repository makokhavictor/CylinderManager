<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'EPRA_licence_no', 'location', 'GPS'
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function receivedCanisterLogs() {
        return $this->hasMany(CanisterLog::class, 'to_dealer_id');
    }
}
