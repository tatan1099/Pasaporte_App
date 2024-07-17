<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Stand;
use App\Models\Criterio;
use App\Models\Passport;
use App\Models\Evaluation;
use App\Models\EvaluationHasCriterio;

class EvaluationController extends Controller
{

    private $service;
    private $user;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    private function userInauthenticated()
    {
        $this->user = $this->service->getUserAuthenticated();

        if ($this->user === null || $this->user->rol->name != 'Visitante') {
            return view('auth/login', ['message' => 'No se ha logueado o no tiene los permisos']);   
        }  
        return null;
    }

    // private function existeCodigo($qr_code) 
    // {
    //     $existeCodigo = Stand::where('qr_code', $qr_code)->exists();
    //     return $existeCodigo;
    // }

    // private function evalCompletada($stand)
    // {
    //     $evalCompletada = Evaluation::where('user_id', $this->user->id)
    //         ->where('stand_id', $stand->id)->exists();
    //     return $evalCompletada;
    // }



    // public function index($qr_code)
    // {   
    //     $userInauthenticated = $this->userInauthenticated();
    //     if ($userInauthenticated !== null) return $userInauthenticated;
        
    //     $stand = Stand::where('qr_code', $qr_code)->first();

    //     $evalCompletada = $this->evalCompletada($stand);
    //     if ($evalCompletada) {
    //         return view('home', ['message' => 'Evaluacion ya completada']);
    //     }

    //     $existeCodigo = $this->existeCodigo($qr_code);

    //     if (!$existeCodigo) {
    //         return redirect()->route('home')->with('error', 'Codigo QR Invalido');
    //     }
        
    //     $user = Auth::user();
    //     $criterios = Criterio::all();
    //     //$this->middleware('role:Visitante');
    //     $user = Auth::user();

    //     return view('evaluations/index', compact('criterios', 'qr_code','user'));
    // }

    // public function store(Request $request, $qr_code)     
    // {   
    //     try {
    //         //DB::beginTransaction();
            
    //         $userInauthenticated = $this->userInauthenticated();
    //         if ($userInauthenticated !== null) return null;

    //         $existeCodigo = $this->existeCodigo($qr_code);
    //         if (!$existeCodigo) {
    //             return redirect()->route('home')->with('error', 'Codigo QR Invalido');
    //         }
               
            
    //         $valorCriterios = $request->input('puntuacion');
    //         $rank =  array_sum($valorCriterios) / count($valorCriterios);
            
    //         $stand = Stand::where('qr_code', $qr_code)->lockForUpdate()->first();
    //         $evalCompletada = $this->evalCompletada($stand);
    //         if ($evalCompletada) {
    //             return view('home', ['message' => 'Evaluacion ya completada']);
    //         }
            
    //         $eval = Evaluation::create([
    //             'rank' => $rank,
    //             'feedback' => $request->get('feedback'),
    //             'criterio_id'=>1,//TODO: REVISAR RELACION CON CRITERIOS
    //             'stand_id' => $stand->id,
    //             'user_id' => $this->user->id
    //         ]);
    //         //TODO: Comprobado hasta aca

    //         $i = 0;
    //         foreach ($request->criterio_id as $id) {
    //             EvaluationHasCriterio::create([
    //                 'criterio_id' => $id,
    //                 'evaluation_id' => $eval->id,
    //                 'rankCriterio' => $valorCriterios[$i]
    //             ]);
    //         }
            
    //         $this->addRankToClalificationStand($rank, $stand);

    //         DB::commit();
    //         $this->createPassport($stand->id);

    //         // DEBE RETORNAR LA VISTA DE LOS STANDS SELLADOS
    //         return view('paginas-sello/index');

    //      } catch (\Throwable $th) {

    //         DB::rollback();
    //         return redirect()->back()->with('error', 'Error al procesar la evaluación');
    //     }
    // }

    // private function addRankToClalificationStand($rank, $stand)
    // {
    //     $calification = $stand->calification;
    //     if ($calification == 0) {
    //         $stand->update([
    //             'calification' => $rank
    //         ]);
    //     } else {
    //         $stand->update([
    //             'calification' => ($calification + $rank) / 2
    //         ]);
    //     }
    // }

    // public function rankDelCriterioPorStand($idStand){
    //     $numCriterios = count(Criterio::all());
    //     $ranksPorCriterio = array();

    //     for ($i=1; $i <= $numCriterios ; $i++) {
    //         $promedio = EvaluationHasCriterio::join('evaluations', 'evaluation_has_criterios.evaluation_id', '=', 'evaluations.id')
    //         ->where('evaluations.stand_id', $idStand)
    //         ->where('evaluation_has_criterios.criterio_id', $i)
    //         ->avg('evaluation_has_criterios.rankCriterio');
    //         array_push($ranksPorCriterio, $promedio);
    //     }
    //     // DEBE RETORNAR LA VISTA O EL REPORTE NECESARIO
    //     return $ranksPorCriterio;
    // }
    public function verificarVisita(Request $request)
    {
        // Obtén la URL escaneada por el usuario desde la solicitud
        $url = $request->input('stand_id');

        // Verifica si el usuario ya ha visitado esta URL
        $visit = Passport::where('user_id', auth()->id())
                     ->where('stand_id', $stand_id)
                     ->first();

        // Si el usuario ya ha visitado esta URL, redirige a una página diferente
        if ($visit) {
            return redirect()->route('qr.scanner');
        } else {
            // Si el usuario no ha visitado esta URL, redirige a la misma URL
            return redirect()->to('stand.show');
        }
    }

}
