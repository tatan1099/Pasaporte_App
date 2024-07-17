<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Criterio;
use App\Models\Event_Criterio;
use App\Models\Stand; 
use App\Models\Evaluation;


class CalificacionController extends Controller
{

    public function mostrarFormulario($evento_id, $stand_id)
    {
        // Obtener los IDs de criterios asociados con el evento específico
        $criteriosIds = Event_Criterio::where('evento_id', $evento_id)->pluck('criterio_id');
        
        // Obtener los criterios asociados con esos IDs
        $criterios = Criterio::whereIn('id', $criteriosIds)->get();
        $stand = Stand::find($stand_id);
        
        return view('Calificacion.calificacion', ['criterios' => $criterios, 'stand' => $stand]);
    }
 

    //
    // public function mostrarFormulario()
    // {
    //     // Obtener todos los criterios
    //     $criterios = Criterio::all();
        
    //     // // Pasar los criterios a la vista
    //     return view('calificacion/calificacion', ['criterios' => $criterios]);

      
   
    // }
    
    public function guardarCalificacion(Request $request)
    {
        try {
            // Obtener el ID del stand
            $standId = $request->input('standid');
    
            // Obtener los datos de los criterios
            $criterios = $request->input('criterios');
    
            // Verificar si ya existe una calificación para el usuario en este stand
            $existingEvaluation = Evaluation::where('user_id', auth()->id())
                ->where('stand_id', $standId)
                ->exists();
    
            // Si ya existe una calificación para este stand, redirigir con mensaje de error
            if ($existingEvaluation) {
                return redirect()->route('calificacion', ['stand_id' => $standId])
                    ->with('error', 'Ya existe una calificación para este stand.');
            }
            // Guardar cada calificación en la base de datos
            foreach ($criterios as $criterioId => $data) {
                $rank = $data['rank']; // Obtener el valor del rank
    
                // Obtener el feedback del array
                $feedbackValue = $request->input('feedback.' . $criterioId . '.feedback');
    
                // Crear una nueva instancia de Evaluation
                $evaluation = new Evaluation();
                $evaluation->rank = $rank;
                $evaluation->feedback = $feedbackValue;
                $evaluation->criterio_id = $criterioId;
                $evaluation->stand_id = $standId;
                $evaluation->user_id = auth()->id();
                $evaluation->save();
            }
    
            // Redirigir a la página de detalles del evento con el ID del evento
            $stand = Stand::findOrFail($standId);
            $eventoId = $stand->evento_id;
    
            return redirect()->route('Event.Detallesevento', ['id' => $eventoId])
                ->with('success', 'Calificación realizada con éxito.');
        } catch (\Exception $e) {
            $stand = Stand::findOrFail($standId);
            $eventoId = $stand->evento_id;
    
            // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
            session()->flash('error', 'Error: No se puede crear la calificación.');
            return redirect()->route('calificacion', ['evento_id' => $eventoId, 'stand_id' => $standId])
                ->with('error', 'No se puede crear la calificación.');
        }

    //     try {

    //     // Obtener el ID del stand
    //     $standId = $request->input('standid');

    //     // Obtener los datos de los criterios
    //     $criterios = $request->input('criterios');

    //     // Guardar cada calificación en la base de datos
    //     foreach ($criterios as $criterioId => $data) {
    //         $rank = $data['rank']; // Obtener el valor del rank

    //         // Verificar si ya existe una calificación para estos criterios
    //         $existingEvaluation = Evaluation::where('user_id', auth()->id())
    //             ->where('stand_id', $standId)
    //             ->where('criterio_id', $criterioId)
    //             ->first();

    //         // Si ya existe una calificación para estos criterios, continuar con el siguiente criterio
    //         if ($existingEvaluation) {
    //             continue;

    //         }

    //         // Obtener el feedback del array
    //         $feedbackValue = $request->input('feedback.' . $criterioId . '.feedback');

    //         // Crear una nueva instancia de Evaluation
    //         $evaluation = new Evaluation();
    //         $evaluation->rank = $rank;
    //         $evaluation->feedback = $feedbackValue;
    //         $evaluation->criterio_id = $criterioId;
    //         $evaluation->stand_id = $standId;
    //         $evaluation->user_id = auth()->id();
    //         $evaluation->save();
    //     }
    //     if ($existingEvaluation) {
    //         return redirect()->route('calificacion', ['stand_id' => $standId])
    //             ->with('error', 'Ya existe una calificación para este stand.');
    //     }

    //     // Redirigir a la página de stands después de guardar las calificaciones
    //     $stand = Stand::findOrFail($standId);
    //     $eventoId = $stand->evento_id;

    //     // Redirigir a la página de detalles del evento con el ID del evento
    //     return redirect()->route('Event.Detallesevento', ['id' => $eventoId])->with('success', 'Calificacion realizada con éxito.');
    //    // return view('stands.index', compact('stands'));
    // }
    // catch (\Exception $e) {
    //     $stand = Stand::findOrFail($standId);
    //     $eventoId = $stand->evento_id;
    //     // En caso de error, redirigir de vuelta a la vista de creación de stands con un mensaje de error
    //     session()->flash('error', 'Error: No se  puede crear la callificacion.');
    //     return redirect()->route('calificacion',['evento_id' => $eventoId, 'stand_id' => $standId] )->with('error', 'No se puede crear la calificacion.');;
    // }


    }





}
