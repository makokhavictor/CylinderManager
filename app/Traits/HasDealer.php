<?php

namespace App\Traits;

use App\Models\DepotUser;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasDealer
{
    public function dealer(): HasOne
    {
        return $this->hasOne(DealerUser::class);
    }

    public function getDealerIdAttribute()
    {
        return $this->dealer ? $this->dealer->id : null;
    }

}
