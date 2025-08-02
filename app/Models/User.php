<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone_number',
        'gender',
        'birth_date',
        'password',
        'location_id',
        'origin_location_id',
        'photo',
        'about',
        'language_id',
        'email_verified_at',
        'verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function originLocation()
    {
        return $this->belongsTo(Location::class, 'origin_location_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role')->withTimestamps();
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'user_languages')->withTimestamps();
    }

    public function associations()
    {
        return $this->belongsToMany(Association::class, 'association_users');
    }


}
