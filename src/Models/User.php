<?php

namespace Bishopm\Bible\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Actuallymab\LaravelComment\CanComment;
use Bishopm\Bible\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\CausesActivity;
use Bishopm\Bible\Models\Setting;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use CanComment;
    use SoftDeletes;
    use CausesActivity;
    use HasRoles;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function individual()
    {
        return $this->belongsTo('Bishopm\Bible\Models\Individual');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function routeNotificationForSlack()
    {
        $setting=Setting::where('setting_key', 'slack_webhook')->first();
        if ($setting) {
            return $setting->setting_value;
        }
    }

    public function posts()
    {
        return $this->hasMany('Bishopm\Bible\Models\Post');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function rosters()
    {
        return $this->belongsToMany('Bishopm\Bible\Models\Roster');
    }
}
