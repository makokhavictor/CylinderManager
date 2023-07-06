<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;
    public function stationRoles() {
        return $this->hasMany(StationRole::class);
    }

    public function depots() {
        return $this->hasMany(StationPermission::class);
    }
}
