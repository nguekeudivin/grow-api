<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fr_name',
        'code',
    ];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
