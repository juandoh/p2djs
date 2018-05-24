<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AchievementIndicators extends Model
{
    //id,learningO,name,detail
    protected $table='achievement_indicators';
    protected $fillable = ['learningO','name','detail'];

    public function learningO(){
        return $this->belongsTo('App\LearningOutcomes','id','learningO');
    }
}
