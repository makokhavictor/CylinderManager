<?php

namespace App\Models;

use App\Traits\IsStation;
use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory, IsStation, Paginatable;

    protected $fillable = [
        'name', 'code', 'EPRA_licence_no', 'location'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function transporter() {
        return $this->belongsToMany(Transporter::class)->withPivot('expires_at');
    }

}
