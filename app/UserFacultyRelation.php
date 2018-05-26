<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFacultyRelation extends Model
{
    protected $fillable = [
        'user_id', 'role'
    ];
}
