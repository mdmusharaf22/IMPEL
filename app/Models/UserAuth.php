<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\Scopes\UserScope;



class UserAuth extends Authenticatable implements OAuthenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    protected $table;

    function __construct() {
        parent::__construct();
        $this->table = config('environment.PUBLIC_SCHEMA').'.user_auth';
    }
    
    const CREATED_AT = 'createdate';
    const UPDATED_AT = 'modifieddate';
    
    protected $fillable = [
        'username', 'email', 'password', 'tz_local', 'country_code', 'location_id', 'location', 'internal_user'
    ];
    
    protected $hidden = [
        'password', 'remember_token', 'lastlogin', 'lastlogin', 'modifiedby', 'modifieddate', 'createdate'
    ];

    protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope(new UserScope);
    }
}
