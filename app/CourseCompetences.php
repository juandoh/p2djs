<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCompetences extends Model
{
    //id,course,name,detail
    protected $table="course_competences";
    protected $fillable = ['course','name','detail'];

    public function course_join(){
        return $this->belongsTo('App\Courses','id','course');
    }

    public function learning_outcomes(){
        return $this->hasMany('App\LearningOutcomes', 'competence', 'id');
    }
}
