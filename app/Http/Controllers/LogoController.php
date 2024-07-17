<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logo;

class LogoController extends Controller
{

    private function userInauthenticated()
    {
        $this->user = $this->service->getUserAuthenticated();
        if (!$this->user || !in_array($this->user->rol->nombre,['Administrador'])) {
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
        return view('Home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('logo/upload_logo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //     $logo = $request->file('logo');
    //     $nombreImagen = $request->name . '-logo.' . $logo->extension();
    //     $logo->storeAs('public/images', $nombreImagen);
    //     $logo = Logo::create([
    //         'logo' => "images/{$nombreImagen}",
    //     ]);
    //     return $this->index(); 
     // Validar y guardar el logo
     $request->validate([
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $logo = $request->file('logo');
    $nombreImagen = $request->name . '-logo.' . $logo->getClientOriginalExtension();

    // Guardar el archivo en la carpeta public/images
    $logo->move(public_path('images'), $nombreImagen);

    // Guardar el registro en la base de datos
    $logo = Logo::create([
        'logo' => "images/{$nombreImagen}",
    ]);

    return redirect()->route('home')->with('success', 'Logo guardado correctamente.');
    
   
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
