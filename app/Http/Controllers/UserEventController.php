<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;
use App\Models\Evento;
use App\Models\Place_event;
use App\Models\Places;
use App\Models\Criterio;
use App\Models\Event_Criterio;
use App\Models\Stand;
use Illuminate\Support\Facades\Auth;

class UserEventController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $service;
    private $user;
    private $places;
   
    public function __construct(AuthService $service)
    {
        
        $this->service=$service;
        
    }
    private function userInauthenticated()
    {
        $this->user = $this->service->getUserAuthenticated();
        if (!$this->user || ($this->user->rol->nombre != 'Evento' && $this->user->rol->nombre != 'Visitante')) {
            return view('auth/login', ['message' => 'No se ha logueado o no tiene los permisos']);
        }
    }
    public function index()
    {
        $this->userInauthenticated();
        $eventos = User::where('rol_id', 4)->get();
        return view('UserEvent.generarevento',compact('eventos'));
    }
    public function create()
    {
        $this->userInauthenticated();
        $Events = event::all();
        return view('UserEvent.generarevento',compact('Events'));
    }
    public function listaEventos()
    {
        
        $this->userInauthenticated();
        $user = $this->user->id;
        //$user = Auth::user();
        $eventos = event::where('user_id',  $this->user->id)->get();
        // $eventos = Event::all();
        // $permisoCrearMultiplesEventos = $user->multi_eventos==1;
        // dd($permisoCrearMultiplesEventos);
        return view('UserEvent/listaeventos', compact('eventos'));
    }
    public function store(Request $request)
    {
          try{
        $this->userInauthenticated();
        $user = $this->user;
        $crear_eventos = $this->user->multi_evento;
    
        if (!$crear_eventos) {
            if ($user->eventos()->count() == 1) {
                return redirect()->back()->with('error', 'Ya tienes un evento creado. No puedes crear más eventos.');
            } else {
                $data = $request->validate([
                    'name' => 'required|string',
                    'logo' => 'required|image|max:2048',
                    'banner' => 'required|image|max:2048',
                    'description' => 'required|string',
                    'facebook' => 'required|string',
                    'instagram' => 'required|string',
                    'tiktok' => 'required|string',
                    'web' => 'required|string',
                    'fechainicio' => 'required|string',
                    'fechaFin' => 'required|string',
                    'color_contenedor_1' => 'required|string',
                    'color_contenedor_2' => 'required|string',
                    'color_contenedor_3' => 'required|string',
                    'color_contenedor_4' => 'required|string',
                    'numero_imagenes' => 'required|integer|min:1|max:10',
                ]);
    
                // Guardar el logo
                $nombreLogo = time() . '-' . $data['name'] . '-logo.' . $request->file('logo')->getClientOriginalExtension();
                $request->file('logo')->move(public_path('images'), $nombreLogo);
    
                // Guardar el banner
                $nombreBanner = time() . '-' . $data['name'] . '-banner.' . $request->file('banner')->getClientOriginalExtension();
                $request->file('banner')->move(public_path('images'), $nombreBanner);
    
                $evento = new Event();
                $evento->name = $data['name'];
                $evento->logo = 'images/' . $nombreLogo;
                $evento->banner = 'images/' . $nombreBanner;
                $evento->description = $data['description'];
                $evento->facebook = $data['facebook'];
                $evento->instagram = $data['instagram'];
                $evento->tiktok = $data['tiktok'];
                $evento->web = $data['web'];
                $evento->start_date = $data['fechainicio'];
                $evento->end_date = $data['fechaFin'];
                $evento->color_contenedor_1 = $data['color_contenedor_1'];
                $evento->color_contenedor_2 = $data['color_contenedor_2'];
                $evento->color_contenedor_3 = $data['color_contenedor_3'];
                $evento->color_contenedor_4 = $data['color_contenedor_4'];
                $evento->numero_imagenes = $data['numero_imagenes'];
    
                // Guardar las imágenes adicionales una por una
                for ($i = 1; $i <= 8; $i++) {
                    $imagesField = 'images' . $i;
                    if ($request->hasFile($imagesField)) {
                        $imagen = $request->file($imagesField);
                        $rutaImagen = 'images/' . $imagen->getClientOriginalName();
                        $imagen->move(public_path('images'), $rutaImagen);
                        $evento->$imagesField = $rutaImagen;
                    }
                }
    
                $evento->user_id = $this->user->id;
                $evento->save();
                
            }
        } else {
            $data = $request->validate([
                'name' => 'required|string',
                'logo' => 'image|max:2048',
                'banner' => 'image|max:2048',
                'description' => 'required|string',
                 'facebook' => 'required|string',
                 'instagram' => 'required|string',
                'tiktok' => 'required|string',
                 'web' => 'required|string',
                'fechainicio' => 'required|string',
                'fechaFin' => 'required|string',
                'color_contenedor_1' => 'required|string',
                'color_contenedor_2' => 'required|string',
                'color_contenedor_3' => 'required|string',
                'color_contenedor_4' => 'required|string',
                'numero_imagenes' => 'required|integer|min:1|max:10',
            ]);
    
            $evento = new Event();
            $evento->name = $data['name'];
    
            // Guardar el logo si se proporciona
            if ($request->hasFile('logo')) {
                $nombreLogo = time() . '-' . $data['name'] . '-logo.' . $request->file('logo')->getClientOriginalExtension();
                $request->file('logo')->move(public_path('images'), $nombreLogo);
                $evento->logo = 'images/' . $nombreLogo;
            }
    
            // Guardar el banner si se proporciona
            if ($request->hasFile('banner')) {
                $nombreBanner = time() . '-' . $data['name'] . '-banner.' . $request->file('banner')->getClientOriginalExtension();
                $request->file('banner')->move(public_path('images'), $nombreBanner);
                $evento->banner = 'images/' . $nombreBanner;
            }
            $evento->description = $data['description'];
            $evento->facebook = $data['facebook'];
            $evento->instagram = $data['instagram'];
            $evento->tiktok = $data['tiktok'];
            $evento->web = $data['web'];
            $evento->start_date = $data['fechainicio'];
            $evento->end_date = $data['fechaFin'];
            $evento->color_contenedor_1 = $data['color_contenedor_1'];
            $evento->color_contenedor_2 = $data['color_contenedor_2'];
            $evento->color_contenedor_3 = $data['color_contenedor_3'];
            $evento->color_contenedor_4 = $data['color_contenedor_4'];
            $evento->numero_imagenes = $data['numero_imagenes'];
    
            // Guardar las imágenes adicionales una por una
            for ($i = 1; $i <= 8; $i++) {
                $imagesField = 'images' . $i;
                if ($request->hasFile($imagesField)) {
                    $imagen = $request->file($imagesField);
                    $rutaImagen = 'images/' . $imagen->getClientOriginalName();
                    $imagen->move(public_path('images'), $rutaImagen);
                    $evento->$imagesField = $rutaImagen;
                }
            }
            $evento->user_id = $this->user->id;
            $evento->save();
            
        }
        
        
        return redirect()->route('UserEvent.eventosdetalles', ['id' => $evento->id])
        ->with('success', 'Evento creado con éxito!');
    
    }
    catch (\Exception $e) {
        // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
        session()->flash('error', 'Error: No se puede craer el evento.');
        return redirect()->route('UserEvent.create') ;
    }
    }

    public function edit($id)
    {
        $this->userInauthenticated();
        $evento=Event:: findOrFail($id);
        return view('UserEvent/editarevento', compact('evento'));
    }
    public function update(Request $request, $id)
    {
        try{
        $this->userInauthenticated();
        
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'facebook' => 'required|string',
                 'instagram' => 'required|string',
                'tiktok' => 'required|string',
                 'web' => 'required|string',
            'fechainicio' => 'required|string',
            'fechaFin'=> 'required|string',
            'color_contenedor_1' => 'required|string',
            'color_contenedor_2' => 'required|string',
            'color_contenedor_3' => 'required|string',
            'color_contenedor_4' => 'required|string',
            'numero_imagenes' => 'required|integer|min:1|max:10',
        ]);
    
        $evento = Event::find($id);
    
        // Actualizar el logo si se proporciona uno nuevo
        if ($request->hasFile('new_logo')) {
            // Eliminar el logo existente si hay uno
            if ($evento->logo) {
                $oldLogoPath = public_path('images/' . $evento->logo);
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }
    
            // Guardar el nuevo logo
            $newLogoName = time() . '-' . $data['name'] . '-logo.' . $request->file('new_logo')->getClientOriginalExtension();
            $request->file('new_logo')->move(public_path('images'), $newLogoName);
            $evento->logo = 'images/' . $newLogoName;
        }
    
        // Actualizar el banner si se proporciona uno nuevo
        if ($request->hasFile('new_banner')) {
            // Eliminar el banner existente si hay uno
            if ($evento->banner) {
                $oldBannerPath = public_path('images/' . $evento->banner);
                if (file_exists($oldBannerPath)) {
                    unlink($oldBannerPath);
                }
            }
    
            // Guardar el nuevo banner
            $newBannerName = time() . '-' . $data['name'] . '-banner.' . $request->file('new_banner')->getClientOriginalExtension();
            $request->file('new_banner')->move(public_path('images'), $newBannerName);
            $evento->banner = 'images/' . $newBannerName;
        }
    
        // Actualizar las imágenes adicionales del evento
        for ($i = 1; $i <= 8; $i++) {
            $fieldName = 'images' . $i;
            $newImageField = 'new_images' . $i;
    
            // Verificar si se cargó una nueva imagen
            if ($request->hasFile($newImageField)) {
                // Eliminar la imagen existente si hay una
                if ($evento->$fieldName) {
                    $oldImagePath = public_path('images/' . $evento->$fieldName);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
    
                // Guardar la nueva imagen
                $newImageName = time() . '-' . $data['name'] . '-image' . $i . '.' . $request->file($newImageField)->getClientOriginalExtension();
                $request->file($newImageField)->move(public_path('images'), $newImageName);
                $evento->$fieldName = 'images/' . $newImageName;
            }
        }
    
        // Actualizar los demás datos del evento
        $evento->name = $data['name'];
        $evento->description = $data['description'];
        $evento->facebook = $data['facebook'];
        $evento->instagram = $data['instagram'];
        $evento->tiktok = $data['tiktok'];
        $evento->web = $data['web'];
        $evento->start_date = $data['fechainicio'];
        $evento->end_date = $data['fechaFin'];
        $evento->color_contenedor_1 = $data['color_contenedor_1'];
        $evento->color_contenedor_2 = $data['color_contenedor_2'];
        $evento->color_contenedor_3 = $data['color_contenedor_3'];
        $evento->color_contenedor_4 = $data['color_contenedor_4'];
        $evento->numero_imagenes = $data['numero_imagenes'];
        $evento->user_id = $this->user->id; // Asignar el ID del usuario autenticado
        $evento->save();
    
        return redirect()->route('UserEvent.listaeventos')->with('success', 'Evento modificado con éxito!');
    }
    catch (\Exception $e) {
        // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
        session()->flash('error', 'Error: No se puede editar el evento.');
        return redirect()->route('UserEvent.edit',['id' => $id]) ;
    }
    }

    public function destroy($id)
    {
        $this->userInauthenticated();
        $evento=Event:: find($id);
        if ($evento) {
            $evento->delete();
            return redirect()->route('UserEvent.listaeventos')->with('success', 'Lugar eliminado exitosamente');
        } else {
            return redirect()->route('UserEvent.listaeventos')->with('error', 'No se encontró el lugar para eliminar');
        }
    }
    public function show(Event $event)
    {
        $this->userInauthenticated();
        $Event = event::where('user_id',  $this->user->id)->get();
        // $eventos = Event::all();
        return view('UserEvent/listaeventos', ['eventos' => $Event]);
    
    }

    //metodo para los detalles del evento 
    public function eventosdetalles($id)
    {
        // Aquí obtienes el evento con el ID proporcionado
        $evento = Event::findOrFail($id);
        $lugares = Place_event::where('event_id', $id)->get();
        $places = Places::all();  
        $criterios = Criterio::all(); 
        $eventosc = Event_Criterio::where('evento_id', $id)->with('criterio')->get();
        // Puedes cargar la vista de detalles del evento y pasar el evento como datos
        return view('UserEvent/detallesevento', compact('evento','lugares','places','criterios','eventosc'));
    }
    //para agregar un lugar 
    public function agregar_lugarevento(Request $request)
    { try{
        $request->validate([
            'place_id' => 'required|integer',
            'event_id' => 'required|integer',
        ]);
    
        // Verificar si el lugar ya está asociado al evento
        $existingPlaceEvent = Place_event::where('place_id', $request['place_id'])
            ->where('event_id', $request['event_id'])
            ->exists();
    
        // Si la relación ya existe, mostrar un mensaje de error y redirigir de vuelta
        if ($existingPlaceEvent) {
            return redirect()->back()->with('error', 'El lugar ya está asociado a este evento.');
        }
    
        // Si la relación no existe, crear la relación y redirigir a la vista de detalles del evento
        $place_event = new Place_event();
        $place_event->place_id = $request['place_id'];
        $place_event->event_id = $request['event_id'];
        $place_event->save();
    
        return redirect()->route('UserEvent.eventosdetalles', ['id' => $request->input('event_id')]);
    }
    catch (\Exception $e) {
        // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
        session()->flash('error', 'Error: No se puede editar el evento.');
        return redirect()->back()->with('error', 'El lugar ya está asociado a este evento.');
    }
    }
    
    public function eliminarlugar_event($id)
    {
        $relacion = Place_event::findOrFail($id);
        $relacion->delete();

        // Redirige de vuelta a la página de detalles del evento u a donde quieras redirigir después de eliminar la relación
        return redirect()->route('UserEvent.eventosdetalles', ['id' => $relacion->event_id])->with('success', 'La relación ha sido eliminada correctamente.');

    }
    function agregar_criterioevento(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|integer',
            'criterio_id' => 'required|integer'
        ]);
    
        // Verificar si el evento ya tiene asociado el criterio
        $existingEventCriterio = Event_Criterio::where('evento_id', $request['evento_id'])
            ->where('criterio_id', $request['criterio_id'])
            ->exists();
    
        // Si la relación ya existe, mostrar un mensaje de error y redirigir de vuelta
        if ($existingEventCriterio) {
            return redirect()->back()->with('error', 'El evento ya tiene asociado este criterio.');
        }
    
        // Si la relación no existe, crear la relación y redirigir a la vista de detalles del evento
        $event_criterio = new Event_Criterio();
        $event_criterio->evento_id = $request['evento_id'];
        $event_criterio->criterio_id = $request['criterio_id'];
        $event_criterio->save();
    
        return redirect()->route('UserEvent.eventosdetalles', ['id' => $request->input('evento_id')]);
            
    }
    public function eliminarevent_criterio($id)
    {   
    
        $relacion = Event_Criterio::findOrFail($id);
        $relacion->delete();

        // Redirige de vuelta a la página de detalles del evento u a donde quieras redirigir después de eliminar la relación
        return redirect()->route('UserEvent.eventosdetalles', ['id' => $relacion->evento_id])->with('success', 'La relación ha sido eliminada correctamente.');

    }
    public function crearCriterio(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // Crear un nuevo criterio
        $criterio = Criterio::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        
       // Crear una entrada en la tabla intermedia
        $event_criterio = Event_Criterio::create([
        'criterio_id' => $criterio->id,
        'evento_id' => $request->evento_id,
        ]);
       
        // Redirigir de vuelta a la página de detalles del evento
        return redirect()->route('UserEvent.eventosdetalles', ['id' => $request->evento_id])->with('success', 'Criterio creado y asociado correctamente.');
    }
    public function standsevento($id)
    {
        $evento = Event::findOrFail($id);
        // Obtener los stands relacionados con el evento dado
        $stands = Stand::where('evento_id',$id)->get();

        // Pasar los datos a la vista
        return view('stands/stands_evento', compact('evento','stands'));
    }
    public function eventosusuario($id)
    {
        $eventos = Event::where('user_id', $id)->get();
        return view('eventos/eventos_usuario', compact('eventos'));
    }
    
    
}
