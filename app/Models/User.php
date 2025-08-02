<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'email', 'password', 'firstname', 'lastname', 'birth_date', 'gender',
        'phone_number', 'city_id',  'area', 'status', 'last_online', 'is_online',
        'lang', 'image', 'about', 'looking', 'verified_at', 'occupation'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'verified_at' => 'datetime',
        'last_online' => 'datetime',
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];



    protected $appends = ['name','plan','type'];


    public function languages()
    {
        return $this->belongsToMany(Language::class, 'user_language', 'user_id', 'language_id');
    }



    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')
            ->using(UserRole::class)
            ->withTimestamps();
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // Accessor: Get all unique permissions for the user
    public function getPermissionsAttribute()
    {
        return $this->roles
            ->flatMap(function ($role) {
                return $role->permissions;
            })
            ->unique('id')
            ->values();
    }


}
