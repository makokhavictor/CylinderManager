<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransporterUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public function transporter() {
        return $this->belongsTo(Transporter::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
