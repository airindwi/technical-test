<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // Fields to be filled in the database
    protected $fillable = [
        'name',
        'password',
        'role',
        'email',
    ];

    // Hidden fields for arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function orderTrips()
    {
        return $this->hasMany(OrderTrip::class, 'driver_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
