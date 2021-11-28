<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepotUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id'
    ];

    public function depot() {
        return $this->belongsTo(Depot::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
