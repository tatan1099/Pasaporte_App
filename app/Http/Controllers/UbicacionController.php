<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UbicacionController extends Controller
{
     //
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        // Crear una nueva ubicación en la base de datos
        $ubicacion = Ubicacion::create([
            'latitud' => $request->input('latitud'),
            'longitud' => $request->input('longitud'),
        ]);

        // Devolver una respuesta
        return response()->json(['message' => 'Ubicación creada correctamente', 'ubicacion' => $ubicacion], 201);
    }
}
