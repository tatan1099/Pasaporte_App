<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;

use App\Models\User;
use App\Models\Stand;
use App\Models\Places;
use App\Models\Passport;
use App\Models\Schedule;

class PassportController extends Controller
{

    private $service;
    private $user;

    public function __construct(AuthService $service)
    {
        $this->service=$service;
        
    }

    private function userInauthenticated()
    {
        $this->user = $this->service->getUserAuthenticated();
        if (!$this->user || $this->user->rol->nombre != 'Visitante') {
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
        $this->userInauthenticated();
        $passports= Passport::where('user_id',  $this->user->id)->with('stand')->get();
        //dd($passports);
        return view('passport.index', compact('passports'));
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $this->userInauthenticated();
        return view('passport.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($stand_id)
    {   
        $this->userInauthenticated();
        $passport= new Passport();
        $passport->date = Carbon::now();
        $passport->user_id = $this->user->id;
        $passport->stand_id = $stand_id;
        $passport->save();
        return view('paginas-sello/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }
}    