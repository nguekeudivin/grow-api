<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssociationUserRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'association_user_id',
        'role_id',
    ];

    public function associationUser()
    {
        return $this->belongsTo(AssociationUser::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
