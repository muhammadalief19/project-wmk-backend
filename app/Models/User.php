<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // set UUID
    protected static function boot() {
        parent::boot();

        static::creating(function($model) {
            if($model->getKey() == null) {
                $model->setAttribute('uuid', Str::uuid()->toString());
            }
        });
    }


    /* 
    * method getJWTIdentifier
    * 
    * return void
    */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /* 
    * method getJWTCustomClaims
    * 
    * return void
    */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // get the data admin for the user
    public function data_admin() : HasOne 
    {
        return $this->hasOne(DataAdmin::class);
    }

    // get the data admin for the user
    public function data_pegawai() : HasOne
    {
        return $this->hasOne(DataAdmin::class);
    }
}
