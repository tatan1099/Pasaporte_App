<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Redirige al usuario según su rol
        if ($user->hasRole('Visitante')) {
            $this->redirectTo = 'eventos/listaeventos'; // Redirige a 'eventos/listaeventos' para los visitantes
        } 
        elseif($user->hasRole('Administrador')) {
            $this->redirectTo = 'eventos/index'; // Redirige a '/index' para todos los usuarios que no sean visitantes
        }
        elseif ($user->hasRole('Empresa') && $user->Empresa_verificada == true) {
            $this->redirectTo = route('stands.inicio'); 
        } elseif ($user->hasRole('Empresa') && ($user->Empresa_verificada == false || $user->Empresa_verificada == null)) {
            $this->redirectTo = route('erroremrpesa');
        }
        else{
            $this->redirectTo = 'UserEvent/listaeventos'; 
        }
    }

}
