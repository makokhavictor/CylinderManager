<?php

namespace App\Models;

use App\Traits\IsStation;
use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
    use HasFactory, IsStation, Paginatable;

    protected $fillable = ['name', 'code'];

    public function contractedDealers()
    {
        return $this->belongsToMany(Depot::class)->withPivot('expires_at');
    }

}
