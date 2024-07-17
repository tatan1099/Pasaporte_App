<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Schedule;

class ScheduleController extends Controller
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
        if (!$this->user || $this->user->rol->nombre != 'Administrador') {
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
        
        $schedules= Schedule::all();
        //dd($places);
        return view('schedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->userInauthenticated();

        return view('schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->userInauthenticated();

        $validate = $request->validate([
            'day'=>'required',
            'hour_start'=>'required',
            'hour_end'=>'required',
        ]);

        //dd($request);
        $schedule= new Schedule();
        $schedule->day = $request->day;
        $schedule->hour_start = $request->hour_start;
        $schedule->hour_end = $request->hour_end;
        $schedule->save();
        return redirect()->route('schedule.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show($schedule)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->userInauthenticated();

        $schedule = Schedule::find($id);

        return view('schedule.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->userInauthenticated();
        $validate = $request->validate([
            'day'=>'required',
            'hour_start'=>'required',
            'hour_end'=>'required',
        ]);

        //dd($request);
        $schedule = Schedule::find($id);
        $schedule->day = $request->day;
        $schedule->hour_start = $request->hour_start;
        $schedule->hour_end = $request->hour_end;
        $schedule->update();
  
        return redirect()->route('schedule.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userInauthenticated();
        $schedule = Schedule::find($id);   
        if ($schedule) {
            $schedule->delete();
            return redirect()->route('schedule.index')->with('success', 'Lugar eliminado exitosamente');
        } else {
            return redirect()->route('schedule.index')->with('error', 'No se encontró el lugar para eliminar');
        }
    }
}