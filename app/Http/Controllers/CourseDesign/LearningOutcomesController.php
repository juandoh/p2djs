<?php

namespace App\Http\Controllers\CourseDesign;

use Auth;
use Alert;
use App\LearningOutcomes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LearningOutcomesController extends Controller
{
    //Database
    public static function store(array $data)
    {
        //id,competence,name,detail
        return LearningOutcomes::create([
            'competence' => $data['competence'],
            'name' => $data['name'],
            'detail' => $data['detail']
        ]);
    }

    public static function edit(array $data, $id)
    {
        $competence = LearningOutcomes::find($id);
        $competence->competence = $data['competence'];
        $competence->name = $data['name'];
        $competence->detail = $data['detail'];

        return $competence->save();
    }

    public static function destroy($id)
    {
        return LearningOutcomes::destroy($id);
    }
}
