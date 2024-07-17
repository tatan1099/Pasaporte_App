<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpresaController extends Controller
{

    private $service;
    private $user;

    public function __construct(AuthService $service)
    {
        $this->middleware('role:Evento');
        $this->service=$service;
        
    }
    private function userInauthenticated()
    {
        $this->user = $this->service->getUserAuthenticated();
        if (!$this->user || $this->user->rol->id != 4) {
            return view('auth/login', ['message' => 'No se ha logueado o no tiene los permisos']);
        }
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->userInauthenticated();
        $empresas = User::where('rol_id', 3)->get();
        return view('empresas/index', compact('empresas'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->userInauthenticated();
        return view('empresas/create');
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
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'document' => 'required|integer',
            'phone_number' => 'required|integer',
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['rol_id'] = 3;
        $user = User::create($data);
        $user->assignRole('Empresa');
     //return redirect()->route('empresa.index');
         // Redirigir al usuario a la vista de índice de stands
    return redirect()->route('empresas.index')->with('success', 'Empresa creada con exito');
    }
    catch (\Exception $e) {
        // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
        session()->flash('error', 'Error: No se  puede crear la empresa.');
        return redirect()->route('empresa.create');
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
        // $this->userInauthenticated();
        $empresa = User::find($id);
         // Verificar si el usuario autenticado tiene permisos para editar esta empresa
    if (!$this->user || $this->user->rol->nombre != 'Empresa') {
        return view('auth/login', ['message' => 'No tiene los permisos para editar esta empresa']);
    }
        return view('empresas.edit', compact('empresa'))->with('success', 'Empresa editada con exito');
        
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
        try{
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('empresa.index')->with('success', 'Usuario editado con éxito!');

       
    }
    catch (\Exception $e) {
        // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
        session()->flash('error', 'Error: No se  puede esitar la empresa.');
        return redirect()->route('empresa.edit');
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
        $user = User::find($id);
        $user->delete();
        return $this->index();
    }
   
}
