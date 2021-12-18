<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function transporterUsers() {
        return $this->hasMany(TransporterUser::class);
    }
}
