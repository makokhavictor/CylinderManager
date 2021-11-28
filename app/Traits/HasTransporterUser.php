<?php

namespace App\Traits;

use App\Models\TransporterUser;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasTransporterUser
{
    public function transporterUser(): HasOne
    {
        return $this->hasOne(TransporterUser::class);
    }

    public function getTransporterUserIdAttribute()
    {
        return $this->transporterUser ? $this->transporterUser->id : null;
    }

}
