<?php

namespace App\Traits;

use App\Models\CanisterLog;
use App\Models\Depot;
use App\Models\Order;
use App\Models\StationPermission;
use App\Models\StationRole;
use App\Models\User;

trait IsStation
{
    public static function scopeUserEnabled($q) {
        return $q->whereHas('stationPermissions');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function stationPermissions()
    {
        return $this->morphMany(StationPermission::class, 'permissible');
    }

    public function stationRoles() {
        return $this->morphMany(StationRole::class, 'roleable');
    }

    public function assignDefaultUserRoles() {

        $stationRoles = StationRole::where('roleable_type', [$this->getMorphClass()])->whereNull('roleable_id')->get();
        foreach ($stationRoles as $stationRole) {
            $this->stationRoles()->create(["role_id" => $stationRole->role_id]);
        }
    }

    public function receivedCanisterLogs() {
        return $this->morphMany(CanisterLog::class, 'toable');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
