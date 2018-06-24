<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LearningOutcomes extends Model
{
    //id,competence,name,detail
    protected $table = "learning_outcomes";
    protected $fillable = ['competence','name','detail'];

    public function competence_join(){
        return $this->belongsTo('App\CourseCompetences','id','competence');
    }

    public function indicators(){
        return $this->hasMany('App\AchievementIndicators', 'learningO','id');
    }
}
