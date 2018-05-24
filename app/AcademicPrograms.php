<?php

namespace App;

use App\Schools;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicPrograms extends Model
{
    use SoftDeletes;
    protected $table = 'academic_programs';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        "name", "school", "semesters", "credits"
        ];

    public function fschool(){
        //Model,foreign_key,local_key
        return $this->hasOne('App\Schools','id','school');        
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
