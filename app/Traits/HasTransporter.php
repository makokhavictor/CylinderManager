<?php

namespace App\Traits;

use App\Models\Transporter;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasTransporter
{
    public function transporter(): HasOne
    {
        return $this->hasOne(Transporter::class);
    }

    public function getTransporterIdAttribute()
    {
        return $this->transporter ? $this->transporter->id : null;
    }

}
