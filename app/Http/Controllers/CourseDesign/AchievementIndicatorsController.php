<?php

namespace App\Http\Controllers\CourseDesign;

use Auth;
use Alert;
use App\AchievementIndicators;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AchievementIndicatorsController extends Controller
{
//Database
    public static function store(array $data)
    {
        //id,learningO,name,detail
        return AchievementIndicators::create([
            'learningO' => $data['learningO'],
            'name' => $data['name'],
            'detail' => $data['detail']
        ]);
    }

    public static function edit(array $data, $id)
    {
        $competence = AchievementIndicators::find($id);
        $competence->learningO = $data['learningO'];
        $competence->name = $data['name'];
        $competence->detail = $data['detail'];

        return $competence->save();
    }

    public static function destroy($id)
    {
        return AchievementIndicators::destroy($id);
    }
}
