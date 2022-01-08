<?php

namespace App\Traits;

use App\Models\Depot;
use App\Models\StationPermission;
use App\Models\StationRole;

trait IsStation
{
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

}
