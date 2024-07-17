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
        return view('users/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try{
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
                'phone_number.unique' => 'El telefono es invalido.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
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
        return redirect()->route('home')->with('success', 'úsuario creado con éxito.');
    }catch (\Exception $e) {
        // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
        session()->flash('error', 'Error: No se  puede crear el registro.');
        return redirect()->route('registroes');
    }
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
    try {
        // Validar los datos del formulario
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'document' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'birthday' => 'required|date',
            'genere' => 'required|string',
            'age' => 'required|integer|min:18|max:120',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Encontrar el usuario por su ID
        $user = User::findOrFail($id);

        // Actualizar los datos del usuario
        $user->name = $request->input('name');
        $user->document = $request->input('document');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone');
        $user->address = $request->input('address');
        $user->birthday = $request->input('birthday');
        $user->genere = $request->input('genere');
        $user->age = $request->input('age');
        
        // Actualizar la contraseña solo si se proporciona una nueva
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Guardar los cambios
        $user->save();

        // Redirigir con un mensaje de éxito si la actualización fue exitosa
        if ($request->user()->hasRole('Administrador')) {
            return redirect()->route('user.listarusuarios')->with('success', 'Usuario editado con éxito!');
        } elseif ($request->user()->hasRole('Empresa')) {
            return redirect()->route('Empresa.user.edit', ['id' => $id])->with('success', 'Usuario editado con éxito!');
        } elseif ($request->user()->hasRole('Evento')) {
            return redirect()->route('empresas.index')->with('success', 'Usuario editado con éxito!');
        } else {
            return redirect()->route('default.dashboard')->with('success', 'Usuario editado con éxito!');
        }
    } catch (\Exception $e) {
        // Redirigir con un mensaje de error si hubo errores
        if ($request->user()->hasRole('Administrador')) {
            return redirect()->route('user.edit', ['id' => $id])->with('error', 'Error: No se puede editar el usuario.');
        } elseif ($request->user()->hasRole('Empresa')) {
            return redirect()->route('Empresa.user.edit', ['id' => $id])->with('error', 'Error: No se puede editar el usuario.');
        } elseif ($request->user()->hasRole('Evento')) {
            return redirect()->route('Empresa.user.edits', $id)->with('error', 'Error: No se puede editar el usuario.');
        } else {
            return redirect()->route('user.create')->with('error', 'Error: No se puede editar el usuario.');
        }
    }
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
        try{
        $userIds = $request->input('users', []);

        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                // Suponiendo que 'activado' es el nombre del campo en la base de datos
                $user->Empresa_verificada = true; // O cualquier lógica que desees para la actualización
                $user->save();
            }
        }

        return redirect()->back()->with('success', 'empresa activada con exito');
    }
    catch (\Exception $e) {
        // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
        session()->flash('error', 'Error: No se puede actualizar la empresa.');
        return view('empresasnoactivadas');
    }
}

}
