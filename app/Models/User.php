<?php

namespace App\Models;

use App\Traits\Permissible;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, Permissible;

    protected $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public function findForPassport($username)
    {
        return $this->where('phone', $username)
            ->orWhere('email', $username)
            ->orWhere('username', $username)
            ->first();
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = $value === '' ? NULL : $value;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value === '' ? NULL : $value;
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = $value === '' ? NULL : $value;
    }
}
