<?php

namespace App\Traits;

use App\Models\DealerUser;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasDealerUser
{
    public function dealerUser(): HasOne
    {
        return $this->hasOne(DealerUser::class);
    }

    public function getDealerUserIdAttribute()
    {
        return $this->dealerUser ? $this->dealerUser->id : null;
    }

}
