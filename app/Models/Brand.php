<?php

namespace App\Models;

use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes, Paginatable;

    protected $fillable = ['name', 'company_name'];

    public function sizes() {
        return $this->belongsToMany(CanisterSize::class);
    }

    public function depots() {
        return $this->belongsToMany(Depot::class);
    }
    public function orders() {
        return $this->belongsToMany(Order::class, 'canister_size_order');
    }
}
