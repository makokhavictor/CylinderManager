<?php

namespace App\Models;

use App\Traits\IsStation;
use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory, IsStation, Paginatable;

    protected $fillable = [
        'name', 'code', 'EPRA_licence_no', 'location', 'GPS'
    ];



}
