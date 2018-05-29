<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAcademicProgramRelation extends Model
{
	protected $table = 'user_academic_program_relations';
    protected $fillable = [
        'user_id', 'role','program_id'
    ];
}
