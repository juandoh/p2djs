<?php

namespace App\Http\Controllers\CRUD;

use Auth;
use Alert;
use Relations;
use App\Faculties;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\RegisterController;

class FacultiesController extends Controller
{
    //Validation rules
    private $rules=[
        'name'=>'required|string|max:101|unique:faculties,name',
        'detail'=>'required|string|max:255'
    ];
    //Validation messages
    private $messages=[
        'required'=>'Este campo es obligatorio',
        'name.unique'=>'Ya existe una facultad con ese nombre',
        'detail.max'=>'La descripción no debe ser mayor a :max caracteres',
    ];

    protected function validator(array $data, $rules){
        return Validator::make($data, $rules, $this->messages);
    }

    //Database
    private function store(array $data){
        return Faculties::create([
            'name'=>$data['name'],
            'detail'=>$data['detail']
        ]);
    }

    private function edit(array $data,$id){
        $faculty = Faculties::find($id);
        if($faculty){
            $faculty->name = $data['name'];
            $faculty->detail = $data['detail'];
            return $faculty->save();
        }
        return false;
    }

    public static function allFaculties(){
        return Faculties::all();
    }

    public static function paginateFaculties(){
        if(Relations::isAdmin(Auth::id()))
            return Faculties::withTrashed()->paginate(10);
        return Faculties::paginate(10);
    }

    //REST FUNCTIONS
    //GET
    public function showEdit($id){
        if(!is_null($id)){
            $user = Auth::user();
            $faculty = Faculties::find($id);
            //dd($program);
            if(!$faculty){
                alert()->info('Información','La Facultad no se puede modificar dada su inhabilidad ó simplemente no existe');
                return redirect('/home/facultades');
            }
            if (Relations::isAdmin(Auth::id()))
                return view('forms.CRUD.edit')
                            ->withMaster([
                                'title'=>'Facultad',
                                'option'=>'update',
                                'model'=>'Faculty',
                                'fields'=>'faculties',
                                'object'=>'faculty'
                            ])->withData($faculty);
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
                alert()->success("Exito!","La Facultad ha sido registrada");
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
                'name'=>'required|string|max:255|exists:faculties,name',
                'detail'=>'required|string|max:255'
            ];
            $data = $request->all();
            $this->validator($data,$rules)->validate();
            $id = $data['id'];

            if($this->edit($data,$id)){
                alert()->success("Exito!","La Facultad ha sido modificada");
                return redirect('/home/facultades');
            }
        }
        alert()->error("Error!","Un inconveniente ha ocurrido");
        return redirect()->back();
    }

    public function delete($id){
        //dd($id);
        if(!is_null($id)){
            if(Relations::isAdmin(Auth::id())){
                if(Faculties::find($id)->delete()){
                    alert()->success("Exito!","La Facultad ha sido eliminada");
                    return redirect('/home/facultades');
                }else{
                    alert()->error("Error!","La Facultad no pudo eliminarse");
                }
            }else{
                alert()->error("Error","Su cuenta no tiene el rol permitido para ejecutar esta acción");
            }
        }
        return redirect('/home/facultades');
    }

    public function enable($id = null){
        if(!is_null($id)){
            if(Relations::isAdmin(Auth::id())){
                $faculty = Faculties::onlyTrashed()->where('id',$id);

                if($faculty->restore()){
                    alert()->success('Exito!','La Facultad se ha restaurado');
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
