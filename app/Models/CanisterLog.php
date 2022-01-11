<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanisterLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'toable_id',
        'fromable_id',
        'toable_type',
        'fromable_type',
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
        return $this->belongsTo(Dealer::class, 'to_dealer_id');
    }

    public function fromDealer()
    {
        return $this->belongsTo(Dealer::class, 'from_dealer_id');
    }

    public function toTransporter()
    {
        return $this->belongsTo(Transporter::class, 'to_transporter_id');
    }

    public function fromTransporter()
    {
        return $this->belongsTo(Transporter::class, 'from_transporter_id');
    }

    public function canister()
    {
        return $this->belongsTo(Canister::class);
    }

}
