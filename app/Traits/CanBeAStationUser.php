<?php

namespace App\Traits;

use App\Models\CanisterLog;
use App\Models\Dealer;
use App\Models\Depot;
use App\Models\Order;
use App\Models\StationPermission;
use App\Models\StationRole;
use App\Models\Transporter;
use App\Models\User;

trait CanBeAStationUser
{
    public function depots()
    {
        return $this->belongsToMany(Depot::class, 'station_permissions', 'user_id', 'permissible_id')
            ->where(function ($q) {
                $q->where('permissible_type', Depot::class);
            });
    }

    public function dealers()
    {
        return $this->belongsToMany(Dealer::class, 'station_permissions', 'user_id', 'permissible_id')
            ->where(function ($q) {
                $q->where('permissible_type', Dealer::class);
            });
    }

    public function transporters()
    {
        return $this->belongsToMany(Transporter::class, 'station_permissions', 'user_id', 'permissible_id')
            ->where(function ($q) {
                $q->where('permissible_type', Transporter::class);
            });
    }


}
