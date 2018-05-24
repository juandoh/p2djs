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
    //protected $primaryKey = 'code';
    //public $timestamps = false; 
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [        
        "name", "credits", "mhours", "ihours", "ctype", "precourses", "valuable", "qualifiable" ,"p_academico","semester"
        ];
    
    public function p_academico(){
        return $this->belongsTo("App\AcademicPrograms",'id','p_academico');
    }

    public function competences(){
        return $this->hasMany('App\CourseCompetences');
    }

}
