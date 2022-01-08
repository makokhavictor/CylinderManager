<?php

namespace App\Traits;

use App\Models\Dealer;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasDealers
{
    public function dealers(): BelongsToMany
    {
        return $this->belongsToMany(Dealer::class, 'station_permissions');
    }

    public function getDealerIdsAttribute()
    {
        return $this->dealers->pluck('id');
    }

}
