<?php

namespace App\Traits;

use App\Models\DepotUser;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasDepotUser
{
    public function depotUser(): HasOne
    {
        return $this->hasOne(DepotUser::class);
    }

    public function getDepotUserIdAttribute()
    {
        return $this->depotUser ? $this->depotUser->id : null;
    }

}
