<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;
use App\Models\Place_event;
use App\Models\Evento;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;



class EventController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private $service;
    private $user;
    

    public function __construct(AuthService $service)
    {
        
        $this->service=$service;
        
    }

    private function userInauthenticated()
    {
        $this->user = $this->service->getUserAuthenticated();
        if (!$this->user || ($this->user->rol->nombre != 'Evento' && $this->user->rol->nombre != 'Visitante' && $this->user->rol->nombre != 'Administrador')) {
            return view('auth/login', ['message' => 'No se ha logueado o no tiene los permisos']);
        }
    }
    public function index()
    {
        $this->userInauthenticated();
        $eventos = User::where('rol_id', 4)->get();
        return view('eventos/index',compact('eventos'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->userInauthenticated();
        
        return view('eventos/create');
    }
    
    public function listaEventos()
    {
        $this->userInauthenticated();
        $now = Carbon::now()->setTimezone('UTC'); // Obtiene la fecha y hora actual

        // Consulta los eventos cuya fecha de finalización es la actual o posterior
        $eventos = Event::where('end_date', '>=', $now->format('Y-m-d'))->get();
                 
        return view('eventos/listaeventos',compact('eventos'));
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
        
        $data = $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => 'required|string',
            'document' => 'required|integer',
            'phone_number' => 'required|integer',
            'multi_evento' => 'sometimes',
            // 'fecha_inicio' => 'required|string',
            // 'fecha_fin'=> 'required|string',
            // 'Hora_inicio'=> 'required|string',
            // 'Hora_cierre'=> 'required|string',
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['rol_id'] = 4;
       
        $user = User::create($data);
        $user->multi_evento = $request->has('multi_evento');
        $user->save();
        $user->assignRole('Evento');
        //para asignar el valor del check box 
        return redirect()->route('eventos.index')->with('success', 'Usuario creado con éxito!');
       // return redirect()->route('eventos.index');
    
} catch (\Exception $e) {
    // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
    session()->flash('error', 'Error: No se  puede crear el usuario.');
    return redirect()->route('eventos.create');
}
}
    
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');

        // Verificar si el correo electrónico ya existe en la base de datos
        $userExists = User::where('email', $email)->exists();

        return response()->json(['exists' => $userExists]);
    }
    public function generar()
    {
        $this->userInauthenticated();
        return redirect()->route('eventos.generar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generarevento(Request $request)
    {  
        $data = $request->validate([
        'name' => 'required|string',
        // 'logo' => $nombreImagen ,
        // 'banner' => $nombreBanner,'required',
        // en los campos de imagenes se da los formatos admitidos y la resoluciòn maxima 
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para el campo de logo
        'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required|string',
        'facebook' => 'required|string',
        'instagram' => 'required|string',
        'tiktok' => 'required|string',
        'web' => 'required|string',
        'calification' => 'required|numeric',
        'fecha_inicio' => 'required|string',
        'fecha_fin'=> 'required|string',
        'user_id' => 'required|integer',   
        'Hora_inicio'=> 'required|string',
        'Hora_cierre'=> 'required|string',
        ]);

        $evento = Event::create($data);

        // Redirigir al usuario a la página de eventos con un mensaje de éxito
        return redirect()->route('evento.generar')->with('success', 'Evento creado con éxito!');
    }

    //para tomar los lugares de la tabla 
    // private function Tomar_los_lugares()
    // {
    //     $data = $request->validate([
            
    //     $place = Places::all()
    //     ]);

    // }
    //para añadir los datos a la tabla intermedia de lugares y eventos 
    private function Guardar_los_lugares(Request $request)
    {
        Place_event::create([
            'place_id' => $request->input('place_id'),
            'event_id' => $request->input('event_id'), // Obtén el ID del evento según tu lógica
        ]);
    
        // Redirigir a donde sea apropiado
        return redirect()->route('evento.index');
    }

   
    public function show($id)
    {
        // Encuentra el evento por su ID y carga sus relaciones si es necesario
        $detalleEvento = Event::with('stands')->find($id);
    
        // Retorna solo el nombre y la descripción del evento en formato JSON
        return view('eventos.form', compact('detalleEvento'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */

     //para editar el evento 
    public function edit($id)
    {
        $evento=Event:: findOrFail($id);
        //return view();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }

 

}
