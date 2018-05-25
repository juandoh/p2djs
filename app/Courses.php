<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [        
        "name", 
        "credits", 
        "mhours", 
        "ihours", 
        "ctype", 
        "precourses", 
        "valuable",
        "qualifiable" ,
        "p_academico",
        "semester",
        "created_by"
        ];
    
    public function program(){
        return $this->hasOne("App\AcademicPrograms",'id','p_academico');
    }

    public function creator(){
        return $this->hasOne("App\User",'id','created_by');
    }

    public function competences(){
        return $this->hasMany('App\CourseCompetences');
    }

}
