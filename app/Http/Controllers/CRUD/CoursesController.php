<?php

namespace App\Http\Controllers\CRUD;

use Auth;
use Alert;
use App\Courses;
use App\AcademicPrograms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CoursesController extends Controller
{
    //Validation rules
    private $rules=[
        'name'=>'required|string|max:255|unique:courses',
        'credits'=>'required|integer|min:1',
        'mhours'=>'required|integer|min:1',
        'ihours'=>'required|integer|min:1',
        'ctype'=>'required|integer|min:1|max:4',        
        'precourses'=>'required|string|max:255',
        'valuable'=>'boolean',
        'qualifiable'=>'boolean',
        'p_academico'=>'required|exists:academic_programs,id|min:1',
        'semester'=>'required|integer|min:1|max:20',
    ];
    //Validation messages
    private $messages=[
        'name.unique'=>'El nombre ya se encuentra registrado en la base de datos',
        'required'=>'El atributo es obligatorio',
        'integer'=>'El atributo debe ser un valor entero',
        'semester.min'=>'El semestre debe tener un valor minimo de :min',
        'semester.max'=>'El semestre debe tener un valor maximo de :max',
        'p_academico'=>'El Programa Academico seleccionado no se encuentra en la base de datos',
        'p_academico.min'=>'El Programa Academico seleccionado no se encuentra en la base de datos',
    ];

    protected function validator(array $data, $rules){
        return Validator::make($data, $rules, $this->messages);
    }

    //Database
    private function store(array $data){
        /*
            "name", "credits", "mhours", "ihours", "ctype", 
            "precourses", "valuable", "qualifiable" ,"p_academico"
        */
        return Courses::create([
            "name" => data['name'],
            "credits" => data['credits'], 
            "mhours" => (int)data['mhours'], //magistral hours
            "ihours" => (int)data['ihours'], //independent hours
            "ctype" =>  (int)data['ctype'],  //course type
            "precourses" => data['precourses'],        //listado de cursos previos 
            "valuable" => (bool)data['valuable'],    //
            "qualifiable" => (bool)data['qualifiable'], //
            "p_academico" => (int)data['p_academico'],
            "semester" => (int)data['semester']
        ]);
    }
    
    private function edit(array $data,$id){
        $course = Courses::find($id);
        $course->name = data['name'];
        $course->credits = data[''];
        $course->mhours = data[''];
        $course->ihours = data['ihours'];
        $course->ctype = data['ctype'];
        $course->precourses = data['precourses'];
        $course->valuable = data['valuable'];
        $course->qualifiable = data['qualifiable'];
        return $course->save();
    }

    public static function allCourses(){
        return Courses::all();
    }

    public static function paginateCourses(){
        return Courses::paginate(10);
    }

    //REST FUNCTIONS
    //GET
    public function showEdit($id){
        if(!is_null($id)){
            $user = Auth::user();
            $course = Courses::find($id);
            //dd($program);
            if(!$course){
                alert()->info('Información','El Curso no se puede modificar dada su inhabilidad ó simplemente no existe');
                return redirect('/home/consultar');
            }
            if ($user->role == 2 or $user->role==3)
                return view('forms.CRUD.edit')
                            ->withMaster([
                                'title'=>'Cursos',
                                'option'=>'update',
                                'model'=>'Course',
                                'fields'=>'courses',
                                'object'=>'course'
                            ])->withData($course)->withPrograms(AcademicProgramsController::allPrograms());
            else
                return redirect('/home/consultar');
        }
    }

    //POST
    public function create(Request $request){
        dd($request->all());
        $data = $request->all();
        $this->validator($data,$this->rules)->validate();
    }

    public function update(Request $request){
        dd($request->all());
    }

    public function delete($id){
        if(!is_null($id)){
            //dd(User::find($id)->trashed());
            if(Auth::user()->role != 3){
                if(Courses::find($id)->delete()){
                    alert()->success("Exito!","El curso ha sido eliminado");                    
                }else{    
                    alert()->error("Error!","");                    
                }
            }else{
                alert()->error("Error","Su cuenta no tiene el rol permitido para ejecutar esta acción");
            }
        }
        return redirect()->back();
    }
}
