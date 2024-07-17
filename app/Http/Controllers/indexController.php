<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stand;
use App\Models\Event;
use Carbon\Carbon;

class indexController extends Controller
{
    public function index()
    {
      

        // Consulta los eventos que están dentro del rango de fechas



        // $eventos = event::all();
        // $eventos = Event::where('end_date', '>=', $now)->get();
             

        // return view('index', compact('eventos'));

    

    // Imprime la fecha actual que está siendo utilizada
    $now = Carbon::now()->setTimezone('UTC'); // Obtiene la fecha y hora actual

    // Consulta los eventos cuya fecha de finalización es la actual o posterior
    $eventos = Event::where('end_date', '>=', $now->format('Y-m-d'))->get();
             
    return view('index', compact('eventos'));;



        // $eventos = event::all();
        // return view('index', compact('eventos'));
    }
}
