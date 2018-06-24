<?php

namespace App\Http\Controllers\CRUD;

use Auth;
use Alert;
use Relations;
use App\Courses;
use App\AcademicPrograms;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CourseDesign\CourseCompetencesController;
use App\Http\Controllers\CourseDesign\LearningOutcomesController;
use App\Http\Controllers\CourseDesign\AchievementIndicatorsController;

class CoursesController extends Controller
{
    //Validation rules
    private $rules=[
        'name'=>'required|string|max:191|unique:courses',
        'credits'=>'required|integer|min:2',
        'mhours'=>'required|integer|min:1',
        'ihours'=>'required|integer|min:1',
        'ctype'=>'required|integer|min:1|max:4',
        'valuable'=>'boolean',
        'qualifiable'=>'boolean',
        'program_id'=>'required|exists:academic_programs,id|min:1',
        'semester'=>'required|integer|min:1|max:20',
    ];

    //Validation messages
    private $messages=[
        'name.unique'=>'El nombre ya se encuentra registrado en la base de datos',
        'required'=>'El atributo es obligatorio',
        'integer'=>'El atributo debe ser un valor entero',
        'semester.min'=>'El semestre debe tener un valor minimo de :min',
        'credits.min'=>'El numero de creditos debe ser minimo de :min',
        'mhours.min'=>'El numero de <strong>horas magistrales</strong> debe ser minimo de :min',
        'ihours.min'=>'El numero de <strong>horas independientes</strong> debe ser minimo de :min',
        'ctype.min'=>'Tipo de curso incorrecto',
        'ctype.max'=>'Tipo de curso incorrecto',
        'program_id.exists'=>'El Programa Academico seleccionado no se encuentra en la base de datos',
        'program_id.min'=>'El Programa Academico seleccionado no se encuentra en la base de datos',
    ];

    protected function validator(array $data, $rules){
        return Validator::make($data, $rules, $this->messages);
    }
    //Database
    private function store(array $data){
        /*
            "name", "credits", "mhours", "ihours", "ctype",
            "precourses", "valuable", "qualifiable" ,"program_id"
        */
        return Courses::create([
            "name" => $data['name'],
            "credits" => $data['credits'],
            "mhours" => (int)$data['mhours'], //magistral hours
            "ihours" => (int)$data['ihours'], //independent hours
            "ctype" =>  (int)$data['ctype'],  //course type
            "valuable" => (bool)$data['valuable'],    //
            "qualifiable" => (bool)$data['qualifiable'], //
            "program_id" => (int)$data['program_id'],
            "semester" => (int)$data['semester'],
            "created_by" => (int)$data['created_by']
        ]);
    }
    private function edit(array $data,$id){
        $course = Courses::find($id);
        if($course){
            $i=1;
            while(array_key_exists('precourse_id_'.$i, $data)){
                Relations::bindCoursePrerequisite($id, (int)$data['precourse_id_'.$i]);
                $i+=1;
            }
            $course->name = $data['name'];
            $course->credits = $data['credits'];
            $course->mhours = $data['mhours'];
            $course->ihours = $data['ihours'];
            $course->ctype = $data['ctype'];
            $course->valuable = $data['valuable'];
            $course->qualifiable = $data['qualifiable'];
            return $course->save();
        }
        return false;
    }

    public static function allCourses(){
        return Courses::all();
    }

    public static function allTeacherCourses(){
        return Courses::where('created_by',Auth::id())->paginate(10);
    }

    public static function paginateCourses(){
        return Courses::paginate(10);
    }

    //REST FUNCTIONS
    //GET
    public function showEdit($id){
        if(!is_null($id)){
            $course = Courses::find($id);
            //dd($program);
            if(!$course){
                alert()->info('Información','El Curso no se puede modificar dada su inhabilidad ó simplemente no existe');
                return redirect('/home/consultar');
            }
            if (Relations::isProgramBinded(Auth::id()))
                return view('forms.CRUD.edit')
            ->withMaster([
                'title'=>'Cursos',
                'option'=>'update',
                'model'=>'Course',
                'fields'=>'courses',
                'object'=>'course'
            ])
            ->withData($course)
            ->withPrograms(AcademicProgramsController::allPrograms())
            ->withAvailableCourses(CoursesController::allCourses())
            ->withPrecourseList(Relations::getCoursePrerequisites($id));
            else
                return redirect('/home/consultar');
        }
    }

    public function showInfo($id){
        //return '';///REPLACE WITH DESIGN VIEW ONLY, NOT DESIGN EDIT
        if(!is_null($id)){
            //dd($role);
            $course = Courses::find($id);
            //dd($program);
            if(!$course){
                alert()->info('Información','El Curso no se encuentra disponible para visualizar');
                return redirect('/home/consultar');
            }
            $role = Relations::resolveRole(Auth::id());
            if ($role == 2 or $role == 3)
                return view('forms.CRUD.edit')
            ->withMaster([
                'title'=>'Cursos',
                'option'=>'show',
                'model'=>'Course',
                'fields'=>'courses',
                'object'=>'course'
            ])
            ->withData($course);
            else
                return redirect('/home/consultar');
        }
    }

    public function showDesigner($id){
        if(!is_null($id)){
            if (Relations::isTeacher(Auth::id())) {
                $course = Courses::find($id);
                if(!$course){
                    alert()->info('Información','El Curso no se puede modificar dada su inhabilidad, no existe, ó no lo tiene asignado');
                }else{
                    $competences = CourseCompetencesController::listCompetences((int)$id);
                    return view('forms.CourseDesign.design',['course'=>$course])
                    ->withCompetences($competences);
                }
            }
            return redirect('/home/consultar');
        }
    }

    //POST
    public function create(Request $request){
        dd($request->all());

        $role = Relations::resolveRole(Auth::id());
        if($role == 1 or $role == 2){
            $data = $request->all();
            $credits = $data['credits'];
            $mhours = $data['mhours'];
            $ihours = $data['ihours'];

            $weekHours = $credits*3;
            if($mhours+$ihours != $weekHours or $mhours>$ihours){
                return redirect()->back()->withErrors(new MessageBag([
                    'weekHours'=>'Las horas magistrales e individuales deben sumar: '.$weekHours.'<br>Nota: Las horas magistrales deben ser menor a las horas de trabajo individual'
                ]))->with(['_old_input'=>$data]);
            }

            $this->validator($data,$this->rules)->validate();
            $store = $this->store($data);
            if($store){
                $i=1;
                while(array_key_exists('precourse_id_'.$i, $data)){
                    Relations::bindCoursePrerequisite($store->id, (int)$data['precourse_id_'.$i]);
                    $i+=1;
                }
                alert()->success("Exito!","El Curso ha sido registrado");
                return redirect()->back();
            }
        }
        alert()->error("Error!","Un inconveniente ha ocurrido");
        return redirect()->back();
    }

    public function update(Request $request){
        $role= Relations::resolveRole(Auth::id());
        if($role==1 or $role==2){
            $data = $request->all();
            //dd($data);
            $credits = $data['credits'];
            $mhours = $data['mhours'];
            $ihours = $data['ihours'];

            $weekHours = $credits*3;
            if($mhours+$ihours != $weekHours or $mhours>$ihours){
                return redirect()->back()->withErrors(new MessageBag([
                    'weekHours'=>'Las horas magistrales y semanales deben sumar: '.$weekHours.'<br>Nota: Las horas magistrales deben ser menor a las horas de trabajo individual'
                ]))->with(['_old_input'=>$data]);
            }

            $updateRules = $this->rules;
            $updateRules['name']='required|string|max:255|exists:courses,name';

            $this->validator($data,$updateRules)->validate();
            $id = $data['id'];

            if($this->edit($data,$id)){
                $i=1;
                while($i < count($data)){
                    if(array_key_exists('precourse_id_'.$i, $data)) {
                        $exists = (bool)$data['precourse_id_' . $i . '_exists'];
                        if (!$exists) {
                            Relations::bindCoursePrerequisite($id, (int)$data['precourse_id_' . $i]);
                        }
                    }
                    $i+=1;
                }
                alert()->success("Exito!","El Curso ha sido modificado");
                return redirect('/home/consultar');
            }
        }
        alert()->error("Error!","Un inconveniente ha ocurrido");
        return redirect()->back();
    }

    public function delete($id){
        //dd($id);
        if(!is_null($id)){
            //dd(User::find($id)->trashed());
            if(Relations::isProgramBinded(Auth::id())){
                if(Courses::find($id)->delete()){
                    alert()->success("Exito!","El Curso ha sido eliminado");
                    return redirect("/home/consultar");
                }else{
                    alert()->error("Error!","El Curso no pudo eliminarse");
                    return redirect("/home/consultar");
                }
            }else{
                alert()->error("Error","Su cuenta no tiene el rol permitido para ejecutar esta acción");
            }
        }
        return redirect("/home/consultar");
    }

    public function deletePrerequisite(Request $request){
        $data = $request->all();
        $course_id = $data["course_id"];
        $prerequiste = $data["prerequisite"];
        $del = Relations::unbindCoursePrerequisite($course_id,$prerequiste);
        return ["done"=>$del];
    }
}
