<?php

namespace App\Models;

use App\Traits\Paginatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Canister extends Model
{
    use HasFactory, SoftDeletes, Paginatable;

    protected $fillable = [
        'code',
        'manuf',
        'manuf_date',
        'brand_id',
        'RFID',
        'recertification_date',
        'canister_size_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function canisterSize()
    {
        return $this->belongsTo(CanisterSize::class);
    }
    public function canisterLogs() {
        return $this->hasMany(CanisterLog::class);
    }

    public function canisterDepotLogs() {
        return $this->canisterLogs()->where('toable_type', Depot::class)
            ->whereNull('released_at');
    }

    public function canisterDealerLogs() {
        return $this->canisterLogs()->where('toable_type', Dealer::class)
            ->whereNull('released_at');
    }

    public function canisterTransporterLogs() {
        return $this->canisterLogs()->where('toable_type', Transporter::class)
            ->whereNull('released_at');
    }
}
