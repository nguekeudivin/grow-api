<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'parent_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Parent division (e.g. department's parent might be a region)
    public function parent()
    {
        return $this->belongsTo(Division::class, 'parent_id');
    }

    // Child divisions (e.g. region has many departments)
    public function children()
    {
        return $this->hasMany(Division::class, 'parent_id');
    }

    // Example helper to get full hierarchical name (optional)
    public function getFullNameAttribute()
    {
        if ($this->parent) {
            return $this->parent->full_name . ' > ' . $this->name;
        }
        return $this->name;
    }
}
