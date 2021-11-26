<?php

namespace App\Traits;

use App\Models\DepotUser;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasDealer
{
    public function dealer(): HasOne
    {
        return $this->hasOne(DepotUser::class);
    }

    public function getDealerIdAttribute()
    {
        return $this->dealer ? $this->dealer->id : null;
    }

}
