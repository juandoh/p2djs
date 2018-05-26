<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomValidator;
use Illuminate\Support\Facades\Validator;

use App\Http\Auth\RegistersUsers;



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

    //use RegistersUsers;
    

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    private $rules = [
        'fullname' => 'required|string|max:191|min:10',
        'shortname' => 'required|string|max:191|min:5|unique:users',
        'email' => 'required|string|email|max:191|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|min:1|max:3'
    ];

    private $messages = [
        'fullname.min' => "El nombre completo debe tener al menos :min caracteres",
        'shortname.min' => "El nombre corto debe tener al menos :min caracteres",
        'shortname.unique' => "El nombre corto ya se ha asignado",
        'fullname.max' => "El nombre completo debe tener al menos :max caracteres",
        'shortname.max' => "El nombre corto debe tener al menos :max caracteres",        
        'email.unique' => 'El correo electronico ya se ha asignado',
        'password.min' => "La contraseña debe tener al menos :min caracteres",        
    ];

    protected function validator(array $data, $rules)
    {
        return Validator::make($data, $rules, $this->messages);
    }

    public function validateField(Request $request){
        return CustomValidator::validateField($request,$this->rules,$this->messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'fullname' => $data['fullname'],
            'shortname' => $data['shortname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);
    }

    protected function update(array $data)
    {        
        $user = User::find($data['id']);
        //dd($user);
        $user->fullname = $data['fullname'];
        $user->shortname = $data['shortname'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        
        if(Auth::user()->role == 0){
            $user->role = $data['role'];
        }

        return $user->save();
    }

    
    public function registerUser(Request $request){
        $data = $request->all();
        //dd($data);
        $this->validator($data, $this->rules)->validate();

        if($this->create($data)){
            alert()->success("Exito!","Usuario registrado");
        }else{
            alert()->error("Error!","Un inconveniente ha ocurrido");
        }
        //toast("Usuario registrado!",'success','bottom-right');
        return redirect()->back();
    }

    public function updateUser(Request $request){
        $data = $request->all();
        //dd($data);        
        if(Auth::user()->role == 0){
            $rules = [
                'id'=>'exists:users,id',
                'fullname' => 'required|string|max:255|min:10',
                'shortname' => 'required|string|max:255|min:5',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6|confirmed',
            ];

            if(Auth::user()->role == 0){
                $rules['role'] = 'required';
            }

            $this->validator($data,$rules)->validate();
            if($this->update($data)){
                alert()->success("Exito!","Cambios guardados");
                return redirect()->back();
            }
        }
        alert()->error("Error!","Un inconveniente ha ocurrido");
        return redirect()->back();
    }

    public static function listUsers(){
        return User::withTrashed()->paginate(10);
    }

    public function deleteUser($id = null){        
        if(!is_null($id) and $id != 1){
            //dd(User::find($id)->trashed());
            if(User::find($id)->delete()){
                if(Auth::user()->role != 0){
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
        if(!is_null($id)){
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
