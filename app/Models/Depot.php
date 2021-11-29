<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'EPRA_licence_no', 'location'
    ];

    public function depotUsers()
    {
        return $this->hasMany(DepotUser::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }
}
