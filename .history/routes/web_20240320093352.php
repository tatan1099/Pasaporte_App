
<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CalificacionController;
use App\Models\User;
use App\Models\criterio;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\InvitadosController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MetricasController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('index');
});*/

Route::get('/',[App\Http\Controllers\indexController::class, 'index'])->name('index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/log', [App\Http\Controllers\Auth\LoginController::class, 'authenticated'])->name('login.authenticated');


//Route::get('/stands/home', [App\Http\Controllers\StandController::class, 'getAllStands'])->name('stands.home');


// RUTAS PROTEGIDAS PARA EL VISITANTE
Route::middleware(['auth', 'role:Visitante'])->group(function () {
   
    // Muestra la evaluacion 
    Route::get('/evaluation/index/{qr_code}', [EvaluationController::class, 
    'index'])->name('evaluation.index');

    // Guarda el resultado de la evaluacion
    Route::post('/evaluation/store/{qr_code}', [EvaluationController::class, 
    'store'])->name('evaluation.store');

    // Route::get('/calificacion', [CalificacionController::class, 'mostrarFormulario'])->name('calificacion');
    Route::get('/calificacion/{evento_id}/{stand_id}', [CalificacionController::class, 'mostrarFormulario'])->name('calificacion');
    Route::post('/guardar-calificacion', [CalificacionController::class, 'guardarCalificacion'])->name('guardar_calificacion');

    // Stands visitados
    //Route::get('/stands-visitados', [StandController::class, 'standsVisitados'])->name('stand.visitados');
    Route::resource('passport',PassportController::class);
    //Route::resource('user',UserController::class);  
    //-----------------------------------------------
    Route::get('stands', [StandController::class, 'indexVisitante'])->name('stand.visitantes');
    //-----------------------------------------------

    // Stand individual
    Route::get('/stands/{idStand}', [StandController::class, 'show'])->name('stands.show');

    //Escaneo de qr
     Route::get('/qr-scanner', [QRController::class, 'showScanner'])->name('qr-scanner');
    
    // Route::get('/eventos/listaeventos', [EventController::class, 'listaEventos'])->name('eventos.listaEventos');
    Route::get('/eventos/listaeventos', [EventController::class, 'listaEventos'])->name('eventos.listaEventos');
    // Route::resource('eventos',EventController::class );
    Route::get('/eventoes/{id}', [EventController::class, 'show'])->name('Event.Detallesevento');
    Route::post('/qr-scanner/scan', [QRController::class, 'escanearCodigoQR'])->name('qr-scanner.scan');
    Route::post('/guardar-escaneo', [QRController::class, 'guardarEscaneo'])->name('guardar.escaneo');

// Route::get('/qr-scanner/scan', [QRController::class, 'escanearCodigoQR'])->name('qr-scanner.scan');
   
    
});



// RUTAS PROTEGIDAS PARA EL ADMIN
Route::middleware(['auth', 'role:Administrador',])->group(function () {

    // Route::resource('empresa', EmpresaControler::class);
    Route::resource('places',PlacesController::class);
    Route::resource('schedule',ScheduleController::class);
    //Route::resource('eventos',EventController::class); 
    Route::get('/eventos/create', [EventController::class, 'create'])->name('eventos.create');
    Route::get('/eventos/index', [EventController::class, 'index'])->name('eventos.index');
    Route::post('/eventos/store', [EventController::class, 'store'])->name('eventos.store');
    Route::post('/logo/store', [LogoController::class, 'store'])->name('logo.store');
    Route::get('/logo/create', [LogoController::class, 'create'])->name('logo.create');
    //para listar los usuarios
    Route::get('/usuarios/listarusuarios', [UserController::class, 'listarusuarios'])->name('user.listarusuarios');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/{id}/eventos', [UserEventController::class, 'eventosusuario'])->name('UserEvent.eventosusuario');
    Route::get('/UserEvent/{id}/details', [UserEventController::class, 'eventosdetalles'])->name('UserEvent.eventosdetalle');
    Route::get('/eventos/{id}/standse',[UserEventController::class, 'standsevento'])->name('UserEvent.standsevent');
    Route::get('metricas/stand/{id}/visit', [MetricasController::class, 'usuariosVisitantes'])->name('metricas.stand_visitant');
    Route::get('metricas/evento/{id}/asis', [MetricasController::class, 'eventosmetricas'])->name('metricas.metricas_even');
    Route::get('/usuarios/empresasnoregistradas', [UserController::class, 'empresasnoActivdas'])->name('user.empresasnoactivadas'); 
    Route::post('/users/empresasnoactivadas',[UserController::class, 'activarEmpresa'] )->name('users.activarEmpresa');
    Route::get('metricas/evento/{eventId}/grafica', [MetricasController::class, 'graficapersonasgeneroxstand_evento'])->name('metrica.graficapersonasgeneroxstand_evento');
    Route::get('metricas/stands/{idStand}/graficas', [MetricasController::class, 'graficastands'])->name('metricas.stands.graficas');
    Route::post('/exportar-a-excel/{eventId}', [MetricasController::class, 'exportToExcel'])->name('exportar.excel');
    Route::post('/exportar-a-excel/{idStand}/stand', [MetricasController::class, 'exportToExcel_satnds'])->name('exportar.excel.stand');
    });
    

    
  // RUTAS PROTEGIDAS PARA EL evento
    Route::middleware(['auth', 'role:Evento',])->group(function () {

    Route::get('/empresas/index', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('/eventos/{id}/stands',[UserEventController::class, 'standsevento'])->name('UserEvent.standsevento');
    Route::get('metricas/stand/{id}/visitantes', [MetricasController::class, 'usuariosVisitantes'])->name('metricas.stand_visitantes');
    // Route::get('/empresas/{id}/edit', [UserController::class, 'edit'])->name('empresas.edit');
    Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresa.create');
    Route::post('/empresas/store', [LogoController::class, 'store'])->name('empresa.store');
    Route::resource('schedule',ScheduleController::class);
    Route::resource('agenda',AgendaController::class);
    
    /// el post es para el metodo me permita crear ya que estaba como un metodo get
    Route::post('/eventos/generarevento/create', [EventController::class, 'generarevento'])->name('eventos.generareventoPost');
    // Route::get('/eventos/generarevento', [EventController::class, 'generar'])->name('evento.generarevento');
    Route::get('/eventos/generar', [EventController::class, 'generar'])->name('eventos.generar');
        // Route::view('/eventos/generar', 'eventos.generar')->name('eventos.generar');
    //Route::resource('eventos',EventController::class );

    //para los permisos en el controlador usercontroller
    Route::resource('UserEvent',UserEventController::class );
    Route::get('/UserEvent/listaeventos', [UserEventController::class, 'listaEventos'])->name('UserEvent.listaeventos');
    Route::get('/UserEvent/multieventos', [UserEventController::class, 'Multieventos'])->name('UserEvent.Multieventos');
    Route::get('/UserEvent/{id}/detalles', [UserEventController::class, 'eventosdetalles'])->name('UserEvent.eventosdetalles');
    Route::get('/UserEvent/detallesevento', [UserEventController::class, 'listarlugares'])->name('UserEvent.listarlugares');
    // Route::get('/UserEvent/{id}/edit', [UserEventController::class, 'edit'])->name('UserEvent.edit');
    // Route::post('/UserEvent/update', [UserEventController::class, 'update'])->name('UserEvent.update');
    Route::post('/UserEvent/agregarlugar', [UserEventController::class, 'agregar_lugarevento'])->name('UserEvent.agregar_lugarevento');
    Route::delete('/UserEvent/relacion/{id}', [UserEventController::class, 'eliminarlugar_event'])->name('UserEvent.eliminarlugar_event');
    Route::post('/UserEvent/agregarcriterio', [UserEventController::class, 'agregar_criterioevento'])->name('UserEvent.agregar_criterioevento');
    Route::delete('/UserEvent/criterio/{id}', [UserEventController::class, 'eliminarevent_criterio'])->name('UserEvent.eliminarevent_criterio');
    Route::post('/crear/criterio', [UserEventController::class, 'crearCriterio'])->name('UserEvent.crearCriterio');
    Route::get('metricas/evento/{id}/asistencia', [MetricasController::class, 'eventosmetricas'])->name('metricas.metricas_evento');
    Route::get('metricas/evento/{eventId}/graficas', [MetricasController::class, 'graficapersonasgeneroxstand_evento'])->name('metricas.graficapersonasgeneroxstand_evento');
    Route::get('metricas/evento/{eventId}/graficas', [MetricasController::class, 'graficapersonasgeneroxstand_evento'])->name('metricas.graficapersonasgeneroxstand_evento');
    Route::get('/evento/{eventId}/stand/{standId?}/usuarios', [MetricasController::class, 'usuariosPorStand'])->name('usuarios.por_stand');
    Route::get('/restablecer-filtros', [MetricasController::class,'restablecerFiltros_evento'])->name('metricas.restablecer-filtros');
   
    
    });  
    
// RUTAS PROTEGIDAS PARA LA EMPRESA
    Route::middleware(['auth', 'role:Empresa'])->group(function () {
    Route::resource('agenda',AgendaController::class);
    Route::get('/stand/{standId}/generar-qr', [QRController::class, 'generarCodigoQR'])->name('stand.qr');
    
    Route::get('/stand/details', [StandController::class, 'show'])->name('stanes.show');
    Route::get('/stand/empresa_stands', [StandController::class, 'inicio'])->name('stands.inicio');
    // Route::get('/stands/create', [StandController::class, 'create'])->name('stand.create');
    Route::resource('stand',StandController::class);
    
    Route::get('/evento/{event}', [StandController::class, 'getPlaces'])->name('stands.getPlaces');
    
    Route::get('/generar-codigo-qr', [QRController::class, 'generarCodigoQR'])->name('generar.qr');
    Route::Post('/imprimirqr', [QRController::class, 'generatePDF'])->name('imprimir.qr');
    Route::get('metricas/stand/{id}/usuarios-visitantes', [MetricasController::class, 'usuariosVisitantes'])->name('metricas.stand.usuarios-visitantes');
    Route::get('metricas/stand/{idStand}/grafica', [MetricasController::class, 'graficastands'])->name('metricas.stand.grafica');
    Route::get('errorempresa', [StandController::class, 'errorEmpresa'])->name('erroremrpesa');
    Route::get('/filtros/eliminar',[MetricasController::class,'limpiarFiltros_stand'])->name('limpiarfiltro');
   
    Route::put('/user/{id}/actualizar', [UserController::class, 'update'])->name('user.updates');
    Route::get('/user/editaruser/{id}', [UserController::class, 'edit'])->name('user.editse');
});

Route::resource('invitados',InvitadosController::class);




//CRUD de visitante
//Route::resource('user',UserController::class);
Route::get('registro', [App\Http\Controllers\UserController::class, 'create'])->name('registro');
Route::post('registro', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/check-email', 'App\Http\Controllers\Auth\RegisterController@checkEmail')->name('check.email');








Route::resource('places',PlacesController::class);

// RUTA PARA OBTENER LA CALIFICACION POR CRITERIO DEL STAND
// SE PUSO SIN MIDDLWARE PORQUE AUN NO SE HE DEFINIDO COMO SE VA A TRABAJAR
Route::get('/rank-criterio/stand/{idStand}', [EvaluationController::class, 
    'rankDelCriterioPorStand'])->name('rankCriterio.stand');

// IMPLEMENTACION AUTH GOOGLE

Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
})->name('login-google');
 
Route::get('/google-callback', function () {
    $user = Socialite::driver('google')->user();
    $userExiste = User::where('auth_id', $user->id)->where('auth_name', 'google')->first();

    if ($userExiste) {
        Auth::login($userExiste);
    } else {
        $user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'auth_id' => $user->id,
            'auth_name' => 'google',
            'rol_id' => 2
        ]);

        $user->assignRole('Visitante');
        Auth::login($user);
    }
    return redirect()->route('home');
});



// IMPLEMENTACION AUTH FACEBOOK

// Route::get('/login-facebook', function () {
//     return Socialite::driver('facebook')->redirect();
// })->name('login-facebook');
 
// Route::get('/facebook-callback', function () {
//     $user = Socialite::driver('facebook')->user();
//     $userExiste = User::where('auth_id', $user->id)->where('auth_name', 'facebook')->first();

//     if ($userExiste) {
//         Auth::login($userExiste);
//     } else {
//         $user = User::create([
//             'name' => $user->name,
//             'email' => $user->email,
//             'auth_id' => $user->id,
//             'auth_name' => 'facebook',
//             'rol_id' => 2
//         ]);

//         $user->assignRole('Visitante');
//         Auth::login($user);
//     }
//     return redirect()->route('home');
// });
