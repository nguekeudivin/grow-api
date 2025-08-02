<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'division_id',
        'city',
        'street',
        'postal_code',
        'latitude',
        'longitude',
    ];

    /**
     * Get the country this location belongs to.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the division this location is associated with.
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get a readable full address.
     */
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->street,
            $this->city,
            optional($this->division)->name,
            optional($this->country)->name,
            $this->postal_code,
        ];

        return implode(', ', array_filter($parts));
    }
}
