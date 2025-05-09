<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table;

    function __construct() {
        parent::__construct();
        $this->table = config('environment.PUBLIC_SCHEMA').'.user_auth';
    }

    
    protected $fillable = [
        'name', 'email', 'password', 'tz_local', 'country_code', 'location_id', 'location', 'internal_user'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    
    protected $hidden = [
        'password', 'remember_token', 'lastlogin', 'lastlogin', 'modifiedby', 'modifieddate', 'createdate'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserScope);
    }
}
