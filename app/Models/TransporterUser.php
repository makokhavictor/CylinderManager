<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransporterUser extends Model
{
    use HasFactory;

    public function transporter() {
        return $this->belongsTo(Dealer::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
