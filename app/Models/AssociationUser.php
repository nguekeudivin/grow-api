<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssociationUser extends Model
{
    protected $fillable = ['user_id','association_id'];

    protected $table = 'association_users';
}
