<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::where('rol_id',2)->get();
        //dd($users)

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $users = $request->validate([
            'name'=>'required',
            'document' => 'required|string|min:6|max:10|unique:users,document', // Agregar la regla unique
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|min:6|max:10|unique:users,phone_number', // Agregar la regla unique
            'address'=>'required',
            'birthday'=>'required',
            'genere'=>'required|not_in:Seleccione su genero',
            'password'=>'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'age'=>'required'],
            [
                'email.unique' => 'El correo electrónico es invalido.',
                'document.unique' => 'El documento es invalido.',
                
            ]);


          // Eliminar espacio al final del nombre si existe
          $name = rtrim($request->input('name'));
        
        $user = new User();
        $user->name = $request->name;
        $user->document = $request->document;
        $user->email = $request->email;
        $user->phone_number = $request->phone;
        $user->address = $request->address;
        $user->birthday = $request->birthday;
        $user->genere = $request->genere;
        $user->password = bcrypt($request->password);
        $user->age = $request->age;
        if ($request->has('is_company')) {
            $user->Empresa_verificada = false;
            $user->rol_id = '3'; // Assign role 3 for company
            $user->assignRole('Empresa');
        } else {
            $user->rol_id = '2'; // Assign role 2 for regular user
            $user->assignRole('Visitante');
        }
    
        $user->save();
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        
        $validar = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'birthday'=>'required',
            'genere'=>'required',
            'password'=>'required|min:8|confirmed',
            'age'=>'required'
        ]);
        $users = User::find($id);
        $users->name = $request->name;
        $users->document = $request->document;
        $users->email = $request->email;
        $users->phone_number = $request->phone;
        $users->address = $request->address;
        $users->birthday = $request->birthday;
        $users->genere = $request->genere;
        $users->password = bcrypt($request->password);
        $users->age = $request->age;
        $users->rol_id = $request->rol_id;
        $users->update();
        return redirect()->route('user.listarusuarios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        $users->delete();
        return redirect()->route('user.index');
    }
    public function listarUsuarios()
    {
        $users = User::with('rol')->get();
        return view('users/listarusuarios', compact('users'));
    }
    public function empresasnoActivdas(){

        $users = User::where('rol_id', 3)
                    ->where(function($query) {
                        $query->where('Empresa_verificada', false)
                              ->orWhereNull('Empresa_verificada');
                    })->get();

        return view('users/empresasnoactivadas', compact('users'));
    }
    public function activarEmpresa(Request $request)
    {
        $userIds = $request->input('users', []);

        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                // Suponiendo que 'activado' es el nombre del campo en la base de datos
                $user->Empresa_verificada = true; // O cualquier lógica que desees para la actualización
                $user->save();
            }
        }

        return redirect()->back()->with('success', 'Usuarios actualizados exitosamente');
    }

}
