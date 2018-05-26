<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAcademicProgramRelation extends Model
{
    protected $fillable = [
        'user_id', 'role'
    ];
}
