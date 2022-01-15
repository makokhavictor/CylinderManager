<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Canister extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'manuf',
        'manuf_date',
        'brand_id',
        'RFID',
        'recertification',
        'size'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
