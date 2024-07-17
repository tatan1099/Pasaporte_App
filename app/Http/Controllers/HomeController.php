<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\carbon;
use App\Models\Event;

class HomeController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now = Carbon::now()->setTimezone('UTC'); // Obtiene la fecha y hora actual

        // Consulta los eventos cuya fecha de finalización es la actual o posterior
        $eventos = Event::where('end_date', '>=', $now->format('Y-m-d'))->get();
                 
        return view('eventos/listaeventos',compact('eventos'));
    }
}
