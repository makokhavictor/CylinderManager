<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    protected $fillable = ['depot_id', 'dealer_id'];
    use HasFactory, SoftDeletes;

    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function canisterSizes()
    {
        return $this->belongsToMany(CanisterSize::class)->withPivot(['quantity']);
    }

}
