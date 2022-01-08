<?php

namespace App\Traits;

use App\Models\Transporter;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasTransporters
{
    public function transporters(): BelongsToMany
    {
        return $this->belongsToMany(Transporter::class, 'station_permissions');
    }

    public function getTransporterIdsAttribute()
    {
        return $this->transporters->pluck('id');
    }

}
