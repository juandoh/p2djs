<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculties extends Model
{
    use SoftDeletes;
    //id, name, detail
    protected $table ='faculties';
    
    protected $fillable = ['name','detail'];

    public function schools(){
        return $this->hasMany('App\Schools');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
