<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursePrerequisiteRelation extends Model
{
    protected $table ="course_prerequisite_relations";
    protected $fillable = ['course_id','prerequisite'];
}
