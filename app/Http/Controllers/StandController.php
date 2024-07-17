<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Stand;
use App\Models\User;
use App\Models\Classification;
use App\Models\Stand_has_classification;
use App\Models\Evaluation;
use App\Models\Event;
use App\Models\Evento;
use App\Models\Place_event;
use App\Http\Controllers\QRController;
use App\Http\Controllers\Auth;
use App\Models\Passport;


class StandController extends Controller
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
        if (!$this->user || !in_array($this->user->rol->nombre,['Empresa', 'Visitante'])) {
            return view('auth/login', ['message' => 'No se ha logueado o no tiene los permisos']);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inicio()
    {
         $this->userInauthenticated();
        $stands = Stand::where('user_id', $this->user->id)->get();
        
        return view('stands/empresa_stands', compact('stands'));
    }
    public function index()
{
    $this->userInauthenticated();
    $stands = Stand::where('user_id', $this->user->id)->with('places')->get();
    return view('stands/index', compact('stands'));
}


    public function indexVisitante(){
        $this->userInauthenticated();
        $stands =Stand::all();
        return view('stands/index', compact('stands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->userInauthenticated();
        $event= Event::all();
        $classifications = Classification::all();
        return view('stands/create', compact('classifications','event'));
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
            $this->userInauthenticated();
    
            $nombreImagen = null;
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $nombreImagen = $request->name . '-logo.' . $logo->extension();
                $logo->move(public_path('images'), $nombreImagen);
            }
            
            // Guardar el banner si se proporciona
            $nombreBanner = null;
            if ($request->hasFile('banner')) {
                $banner = $request->file('banner');
                $nombreBanner = $request->name . '-banner.' . $banner->extension();
                $banner->move(public_path('images'), $nombreBanner);
            }
    
            // Obtener otros datos del formulario
            $colorContenedor1 = $request->input('color_contenedor_1');
            $colorContenedor2 = $request->input('color_contenedor_2');
            $colorContenedor3 = $request->input('color_contenedor_3');
            $colorContenedor4 = $request->input('color_contenedor_4');
            $evento_id = $request->input('evento_id');
    
            $additionalImages = [];
            for ($i = 1; $i <= 10; $i++) {
                $fieldName = "images{$i}";
                if ($request->hasFile($fieldName)) {
                    $image = $request->file($fieldName);
                    $nombreImagenAdicional = time() . "-image{$i}." . $image->extension();
                    $image->move(public_path('images'), $nombreImagenAdicional);
                    $additionalImages[$fieldName] = "images/{$nombreImagenAdicional}";
                }
            }
    
            // Crear el código QR basado en el nombre del stand
            $hashQrCode = Hash::make($request->name);
            $base64QrCode = base64_encode($hashQrCode);
    
            // Crear el stand en la base de datos
            $stand = Stand::create([
                'name' => $request->name,
                'logo' => "images/{$nombreImagen}",
                'banner' => "images/{$nombreBanner}",
                'description' => $request->description,
                'facebook' => $request->facebook?? null,
                'instagram' => $request->instagram ?? null,
                'tiktok' => $request->tiktok ?? null,
                'web' => $request->web ?? null,
                'calification' => 0.0,
                'qr_code' => $base64QrCode,
                'user_id' => $this->user->id,
                'color_contenedor_1' => $colorContenedor1,
                'color_contenedor_2' => $colorContenedor2,
                'images1' => $additionalImages['images1'] ?? null,
                'images2' => $additionalImages['images2'] ?? null,
                'images3' => $additionalImages['images3'] ?? null,
                'images4' => $additionalImages['images4'] ?? null,
                'images5' => $additionalImages['images5'] ?? null,
                'images6' => $additionalImages['images6'] ?? null,
                'images7' => $additionalImages['images7'] ?? null,
                'images8' => $additionalImages['images8'] ?? null,
                'images9' => $additionalImages['images9'] ?? null,
                'images10' => $additionalImages['images10'] ?? null,
                'color_contenedor_3' => $colorContenedor3,
                'color_contenedor_4' => $colorContenedor4,
                'evento_id' => $evento_id,
                'places_id' => $request->input('place_id'),
            ]);
    
            if ($request->has('classification_id')) {
                $stand->classifications()->attach($request->classification_id);
            }
    
            // Redirigir al usuario a la vista de índice de stands con un mensaje de éxito
            return redirect()->route('stand.index')->with('success', 'Stand creado con éxito.');
        } catch (\Exception $e) {
            // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
            session()->flash('error', 'Error: No se  puede crear el stand.');
            return redirect()->route('stand.create');
        }
        }
    
        public function getPlaces(Event $event)
        {   
            $evento = Event::find($event->id);
            $numeroImagenes = $evento->numero_imagenes;

            // Usando Eloquent ORM para obtener la relación entre eventos y lugares a través de la tabla intermedia PlaceEvent
            $placesEvent = Place_event::where('event_id', $event->id)->with('place')->get();
            
            // Obtener solo los lugares de los eventos
            $places = $placesEvent->pluck('place');
          
        
            // Devolver los lugares en formato JSON
            // return response()->json($places);

            return response()->json([
                'places' => $places,
                'numero_imagenes' => $numeroImagenes,
            ]);
          
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    // Obtener el stand con el ID proporcionado
    $stand = Stand::find($id);

    // Verificar si se encontró el stand
    if (!$stand) {
        // Si no se encontró el stand, redirigir con un mensaje de error
        return redirect()->back()->with('error', 'Stand no encontrado.');
    }

    // Obtener el usuario autenticado a través del servicio AuthService
    $user = $this->service->getUserAuthenticated();

    // Verificar si el usuario está autenticado y es un visitante
    if ($user && $user->rol->id == 2) {
        try {
            // Verificar si ya existe un registro en Passport para este usuario y stand
            $existingPassport = Passport::where('user_id', $user->id)->where('stand_id', $id)->first();

            // Si no existe un registro en Passport para este usuario y stand, crear uno nuevo
            if (!$existingPassport) {
                Passport::create([
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                    'user_id' => $user->id,
                    'stand_id' => $id
                ]);
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción y redirigir con un mensaje de error
            return redirect()->back()->with('error', 'Error al guardar el registro de visita: ' . $e->getMessage());
        }
    }

    // Retornar la vista de detalles del stand
    return view('stands.details', compact('stand'));

        // $stand = Stand::find($id);

        // // Verificar si el stand existe
        // if (!$stand) {
        //     return redirect()->back()->with('error', 'Stand no encontrado');
        // }
    
        // // Obtener el usuario autenticado
        // $user = $this->service->getUserAuthenticated();
    
        // // Verificar el rol del usuario
        // if ($user->rol->nombre == 'Visitante') {
        //     // Si el usuario es visitante, ejecutar la lógica adicional
        //     try {
                
        //         $response = app()->call('App\Http\Controllers\QRController@guardarEscaneo', ['id' => $id]);
    
        //         // Verificar si la respuesta es exitosa
        //         if ($response->getStatusCode() != 200) {
        //             return view('error', "no encontrado" );
        //         }
                
    
        //         // Retornar la vista con los datos del stand
        //         return view('stands.details', compact('stand'));
    
        //     } catch (\Exception $e) {
        //         // Manejar la excepción
        //         return view('error')->with('error', 'Error al guardar el escaneo');
        //     }
        // } else {
        //     // Si el usuario tiene otro rol, simplemente retornar la vista con los datos del stand
        //     return view('stands.details', compact('stand'));
        // }


       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->userInauthenticated();
        $stand = Stand::find($id);
        $classifications = Classification::all();
    $existentClassifications = $stand->classifications->pluck('id')->toArray();
        $existentImages = [];
    

        return view('stands/edit', compact('stand', 'classifications', 'existentClassifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $this->userInauthenticated();
    //     Stand::find($id)->update([
            
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'facebook' => $request->facebook,
    //         'instagram' => $request->instagram,
    //         'tiktok' => $request->tiktok,
    //         'web' => $request->web ,
            
    //     ]);
    //     return $this->index();
    // }



    public function update(Request $request, $id)
    {
        
    $this->userInauthenticated();
    try {
    // Encuentra el stand para actualizar
    $stand = Stand::find($id);
    
    // Verifica si se cargó un nuevo logo
    if ($request->hasFile('new_logo')) {
        // Elimina el logo existente si hay uno
        if ($stand->logo) {
            // Elimina el logo existente del directorio public/images
            $oldLogoPath = public_path('images/' . $stand->logo);
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }
        }
    
        // Guarda el nuevo logo en la carpeta public/images
        $newLogoName = $request->file('new_logo')->getClientOriginalName();
        $request->file('new_logo')->move(public_path('images'), $newLogoName);
    
        // Actualiza la ruta del logo en la base de datos
        $stand->logo = 'images/' . $newLogoName;
    }

    // Verifica si se cargó un nuevo banner
    if ($request->hasFile('new_banner')) {
        // Elimina el banner existente si hay uno
        if ($stand->banner) {
            // Elimina el banner existente del directorio public/images
            $oldBannerPath = public_path('images/' . $stand->banner);
            if (file_exists($oldBannerPath)) {
                unlink($oldBannerPath);
            }
        }
    
        // Guarda el nuevo banner en la carpeta public/images
        $newBannerName = $request->file('new_banner')->getClientOriginalName();
        $request->file('new_banner')->move(public_path('images'), $newBannerName);
    
        // Actualiza la ruta del banner en la base de datos
        $stand->banner = 'images/' . $newBannerName;
    }
    
    // Actualiza las 10 imágenes
    for ($i = 1; $i <= 10; $i++) {
        $fieldName = 'images' . $i;
        $newImageField = 'new_images' . $i;

        // Verifica si se cargó una nueva imagen para imagesN
        if ($request->hasFile($newImageField)) {
            // Elimina la imagen existente si hay una
            if ($stand->$fieldName) {
                // Elimina la imagen existente del directorio public/images
                $oldImagePath = public_path('images/' . $stand->$fieldName);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        
            // Guarda la nueva imagen en la carpeta public/images
            $newImageName = $request->file($newImageField)->getClientOriginalName();
            $request->file($newImageField)->move(public_path('images'), $newImageName);
        
            // Actualiza la ruta de imagesN en el base de datos
            $stand->$fieldName = 'images/' . $newImageName;
        }
    }
    $stand->color_contenedor_1 = $request->color_contenedor_1;
    $stand->color_contenedor_2 = $request->color_contenedor_2;
    $stand->color_contenedor_3 = $request->color_contenedor_3;
    $stand->color_contenedor_4 = $request->color_contenedor_4;


    // Actualiza otros campos del stand
    $stand->name = $request->name;
    $stand->description = $request->description;
    $stand->facebook = $request->facebook;
    $stand->instagram = $request->instagram;
    $stand->tiktok = $request->tiktok;
    $stand->web = $request->web;
    
    $stand->classifications()->sync($request->input('classification_id'));
    // Guarda los cambios en la base de datos
    $stand->save();
 

    // return $this->index();   
    return redirect()->route('stand.index')->with('success', 'Stand Editado con exito');
    }catch (\Exception $e) {
        // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
        session()->flash('error', 'Error: No se  puede editar el stand.');
        return redirect()->route('stand.edit', $stand->id) ;
    }
    }
    public function updateLogo(Request $request, $id)
    {
        $this->userInauthenticated();
        $stand = Stand::find($id);
        Storage::delete("public/{$stand->logo}");
        $logo = $request->file('logo');
        $nombreLogo = time() . '.' . $logo->extension();
        $logo->storeAs('public', $nombreLogo);
        $stand->update([
            'logo' => 'storage/images/{$nombreLogo}'
        ]);
        return $this->index();
    }

    public function updateBanner(Request $request, $id)
    {
        $this->userInauthenticated();
        $stand = Stand::find($id);
        Storage::delete("public/{$stand->banner}");
        $banner = $request->file('banner');
        $nombreBanner = time() . '.' . $banner->extension();
        $banner->storeAs('public', $nombreBanner);
        $stand->update([
            'banner' => 'storage/images/{$nombreBanner}'
        ]);
        return $this->index();
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stands_class = Stand_has_classification::where('stand_id', $id)->get();
        foreach ($stands_class as $val) {
            $val->delete();
        }
        $stand = Stand::find($id);
        $stand->delete();
        Storage::delete("public/{$stand->logo}");
        Storage::delete("public/{$stand->banner}");
        return $this->index();
    }

    public function getAllStands()
    {
        $stands = Stand::all();
        // DEBE RETORNAR LA VISTA DE LOS STANDS
        return view('stands/home', compact('stands'));
    }

    public function standsVisitados()
    {
        $this->userInauthenticated();
        $stands = array();
        $evals = Evaluation::where('user_id', $this->user->id)->get();
        foreach ($evals as $eval) {
            array_push($stands, $eval->stand);
        }
        return $stands;
        return view('stands/index', compact('stands'));
    }
    public function errorEmpresa(){

        return view('users/errorempresa');
    }


}