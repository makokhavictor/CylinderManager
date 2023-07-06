<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationPermission extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'permissible_id', 'permissible_type', 'role_id'];

    public function permissible()
    {
        return $this->morphTo();
    }

}

// depot->stationPermissions()->create(['user_id' => $user->id, 'role_id' => Role::where('name', 'Depot User')->first()->id ]);
