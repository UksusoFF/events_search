<?php

namespace App\Models;

use App\Tag;
use Brackets\AdminAuth\Auth\Activations\CanActivate;
use Brackets\AdminAuth\Contracts\Auth\CanActivate as CanActivateContract;
use Brackets\AdminAuth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanActivateContract
{

    use Notifiable;
    use CanActivate;
    use SoftDeletes;
    use HasRoles;

    protected $fillable = [
        "email",
        "password",
        "city_id",
        "token",
        "first_name",
        "last_name",
        "activated",
        "forbidden",
        "language",

    ];

    protected $hidden = [
        "password",
        "remember_token",

    ];

    protected $dates = [
        "created_at",
        "updated_at",
        "deleted_at",

    ];

    protected $appends = [
        'full_name',
        'resource_url',
    ];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/users/' . $this->getKey());
    }

    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }

    public function getAvatarAttribute()
    {
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/$hash";
    }

    /**
     * Send the password reset notification.
     *
     * @param    string $token
     *
     * @return  void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(app(ResetPassword::class, ['token' => $token]));
    }

    /* ************************ RELATIONS ************************ */

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function sources()
    {
        return $this->hasMany(Source::class);
    }

}
