<?php

namespace App\Traits;

use App\Models\Depot;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasDepots
{
    public function depots(): BelongsToMany
    {
        return $this->belongsToMany(Depot::class, 'station_permissions');
    }

    public function getDepotIdsAttribute()
    {
        return $this->depots->pluck('id');
    }

}
