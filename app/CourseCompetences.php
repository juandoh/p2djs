<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCompetences extends Model
{
    //id,course,name,detail
    protected $table="course_competences";
    protected $fillable = ['course','name','detail'];

    public function course(){
        return $this->belongsTo('App\Courses','id','course');
    }

    public function learningO(){
        return $this->hasMany('App\LearningOutcomes');
    }
}
