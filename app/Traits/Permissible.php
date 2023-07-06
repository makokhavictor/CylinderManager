<?php

namespace App\Traits;

use App\Models\Dealer;
use App\Models\StationPermission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Role;

trait Permissible
{
    public function permissibleRoles()
    {
        return $this->belongsToMany(Role::class, 'station_permissions')->withPivot([
            'permissible_id', 'permissible_type'
        ]);
    }

}
