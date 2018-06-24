<?php

namespace App\Http\Controllers\CRUD;

use Auth;
use Alert;
use Relations;
use App\AcademicPrograms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CRUD\SchoolsController;
use App\Http\Controllers\Auth\RegisterController;

class AcademicProgramsController extends Controller
{
    //"name", "school", "semester", "credits"

    //validator rules
    private $rules = [
        'name'=>'required|string|unique:academic_programs|max:191',
        'school' => 'required|numeric|exists:schools,id',
        'semesters'=>'required|numeric|min:1',
        'credits'=> 'required|numeric|min:1',
    ];
    //validator messages
    private $messages=[
        'required'=>'El atributo es obligatorio',
        'unique'=>'El Programa Academico ya existe',
        'exists'=>'La Escuela seleccionada no se encuentra en la base de datos',
    ];

    protected function validator(array $data, $rules){        
        return Validator::make($data, $rules, $this->messages);
    }

    protected function store(array $data){
        return AcademicPrograms::create([
            'name' => $data['name'],
            'school' => $data['school'],
            'semesters' => $data['semesters'],
            'credits' => $data['credits'],
        ]);
    }

    protected function edit(array $data){
        $id = $data['id'];
        $ap = AcademicPrograms::find($id);

        if($ap){
            $ap->name = $data['name'];
            $ap->school = $data['school'];
            $ap->semesters = $data['semesters'];
            $ap->credits = $data['credits'];
            return $ap->save();
        }
        return false;
    }

    public function showEdit($id){
        if(!is_null($id)){
            $role = Relations::resolveRole(Auth::id());
            $program = AcademicPrograms::find($id);
            //dd($program);
            if(!$program){
                alert()->info('Información','El Programa no se puede modificar dada su inhabilidad ó simplemente no existe');
                return redirect()->back();
            }
            if ($role == 2 or $role==3)
                return view('forms.CRUD.edit')
                            ->withMaster([
                                'title'=>'Programa Academico',
                                'option'=>'update',
                                'model'=>'Program',
                                'fields'=>'programs',
                                'object'=>'program'
                            ])->withData($program)->withSchools(SchoolsController::allSchools());
            else
                return redirect()->back();
        }
    }


    public static function allPrograms(){
        return AcademicPrograms::all();
    }

    public static function paginatePrograms(){
        if(Relations::isDean(Auth::id()))
            return AcademicPrograms::withTrashed()->paginate(10);
        return AcademicPrograms::paginate(10);
    }

    //REST FUNCTIONS
    public function create(Request $request){
        //dd($request->all());
        if(Relations::isDean(Auth::id())){
            $data = $request->all();
            $this->validator($data,$this->rules)->validate();

            if($this->store($data)){
                alert()->success("Exito!","Programa Académico registrado");
                return redirect()->back();
            }
        }
        alert()->error("Error!","Un inconveniente ha ocurrido");
        return redirect()->back();
    }

    public function update(Request $request){
        $id = Auth::id();
        if(Relations::isDean($id) or Relations::isDirector($id)){
            $data = $request->all();
            $updateRules = $this->rules;
            $updateRules['name']='required|string|max:255';
            $this->validator($data,$updateRules)->validate();

            if($this->edit($data)){
                alert()->success("Exito!","El Programa Académico ha sido modificado");
                return redirect()->back();
            }
        }
        alert()->error("Error!","Un inconveniente ha ocurrido");
        return redirect()->back();
    }

    public function delete($id){
        if(!is_null($id)){
            //dd(User::find($id)->trashed());
            $role =User::resolveRole(Auth::id());
            if($role == 3 or $role==0){
                if(AcademicPrograms::find($id)->delete()){
                    alert()->success("Exito!","El Programa Academico ha sido eliminado. Recuerde que debido a dependencias solo se desactiva");
                }else{
                    alert()->error("Error!","");
                }
            }else{
                alert()->error("Error","Su cuenta no tiene el rol permitido para ejecutar esta acción");
            }
        }
        return redirect()->back();
    }

    public function enable($id = null){
        if(!is_null($id)){
            if(Relations::isDean(Auth::id())){
                $program = AcademicPrograms::onlyTrashed()->where('id',$id);

                if($program->restore()){
                    alert()->success('Exito!','El Programa Academico se ha restaurado');
                }else{
                    alert()->error("Error!","Un inconveniente ha ocurrido");
                }
            }else{
                alert()->error("Error","Su cuenta no tiene el rol permitido para ejecutar esta acción");
            }
        }
        return redirect()->back();
    }
}
