<?php

namespace App\Http\Controllers\CRUD;

use Auth;
use Alert;
use App\AcademicPrograms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUD\SchoolsController;
use Illuminate\Support\Facades\Validator;

class AcademicProgramsController extends Controller
{
    //"name", "school", "semester", "credits"

    //validator rules
    private $rules = [
        'name'=>'required|string|unique:academic_programs',
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

    public function showEdit($id){        
        if(!is_null($id)){
            $user = Auth::user();
            $program = AcademicPrograms::find($id);
            //dd($program);
            if(!$program){
                alert()->info('Información','El Programa no se puede modificar dada su inhabilidad ó simplemente no existe');
                return redirect()->back();
            }
            if ($user->role == 2 or $user->role==3)
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

    protected function edit(array $data){
        $id = $data['id'];
        $ap = AcademicPrograms::find($id);
        
        $ap->name = $data['name'];
        $ap->school = $data['school'];
        $ap->semester = $data['semester'];
        $ap->credits = $data['credits'];

        return $ap->save();
    }

    public static function allPrograms(){
        return AcademicPrograms::all();  
    }

    public static function paginatePrograms(){
        if(Auth::user()->role==3)
            return AcademicPrograms::withTrashed()->paginate(10);
        return AcademicPrograms::paginate(10);
    }
    
    //REST FUNCTIONS
    public function create(Request $request){
        //dd($request->all());
        $data = $request->all();
        $this->validator($data,$this->rules)->validate();

        if($this->store($data)){
            alert()->success("Exito!","Programa Académico registrado");
        }else{
            alert()->error("Error!","Un inconveniente ha ocurrido");
        }        
        return redirect()->back();
    }

    public function update(Request $request){
        dd($request->all());
    }

    public function delete($id){
        if(!is_null($id)){
            //dd(User::find($id)->trashed());
            $role =Auth::user()->role;
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
            if(Auth::user()->role == 3){
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
