<?php

namespace App\Http\Controllers\CRUD;

use Auth;
use Alert;
use Relations;
use App\Schools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;

class SchoolsController extends Controller
{
    //Validation rules
    private $rules=[
        'name'=>'required|string|max:191|unique:schools,name',
        'faculty' =>'required|numeric|exists:faculties,id',
        'detail'=>'required|string|max:255'
    ];
    //Validation messages
    private $messages=[
        'required'=>'Este campo es obligatorio',
        'name.unique'=>'Ya existe una escuela con ese nombre',
        'exists'=>"La Facultad seleccionada no está registrada en la base de datos",
        'detail.max'=>'La descripción no debe ser mayor a :max caracteres',
    ];

    protected function validator(array $data, $rules){
        return Validator::make($data, $rules, $this->messages);
    }
    //Database
    private function store(array $data){
        return Schools::create([
            'name'=>$data['name'],
            'faculty'=>$data['faculty'],
            'detail'=>$data['detail']
        ]);
    }
    
    private function edit(array $data,$id){
        $school = Schools::find($id);
        if($school){
            $school->name = $data['name'];
            $school->detail = $data['detail'];
            return $school->save();
        }
        return false;
    }

    public static function allSchools(){
        return Schools::all();
    }

    public static function paginateSchools(){
        if(Relations::isAdmin(Auth::id()))
            return Schools::withTrashed()->paginate(10);
        return Schools::paginate(10);
    }

    //REST FUNCTIONS
    //GET
    public function showEdit($id){
        if(!is_null($id)){
            $school = Schools::find($id);
            //dd($program);
            if(!$school){
                alert()->info('Información','La Escuela no se puede modificar dada su inhabilidad ó simplemente no existe');
                return redirect()->back();
            }
            if (Relations::isAdmin(Auth::id()))
                return view('forms.CRUD.edit')
                            ->withMaster([
                                'title'=>'Escuela',
                                'option'=>'update',
                                'model'=>'School',
                                'fields'=>'schools',
                                'object'=>'school'
                            ])->withData($school);
            else
                return redirect()->back();
        }
    }

    //POST
    public function create(Request $request){
        //dd($request->all());
        if(Relations::isAdmin(Auth::id())){
            $data = $request->all();
            $this->validator($data,$this->rules)->validate();

            if($this->store($data)){
                alert()->success("Exito!","La Escuela ha sido registrada");
                return redirect()->back();
            }
        }
        alert()->error("Error!","Un inconveniente ha ocurrido");
        return redirect()->back();
    }

    public function update(Request $request){
        //dd($request->all());
        if(Relations::isAdmin(Auth::id())){
            $rules=[
                'name'=>'required|string|max:255|exists:schools,name',
                'detail'=>'required|string|max:255'
            ];
            $data = $request->all();
            $this->validator($data,$rules)->validate();
            $id = $data['id'];

            if($this->edit($data,$id)){
                alert()->success("Exito!","La Escuela ha sido modificada");
                return redirect('/home/escuelas');
            }
        }
        alert()->error("Error!","Un inconveniente ha ocurrido");
        return redirect()->back();
    }

    public function delete($id){
        if(!is_null($id)){
            if(Relations::isAdmin(Auth::id())){
                if(Schools::find($id)->delete()){
                    alert()->success("Exito!","La Escuela ha sido eliminada");
                }else{
                    alert()->error("Error!","La Escuela no pudo eliminarse");                    
                }
            }else{
                alert()->error("Error","Su cuenta no tiene el rol permitido para ejecutar esta acción");
            }
        }
        return redirect()->back();
    }

    public function enable($id = null){
        if(!is_null($id)){
            if(Relations::isAdmin(Auth::id())){
                $school = Schools::onlyTrashed()->where('id',$id);
                
                if($school->restore()){
                    alert()->success('Exito!','La Escuela se ha restaurado');
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

