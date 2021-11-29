<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public function dealer() {
        return $this->belongsTo(Dealer::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
