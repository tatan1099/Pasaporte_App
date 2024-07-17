<?php
namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Stand;
use App\Models\Agenda;
use App\Models\Places;
use App\Models\Schedule;

class AgendaController extends Controller
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
        if (!$this->user || $this->user->rol->nombre != 'Evento') {
            return view('auth/login', ['message' => 'No se ha logueado o no tiene los permisos']);
        }
        // $this->user = $this->service->getUserAuthenticated();
        // if (!$this->user || !in_array($this->user->rol->nombre, ['3', '4'])) {
        //     return view('auth/login', ['message' => 'No se ha logueado o no tiene los permisos']);
        // }
    }
    private function translateDate($date) {
        $timestamp = strtotime($date);

        //nombre del día de la semana
        $day = date('l', $timestamp);
        // numero del día del mes
        $day_number = date('j', $timestamp); 

        $resultado = ucfirst($day);
        $weekday='';
        switch ($resultado) {
            case 'Monday':
                $weekday = 'Lunes';
                break;
            case 'Tuesday':
                $weekday = 'Martes';
                break;
            case 'Wednesday':
                $weekday = 'Miércoles';
                break;
            case 'Thursday':
                $weekday = 'Jueves';
                break;
            case 'Friday':
                $weekday = 'Viernes';
                break;
            case 'Saturday':
                $weekday= 'Sábado';
                break;
            case 'Sunday':
                $weekday = 'Domingo';
                break;      
        }

        $dateFormat= $weekday . ', ';
        return $dateFormat;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->userInauthenticated();
        
        $agendas= Agenda::with('place', 'stand')->get();
        
        $dateSta_format = [];
        $dateEnd_format = [];

        
        foreach ($agendas as $agenda) {
            $dateFormat = $this->translateDate($agenda->date_start);
            $dateFormat2 = $this->translateDate($agenda->date_end);
            $dateSta_format[] = $dateFormat;
            $dateEnd_format[] = $dateFormat2; 
        }

        

        //dd($dateFormats);
        
        return view('agenda.index', compact('agendas', 'dateSta_format', 'dateEnd_format'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->userInauthenticated();

        $stands= Stand::all();
        $places= Places::all();
        return view('agenda.create', compact('stands', 'places'));
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
            'date_start'=>'required',
            'date_end'=>'required',
            'stand_id'=>'required',
            'place_id'=>'required',
        ]);

        $timestamp1 = strtotime($request->date_start);
        $timestamp2 = strtotime($request->date_end);

        // Obtener el nombre del día de la semana y el día del mes
        $day = date('l', $timestamp1);
        $day2 = date('l', $timestamp2);
        //$numeroDia = date('j', $timestamp); // Obtener el número del día del mes

        // traducir weekday a dia semana
        $result = $this->translateDate(ucfirst($request->date_start));

        //dd($schedule);

        $agenda= new Agenda();
        $agenda->date_start = $request->date_start;
        $agenda->date_end = $request->date_end;
        $agenda->stand_id = $request->stand_id;
        $agenda->place_id = $request->place_id;
        $agenda->save();
        return redirect()->route('agenda.index',compact('result'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show($agenda)
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

        $agenda = Agenda::find($id);
        $stands= Stand::all();
        $places= Places::all();

        return view('agenda.edit', compact('agenda', 'stands', 'places'));
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
        $validate = $request->validate([

            'stand_id'=>'required',
            'place'=>'required',
        ]);

        //dd($request);
        $data = json_decode($request->place);

        $agenda= Agenda::find($id);
        $date= Schedule::find($data->schedule_id);

        $agenda->date_start = $date->hour_start;
        $agenda->date_end = $date->hour_end;
        $agenda->place_id = $data->id;
        $agenda->stand_id = $request->stand_id;
        $agenda->save();
        return redirect()->route('agenda.index');    
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
        $agenda = Agenda::find($id);   
        if ($agenda) {
            $agenda->delete();
            return redirect()->route('agenda.index')->with('success', 'Lugar eliminado exitosamente');
        } else {
            return redirect()->route('agenda.index')->with('error', 'No se encontró el lugar para eliminar');
        }
    }
}
