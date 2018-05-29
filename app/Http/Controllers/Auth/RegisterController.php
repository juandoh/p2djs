<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Relations;
use Illuminate\Http\Request;
use App\Http\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomValidator;
use Illuminate\Support\Facades\Validator;

use App\UserAdminRelation;
use App\UserFacultyRelation;
use App\UserAcademicProgramRelation;
use App\Http\Controllers\Auth\RegisterController;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private $rules = [
        'fullname' => 'required|string|max:191|min:10',
        'shortname' => 'required|string|max:191|min:5|unique:users',
        'email' => 'required|string|email|max:191|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|min:1|max:3',
    ];

    private $messages = [
        'fullname.min' => "El nombre completo debe tener al menos :min caracteres",
        'shortname.min' => "El nombre corto debe tener al menos :min caracteres",
        'shortname.unique' => "El nombre corto ya se ha asignado",
        'fullname.max' => "El nombre completo debe tener al menos :max caracteres",
        'shortname.max' => "El nombre corto debe tener al menos :max caracteres",        
        'email.unique' => 'El correo electronico ya se ha asignado',
        'password.min' => "La contraseña debe tener al menos :min caracteres",   
        'program_id.exists'=>"El Programa Academico seleccionado no existe",
        'faculty_id.exists'=>"La Facultad seleccionada no existe",
        'password.confirmed'=>'Las contraseñas no coinciden',
    ];

    protected function validator(array $data, $rules)
    {
        return Validator::make($data, $rules, $this->messages);
    }

    public function validateField(Request $request){
        return CustomValidator::validateField($request,$this->rules,$this->messages);
    }

    protected function create(array $data)
    {
        return User::create([
            'fullname' => $data['fullname'],
            'shortname' => $data['shortname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])            
        ]);
    }

    protected function update(array $data)
    {        
        $user_id = $data['id'];
        $user = User::find($user_id);
        //dd($user);
        if(is_null($user))
            return false;

        $user->fullname = $data['fullname'];
        $user->shortname = $data['shortname'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);

        return $user->save();
    }

    private function updateRole($user_id){
        if(array_key_exists('role', $data) and array_key_exists('program_id', $data)){
            $drole=(int)$data['role'];
            if($drole== 1 or $drole== 2){ //teacher
                if(Relations::isProgramBinded($user_id)){
                    UserAcademicProgramRelation::where('user_id',$user_id)->delete();
                }
                return Relations::bindUserProgram($user_id, $role, $data['program_id']);                
            }
        }elseif(array_key_exists('role', $data) and array_key_exists('faculty_id', $data)){
            if($drole == 3){
                if(Relations::isFacultyBinded($user_id)){
                    UserFacultyRelation::where('user_id',$user_id)->delete();
                }
                return Relations::bindUserFaculty($user_id, $drole, $data['program_id']);
            }
        }
        return false;
    }

    
    public function registerUser(Request $request){
        //dd($data);
        if(Relations::isAdmin(Auth::id())){
            $data = $request->all();
            //dd($data);
            $rules = $this->rules;

            $bindProgram = array_key_exists('program_id', $data);
            $bindFaculty = array_key_exists('faculty_id', $data);
            if($bindProgram){
                $rules['program_id'] = 'required|integer|exists:academic_programs,id';
            }elseif($bindFaculty){
                $rules['faculty_id'] = 'required|integer|exists:faculties,id';
            }

            $this->validator($data, $rules)->validate();

            $user = $this->create($data);
            if($user){
                $success=false;
                if($bindProgram){
                    $success = Relations::bindUserProgram($user->id,$data['role'],$data['program_id']);
                }elseif($bindFaculty){
                    $success = Relations::bindUserFaculty($user->id,$data['role'],$data['faculty_id']);                        
                }

                if($success){
                    alert()->success("Exito!","Usuario registrado correctamente");
                    return redirect()->back();
                }else{
                    $user->delete();
                }
            }            
        }
        alert()->error("Error!","Un inconveniente ha ocurrido");
        return redirect()->back();
    }

    public function updateUser(Request $request){
        $data = $request->all();
        //dd($data);        
        $rules = [
            'id'=>'exists:users,id',
            'fullname' => 'required|string|max:255|min:10',
            'shortname' => 'required|string|max:255|min:5',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ];

        if(Relations::isAdmin(Auth::id())){
            if(array_key_exists('program_id', $data)){
                $rules['program_id'] = 'required|integer|exists:academic_programs,id';
            }elseif(array_key_exists('faculty_id', $data)){
                $rules['faculty_id'] = 'required|integer|exists:faculties,id';
            }
        }

        $this->validator($data,$rules)->validate();
        if($this->update($data)){
            alert()->success("Exito!","Cambios guardados");
        }else{
            alert()->error("Error!","Un inconveniente ha ocurrido");            
        }

        return redirect()->back();
    }

    public static function listUsers(){
        if(Relations::isAdmin(Auth::id()))
            return User::withTrashed()->paginate(10);
        else
            return null;
    }

    public function deleteUser($id = null){        
        if(!is_null($id) and $id != 1){
            //dd(User::find($id)->trashed());
            if(User::find($id)->delete()){
                if(!Relations::isAdmin(Auth::id())){
                    Auth::logout();
                    alert()->warning("Atención!","Su cuenta ha sido deshabilitada, para volver a acceder comuniquese con un administrador");
                }else{
                    alert()->warning("Atención!","La cuenta ha sido deshabilitada");
                }            
            }else{
                alert()->error("Error!","Un inconveniente ha ocurrido");
            }
        }
        return redirect('/home/consultar');
    }

    public function enableUser($id = null){
        if(!is_null($id) and Relations::isAdmin(Auth::id())){
            $user = User::onlyTrashed()->where('id',$id);
            
            if($user->restore()){
                alert()->success('Exito!','El usuario se ha restaurado');
            }else{
                alert()->error("Error!","Un inconveniente ha ocurrido");
            }
            return redirect('/home/consultar');
        }
    }
}
