<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schools extends Model
{
    use SoftDeletes;    
    //id, name, detail
    protected $table ='schools';
    
    protected $fillable = ['name','faculty','detail'];

    public function programs(){
        return $this->hasMany('App\AcademicPrograms');
    }

    public function facultyR(){
        return $this->hasOne('App\Faculties','id','faculty');
    }
}
