<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationRole extends Model
{
    protected $fillable = ['role_id'];
    use HasFactory;

    public function roleable()
    {
        return $this->morphTo();
    }
}
