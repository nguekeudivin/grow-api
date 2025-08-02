<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function userLanguages()
    {
        return $this->belongsToMany(User::class, 'user_languages')->withTimestamps();
    }
}
