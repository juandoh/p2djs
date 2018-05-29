<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFacultyRelation extends Model
{
	protected $table ="user_faculty_relations";
    protected $fillable = [
        'user_id', 'role','faculty_id'
    ];

}
