<?php

namespace App\Models;

use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanisterSize extends Model
{
    use HasFactory, Paginatable, SoftDeletes;

    protected $fillable = ['name', 'value'];

    public function brands() {
        return $this->belongsToMany(Brand::class);
    }
}
