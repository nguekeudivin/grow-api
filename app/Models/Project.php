<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 0;
    public const STATUS_ONGOING = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_CANCELED = 3;

    protected $fillable = [
        'name',
        'description',
        'location_id',
        'association_id',
        'budget',
        'status',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function phases()
    {
        return $this->hasMany(ProjectPhase::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
