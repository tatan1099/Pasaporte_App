<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ], [
        //     'email.unique' => 'El correo electrónico ya está en uso.',
        ]);
    }

   
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        // Verificar si el correo electrónico ya existe en la base de datos
        $userExists = User::where('email', $email)->exists();

        return response()->json(['exists' => $userExists]);
    }

//     public function checkEmail(Request $request)
// {
//     $email = $request->input('email');

//     // Verifica si el correo electrónico ya existe en la base de datos
//     $exists = User::where('email', $email)->exists();

//     return response()->json(['exists' => $exists]);
// }

    
    


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * 
     * @return \App\Models\User
     */

     protected function create(array $data)
     {
         try {
             // Intenta crear el nuevo usuario
             return User::create([
                 'name' => $data['name'],
                 'email' => $data['email'],
                 'password' => Hash::make($data['password']),
                 // Agrega aquí los demás campos del usuario
            

             ]);
            //  return redirect()->route('login.authenticated')->with('success', 'Usuario creado satisfactoriamente.');
             return redirect()->route('login')->with('success', '¡Usuario registrado correctamente!');
            //  return $user;
         } catch (QueryException $e) {
             // Captura la excepción de clave duplicada
             if ($e->errorInfo[1] === 1062) {
                 // El código 1062 indica una excepción de clave duplicada
                 return redirect()->back()->withInput()->withErrors(['email' => 'El correo electrónico ya está en uso.']);
             } else {
               
                 // Otra excepción, redireccionar con un mensaje genérico de error
                 session()->flash('error', 'Error: No se  puede  registrar');
                 return redirect()->back()->withInput()->withErrors(['error' => 'Ha ocurrido un error al registrar el usuario. Por favor, inténtalo de nuevo.']);
             }
         }
     }
//     protected function create(array $data)
// {
    
//     // Si el correo electrónico no está en uso, crear el nuevo usuario
//     return User::create([
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'password' => Hash::make($data['password']),
//         // Otros campos del usuario
//     ]);
// }



        //  return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);

}

