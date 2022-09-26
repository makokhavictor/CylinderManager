<?php

namespace App\Models;

use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    protected $fillable = ['depot_id', 'dealer_id'];
    use HasFactory, SoftDeletes, Paginatable;

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
        return $this->belongsToMany(CanisterSize::class)->withPivot(['quantity', 'brand_id']);
    }

    public function canisterLogBatches() {
        return $this->hasMany(CanisterLogBatch::class);
    }

    public function canisterLogs()
    {
        return $this->hasManyThrough(CanisterLog::class, CanisterLogBatch::class);
    }

    public function transporter() {
        return $this->belongsTo(Transporter::class, 'assigned_to');
    }
}
