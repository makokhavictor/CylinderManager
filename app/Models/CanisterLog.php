<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanisterLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_depot_id',
        'to_dealer_id',
        'to_transporter_id',
        'from_depot_id',
        'from_dealer_id',
        'from_transporter_id',
        'canister_id',
        'filled',
        'released_at',
        'user_id'
    ];

    public function toDepot()
    {
        return $this->belongsTo(Depot::class, 'to_depot_id');
    }

    public function fromDepot()
    {
        return $this->belongsTo(Depot::class, 'from_depot_id');
    }

    public function toDealer()
    {
        return $this->belongsTo(Depot::class, 'to_dealer_id');
    }

    public function fromDealer()
    {
        return $this->belongsTo(Depot::class, 'from_dealer_id');
    }

    public function toTransporter()
    {
        return $this->belongsTo(Depot::class, 'to_transporter_id');
    }

    public function fromTransporter()
    {
        return $this->belongsTo(Depot::class, 'from_transporter_id');
    }

    public function canister()
    {
        return $this->belongsTo(Canister::class);
    }

}
