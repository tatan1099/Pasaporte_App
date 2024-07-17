<?php
namespace App\Http\Controllers; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use App\Models\Stand;
use App\Models\Passport;
use App\Models\User;
use App\Models\Event;
use App\Models\Event_Criterio;
use App\Models\Evaluation;
use App\Models\Criterio;
use App\Models\Place_event;
use Carbon\Carbon;
use App\Models\Places;
use App\Http\Controllers\EventController;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
class MetricasController extends Controller
{
    public function usuariosVisitantes(Request $request, $idStand)
{
    // Encuentra el stand según su ID
    $stand = Stand::findOrFail($idStand);

    $idEvento = $stand->evento_id;

    // Obtén los pasaportes asociados con este stand
    $pasaportes = $stand->pasaportes;

    // Obtén las evaluaciones asociadas con este stand específico
    // $evaluaciones = Evaluation::with('criterio')->where('stand_id', $idStand)->get();

    // Inicializa un arreglo para almacenar los datos de los usuarios y las evaluaciones
    $datosUsuarios = [];

    // Obtén el filtro por edad del formulario
    $filtroEdad = $request->input('edad');

    // Obtén el filtro por género del formulario
    $filtroGenero = $request->input('genero');

    $filtroFecha=$request->input('fecha');

    // Filtrar usuarios por edad si se ha seleccionado una
    foreach ($pasaportes as $pasaporte) {
        $usuario = $pasaporte->user;
        if ($usuario) {

            $ageRange = $filtroEdad ? explode('-', $filtroEdad) : null;
            // Verifica el filtro por edad
            $edadValida = !$filtroEdad || ($usuario->age >= $ageRange[0] && $usuario->age <= $ageRange[1]);
            
            // Verifica el filtro por género
            $generoValido = !$filtroGenero || $usuario->genere == $filtroGenero;
            //verifica el filtro de fecha 
            $fechaValida = !$filtroFecha || $pasaporte->date == $filtroFecha;

            if ($edadValida && $generoValido && $fechaValida) {
                $datosUsuarios[] = [
                    'name' => $usuario->name,
                    'email' => $usuario->email,
                    'genere' => $usuario->genere,
                    'age' => $usuario->age,
                    'date' => $pasaporte->date,
                    'time' => $pasaporte->time,
                ];
            }
        }
    }
    
    //     $evaluaciones = Evaluation::selectRaw('stand_id, criterio_id, AVG(rank) as avg_rank, COUNT(*) as total_evaluaciones')
    // ->groupBy('stand_id', 'criterio_id')
    // ->orderBy('stand_id')
    // ->get();
    $criteriosIds = Event_Criterio::where('evento_id', $idEvento)->pluck('criterio_id');

    // Obtener el promedio de las evaluaciones agrupadas por criterio
    $evaluaciones = Evaluation::with(['stand', 'criterio'])
    ->where('stand_id', $idStand)
    ->groupBy('stand_id', 'criterio_id') // Agrupar por ID del stand y ID del criterio
    ->selectRaw('stand_id, criterio_id, AVG(rank) as avg_rank') // Calcular el promedio del rank
    ->get();

    return view('metricas/metricas_stand', compact('datosUsuarios', 'evaluaciones','idStand', 'filtroEdad', 'filtroGenero','filtroFecha'));

    
}
public function exportToExcel_satnds(Request $request, $idStand)
{
    // Obtener los datos filtrados utilizando el método usuariosVisitantes
    $filteredData = $this->usuariosVisitantes($request, $idStand)->getData();

    // Crear una nueva instancia de Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();



    // Añadir imagen en las celdas combinadas de A1:A6
    $drawing = new Drawing();
    $drawing->setName('Logo QR');
    $drawing->setWorksheet($sheet);
    $drawing->setPath(public_path('images/LOGO_QR.png')) // Ruta de la imagen
            ->setHeight(170)
            ->setCoordinates('A1');
    $drawing->setDescription('Logo QR');
$sheet->getRowDimension(1)
    ->setRowHeight(130);


    // Combinar celdas B1:F6 para el título "Información de Visitantes"
    $sheet->mergeCells('B1:F1');
    // Añadir título con estilo
    $titleStyle = [
        'font' => [
            'bold' => true,
            'size' => 22,
            'color' => ['rgb' => '000000'], // Color del texto
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Centrar horizontalmente
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Centrar verticalmente
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFFFF'], // Color de fondo
        ],
    ];
    // Eliminar el borde derecho de la celda A1

    $sheet->setCellValue('B1', 'Información de Visitantes');
    $sheet->getStyle('B1')->applyFromArray($titleStyle);


    // Añadir encabezados combinados
    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'], // Color del texto
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '8e243c'], // Color de fondo
        ],
    ];

    $sheet->setCellValue('A2', 'Nombre del Visitante');
    $sheet->getStyle('A2')->applyFromArray($headerStyle);
    $sheet->setCellValue('B2', 'Correo Electrónico');
    $sheet->getStyle('B2')->applyFromArray($headerStyle);
    $sheet->setCellValue('C2', 'Género');
    $sheet->getStyle('C2')->applyFromArray($headerStyle);
    $sheet->setCellValue('D2', 'Edad');
    $sheet->getStyle('D2')->applyFromArray($headerStyle);
    $sheet->setCellValue('E2', 'Fecha de asistencia al evento');
    $sheet->getStyle('E2')->applyFromArray($headerStyle);
    $sheet->setCellValue('F2', 'Hora');
    $sheet->getStyle('F2')->applyFromArray($headerStyle);

    // Añadir datos filtrados desde la fila 8
    foreach ($filteredData['datosUsuarios'] as $key => $datosUsuarios) {
        $row = $key + 3; // A partir de la fila 8
        $sheet->setCellValue('A' . $row, $datosUsuarios['name']);
        $sheet->setCellValue('B' . $row, $datosUsuarios['email']);
        $sheet->setCellValue('C' . $row, $datosUsuarios['genere']);
        $sheet->setCellValue('D' . $row, $datosUsuarios['age']);
        $sheet->setCellValue('E' . $row, $datosUsuarios['date']);
        $sheet->setCellValue('F' . $row, $datosUsuarios['time']);
        // Aplicar estilo de borde a la fila
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '9c9c9c'], // Color del borde
                ],
            ],
        ]);
    }

    // Ajustar automáticamente el ancho de las columnas según el contenido
    foreach (range('A', 'F') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Aplicar bordes a las columnas para las líneas verticales
    foreach (range('A', 'F') as $column) {
        $sheet->getStyle($column . '1:' . $column . $sheet->getHighestRow())
            ->getBorders()->getRight()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
            ->getColor()->setRGB('9c9c9c');
    }
$sheet->getStyle('A1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);


    // Configurar encabezados y tipo de contenido para la descarga
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Informacion_Visitantes.xlsx"');
    header('Cache-Control: max-age=0');

    // Crear un Writer y guardar el archivo Excel en la salida del navegador
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}
public function limpiarFiltros_stand(Request $request)
{
    // Redirige de vuelta a la página de la métrica del stand sin filtros
    return redirect()->route('metricas/metricas_stand');
}
    
    public function graficastands($idStand) {
    
        // Encuentra el stand según su ID
        $stand = Stand::findOrFail($idStand);
    
        // Obtén los pasaportes asociados con este stand
        $pasaportes = $stand->pasaportes;
    
        // Inicializar arrays para contar usuarios por género, fecha y hora
        $classifiedCount = [
            'F' => 0,
            'M' => 0,
            'Null' => 0,
            'total' => 0
        ];

        $usersCountByGender = [];
        $usersCountByDate = [];
        $usersCountByTime = [];
        $usersCountByAgeGroup = [
            'Adolescentes (12-18 años)' => 0,
            'Jovenes (19-26 años)' => 0,
            'Adultos (27-59 años)' => 0,
            'Adultos Mayores (60 años o más)' => 0,
        ];
        $usersCountByDateCategory = [
            'Hoy' => 0,
            'Hace 1 día' => 0,
            'Hace 2 días' => 0,
            'Hace 1 semana o más' => 0,
        ];
        $timeIntervals = [
            '6:00 - 8:00' => ['06:00:00', '08:00:00'],
            '8:00 - 10:00' => ['08:00:00', '10:00:00'],
            '10:00 - 12:00' => ['10:00:00', '12:00:00'],
            '12:00 - 14:00' => ['12:00:00', '14:00:00'],
            '14:00 - 16:00' => ['14:00:00', '16:00:00'],
            '16:00 - 18:00' => ['16:00:00', '18:00:00'],
            '18:00 - 20:00' => ['18:00:00', '20:00:00'],
            '20:00 - 22:00' => ['20:00:00', '22:00:00'],
            '22:00 - 24:00' => ['22:00:00', '23:59:59'], // Desde las 22:00 hasta el final del día
        ];
        $usersCountByTimeInterval = [];
     // Obtener la fecha actual
     $currentDate = now();
        // Itera sobre cada pasaporte para contar usuarios por género, fecha y hora
        if ($pasaportes !== null) {
            foreach ($pasaportes as $pasaporte) {
                // Accede al usuario asociado con este pasaporte
                $usuario = $pasaporte->user;
    
                // Verifica si el usuario existe y tiene un correo electrónico
                if ($usuario && $usuario->email) {
                    // Obtener género, fecha y hora del usuario
                    $gender = $usuario->genere ?? 'Null'; // Si el género no está definido, se clasifica como 'Null'

                           // Incrementar el conteo por género y el conteo total
                        $classifiedCount[$gender]++;
                        $classifiedCount['total']++;


                    $gender = $usuario->genere;
                    $date = $pasaporte->date;
                    $time = $pasaporte->time;

                    foreach ($timeIntervals as $interval => $range) {
                        // Verificar si la hora del pasaporte está dentro del rango de tiempo del intervalo
                        if ($time >= $range[0] && $time < $range[1]) {
                            // Incrementar el conteo de usuarios para este intervalo
                            if (!isset($usersCountByTimeInterval[$interval])) {
                                $usersCountByTimeInterval[$interval] = 0;
                            }
                            $usersCountByTimeInterval[$interval]++;
                            // Romper el bucle una vez que se haya encontrado el intervalo correcto
                            break;
                        }
                    }
    
                    // Incrementar el conteo de usuarios por género
                    if (!isset($usersCountByGender[$gender][$date])) {
                        $usersCountByGender[$gender][$date] = 0;
                    }
                    $usersCountByGender[$gender][$date]++;

                    
            // Calcular la diferencia en días entre la fecha actual y la fecha del pasaporte
            $pasaporteDate = \Carbon\Carbon::parse($date);
            $daysDifference = $currentDate->diffInDays($pasaporteDate);

            // Clasificar la fecha del pasaporte en categorías
            if ($daysDifference == 0) {
                $dateCategory = 'Hoy';
            } elseif ($daysDifference == 1) {
                $dateCategory = 'Hace 1 día';
            } elseif ($daysDifference == 2) {
                $dateCategory = 'Hace 2 días';
            } elseif ($daysDifference >= 3) {
                $dateCategory = 'Hace 1 semana o más';
            } else {
                // Si la diferencia es mayor a 7 días, simplemente utilizamos la fecha
                $dateCategory = $pasaporteDate->format('Y-m-d');
            }

            // Incrementar el conteo de usuarios por fecha en la categoría correspondiente
            $usersCountByDateCategory[$dateCategory]++;
    
                    // Incrementar el conteo de usuarios por fecha
                    if (!isset($usersCountByDate[$date])) {
                        $usersCountByDate[$date] = 0;
                    }
                    $usersCountByDate[$date]++;
    
                    // Incrementar el conteo de usuarios por hora
                    // if (!isset($usersCountByTime[$time])) {
                    //     $usersCountByTime[$time] = 0;
                    // }
                    // $usersCountByTime[$time]++;

                    // Determinar el grupo de edad del usuario y aumentar el conteo correspondiente
                    if ($usuario && $usuario->age) {
                        // Determinar el grupo de edad del usuario
                        $ageGroup = $this->determineAgeGroup($usuario->age);
            
                        // Incrementar el contador correspondiente al grupo de edad
                        $usersCountByAgeGroup[$ageGroup]++;
                    }
                }
            }
        }
        // $evaluaciones = Evaluation::with('criterio')->where('stand_id', $idStand)->get();
        $evaluaciones = Evaluation::with(['stand', 'criterio'])
        ->where('stand_id', $idStand)
        ->groupBy('stand_id', 'criterio_id') // Agrupar por ID del stand y ID del criterio
        ->selectRaw('stand_id, criterio_id, AVG(rank) as promedio_rank') // Calcular el promedio del rank
        ->get();
    
       
    
        // Retorna los conteos agrupados por género, fecha y hora
        return view('metricas/metricas_graficas_stands', compact('usersCountByGender', 'usersCountByDate','usersCountByTimeInterval', 'usersCountByTime','usersCountByAgeGroup','evaluaciones','classifiedCount','usersCountByDateCategory'));
    }


    public function eventosmetricas(Request $request, $eventId)
    {
        $evento = Event::findOrFail($eventId);
        $logoEvento = $evento->logo;
       
        // Obtener todos los stands relacionados con el evento dado
        $stands = Stand::where('evento_id', $eventId)->get();
    
        // Obtener todos los lugares asociados al evento dado a través de la tabla place_event
        $places = Place_event::where('event_id', $eventId)->with('place')->get();
    
        // Inicializar un array para almacenar la información de los usuarios
        $usersInfo = [];
    
        // Verificar si se está solicitando un filtrado por stand
        $standId = $request->input('stand_id');
    
        // Filtrar los stands si se seleccionó alguno
        $standsQuery = Stand::where('evento_id', $eventId);
        if ($standId) {
            $standsQuery->where('id', $standId);
        }
        $stands = $standsQuery->get();
    
        // Verificar si se ha seleccionado una edad para filtrar
        $selectedAge = $request->input('age');
    
        // Verificar si se ha seleccionado un género para filtrar
        $selectedGender = $request->input('gender');
    
        // Obtener la fecha seleccionada
        $selectedDate = $request->input('selected_date');
    
        // Obtener el lugar seleccionado
        $selectedPlaceId = $request->input('selected_place');
    
        // Filtrar los usuarios por edad si se ha seleccionado alguna
        $usersQuery = User::query();
        if ($selectedAge) {
            $ageRange = explode('-', $selectedAge);
            $usersQuery->whereBetween('age', [$ageRange[0], $ageRange[1]]);
        }
    
        // Filtrar los usuarios por género si se ha seleccionado alguno
        if ($selectedGender) {
            $usersQuery->where('genere', $selectedGender);
        }
    
        // Obtener todos los usuarios según los filtros aplicados
        $users = $usersQuery->get();
    
        // Iterar sobre cada usuario y obtener la información relacionada
        foreach ($users as $user) {
            // Obtener los pasaportes asociados al usuario actual
            $passports = Passport::where('user_id', $user->id)->whereIn('stand_id', $stands->pluck('id'));
    
            // Filtrar los pasaportes por fecha si se ha seleccionado una fecha
            if ($selectedDate) {
                $passports->whereDate('date', $selectedDate);
            }
    
            // Filtrar los pasaportes por lugar si se ha seleccionado un lugar
            if ($selectedPlaceId) {
                $passports->whereHas('stand', function ($query) use ($selectedPlaceId) {
                    $query->where('places_id', $selectedPlaceId);
                });
            }
    
            $passports = $passports->get();
    
            // Iterar sobre cada pasaporte y obtener la información del stand asociado
            foreach ($passports as $passport) {
                // Obtener la información del stand
                $stand = $stands->where('id', $passport->stand_id)->first();
    
                // Almacenar la información del usuario en el array
                $usersInfo[] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'genere' => $user->genere,
                    'age' => $user->age,
                    'stand_name' => $stand->name,
                    'date' => $passport->date,
                    'time' => $passport->time,
                ];
            }
        }

        $event_criterios = Event_Criterio::where('evento_id', $eventId)->pluck('criterio_id');

            $evaluaciones = Evaluation::with(['criterio'])
                ->whereIn('criterio_id', $event_criterios)
                ->groupBy('criterio_id')
                ->selectRaw('criterio_id, AVG(rank) as avg_rank')
                ->get();


    
            // Itera sobre las evaluaciones para agregar información adicional
           
            // Pasar los datos a la vista
            return view('metricas/metricas_evento', [
                    'usersInfo' => $usersInfo,
                    'eventId' => $eventId,
                    'stands' => $stands,
                    'selectedAge' => $selectedAge,
                    'selectedGender' => $selectedGender,
                    'standId' => $standId,
                    'selectedDate' => $selectedDate,
                    'places' => $places,
                    'selectedPlaceId' => $selectedPlaceId, // Agregamos el lugar seleccionado
                    'evaluaciones'=>$evaluaciones,
                    'logoEvento' => $logoEvento
                ]);
        }
      
    
            public function restablecerFiltros_evento(Request $request)
        {
            // Redirige a la misma página de métricas con todos los filtros restablecidos
            return redirect()->route('metricas/metricas_evento', ['idStand' => $request->idStand]);
        }

    

        // Método para filtrar usuarios por edad
        private function filtrarUsuariosPorEdad($usersInfo, $selectedAge)
        {
            return array_filter($usersInfo, function ($userInfo) use ($selectedAge) {
                     $ageRange = explode('-', $selectedAge);
                        $age = $userInfo['age'];
            return $age >= $ageRange[0] && $age <= $ageRange[1];
        });
        }
        // Método para filtrar usuarios por género
        private function filtrarUsuariosPorGenero($usersInfo, $selectedGender)
        {
            return array_filter($usersInfo, function ($userInfo) use ($selectedGender) {
                return $userInfo['genere'] == $selectedGender;
            });
        }

    
    public function graficapersonasgeneroxstand_evento($eventId) {
        // Encuentra todos los stands asociados con el evento
        $stands = Stand::where('evento_id', $eventId)->get();
    
        // Inicializar array para almacenar el total de usuarios por stand
        $totalUsersByStand = [];
    
        // Inicializar array para almacenar el total de personas del evento por género
        $totalUsersByGender = ['F' => 0,'M' => 0,'Null' => 0,'total' => 0
    ];
    
        // Inicializar contador para el total de personas del evento
        $totalEventUsers = 0;
    
        // Inicializar array para almacenar el número de asistentes por día
        $attendeesByDay = [];
    
        // Inicializar array para almacenar el número de asistentes por hora
        $attendeesByHour = [];
    
        for ($i = 6; $i < 22; $i += 2) {
            $startHour = str_pad($i, 2, '0', STR_PAD_LEFT); // Hora de inicio del intervalo
            $endHour = str_pad($i + 2, 2, '0', STR_PAD_LEFT); // Hora de fin del intervalo
            $interval = "{$startHour}-{$endHour}"; // Intervalo de 2 horas
        
            // Inicializar el contador de asistentes para este intervalo
            $attendeesByHour[$interval] = 0;
        }
      

        // Iterar sobre cada stand para contar el total de usuarios y el total de personas del evento
        foreach ($stands as $stand) {
            // Obtén los pasaportes asociados con este stand
            $pasaportes = $stand->pasaportes;
    
            // Itera sobre cada pasaporte para contar usuarios y actualizar el total de personas del evento
            foreach ($pasaportes as $pasaporte) {
                // Accede al usuario asociado con este pasaporte
                $usuario = $pasaporte->user;
    
                // Verifica si el usuario existe y tiene un correo electrónico
                if ($usuario && $usuario->email) {
                    // Incrementar el contador de personas del evento
                    $gender = $usuario->genere ?? 'Null'; // Si el género no está definido, se clasifica como 'Null'

                    // Incrementar el conteo por género y el conteo total
                 $totalUsersByGender[$gender]++;
                 $totalUsersByGender['total']++;


                }
    
                // Obtener la hora del pasaporte
                $hour = Carbon::parse($pasaporte->time)->format('H');
                // Verifica si la hora está dentro del rango de 6 am a 10 pm
                if ($hour >= 6 && $hour <= 22) {
                    // Redondear la hora al intervalo de 2 horas más cercano
                    $intervalStart = floor($hour / 2) * 2;
                    $intervalEnd = $intervalStart + 2;
                    $interval = str_pad($intervalStart, 2, '0', STR_PAD_LEFT) . '-' . str_pad($intervalEnd, 2, '0', STR_PAD_LEFT);
        
                    // Incrementar el contador para el intervalo correspondiente
                    if (isset($attendeesByHour[$interval])) {
                        $attendeesByHour[$interval]++;
                    }
                }
            }
            
            // Almacena el total de usuarios para este stand
            $totalUsersByStand[$stand->name] = count($stand->pasaportes);
        }
       
    
        // Ordena los stands por número de visitas en orden descendente
        arsort($totalUsersByStand);
    
        // Toma los primeros 5 stands
        $top5Stands = array_slice($totalUsersByStand, 0, 5, true);
    
        // Calcula el número de asistentes por día
        foreach ($stands as $stand) {
            foreach ($stand->pasaportes as $pasaporte) {
                // Obtener la fecha de creación del pasaporte
                $date = Carbon::parse($pasaporte->date)->toDateString();
    
                // Verificar si la fecha ya está en el array de asistentes por día
                if (!isset($attendeesByDay[$date])) {
                    // Si no está, inicializar el contador en 1
                    $attendeesByDay[$date] = 1;
                } else {
                    // Si está, incrementar el contador en 1
                    $attendeesByDay[$date]++;
                }
            }
        }
        $event_criterios = Event_Criterio::where('evento_id', $eventId)->pluck('criterio_id');

        $evaluaciones = Evaluation::with(['criterio'])
            ->whereIn('criterio_id', $event_criterios)
            ->groupBy('criterio_id')
            ->selectRaw('criterio_id, AVG(rank) as avg_rank')
            ->get();
    
       
        // Retorna los totales de personas por stand, personas por género, top 5 de stands más visitados,
        // y número de asistentes por día para el evento
        return view('metricas/metricas_graficas_evento', compact('totalUsersByStand', 'totalEventUsers', 'totalUsersByGender', 'top5Stands', 'attendeesByDay', 'attendeesByHour','event_criterios'));
    }
        private function determineAgeGroup($age)
    {
        if ($age >= 12 && $age <= 18) {
            return 'Adolescentes (12-18 años)';
        } elseif ($age >= 19 && $age <= 26) {
            return 'Jovenes (19-26 años)';
        } elseif ($age >= 27 && $age <= 59) {
            return 'Adultos (27-59 años)';
        } else {
            return 'Adultos Mayores (60 años o más)';
        }
    }
    public function exportToExcel(Request $request, $eventId)
{
    // Obtener los datos filtrados utilizando el método eventosmetricas
    $filteredData = $this->eventosmetricas($request, $eventId)->getData();

    // Crear una nueva instancia de Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Añadir imagen en las celdas combinadas de A1:A6
    $drawing = new Drawing();
    $drawing->setName('Logo QR');
    $drawing->setWorksheet($sheet);
    $drawing->setPath(public_path('images/LOGO_QR.png')) // Ruta de la imagen
            ->setHeight(170)
            ->setCoordinates('A1');
    $drawing->setDescription('Logo QR');
$sheet->getRowDimension(1)
    ->setRowHeight(130);

 // Combinar celdas B1:F6 para el título "Información de Visitantes"
 $sheet->mergeCells('B1:G1');
 // Añadir título con estilo
 $titleStyle = [
     'font' => [
         'bold' => true,
         'size' => 22,
         'color' => ['rgb' => '000000'], // Color del texto
     ],
     'alignment' => [
         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Centrar horizontalmente
         'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Centrar verticalmente
     ],
     'fill' => [
         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
         'startColor' => ['rgb' => 'FFFFFF'], // Color de fondo
     ],
 ];
 // Eliminar el borde derecho de la celda A1

 $sheet->setCellValue('B1', 'Información de Eventos');
 $sheet->getStyle('B1')->applyFromArray($titleStyle);


 // Añadir encabezados combinados
 $headerStyle = [
     'font' => [
         'bold' => true,
         'color' => ['rgb' => 'FFFFFF'], // Color del texto
     ],
     'fill' => [
         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
         'startColor' => ['rgb' => '8e243c'], // Color de fondo
     ],
 ];

    // Añadir encabezados
    $sheet->setCellValue('A2', 'Nombre del Visitante');
    $sheet->getStyle('A2')->applyFromArray($headerStyle);
    $sheet->setCellValue('B2', 'Correo Electrónico');
    $sheet->getStyle('B2')->applyFromArray($headerStyle);
    $sheet->setCellValue('C2', 'Género');
    $sheet->getStyle('C2')->applyFromArray($headerStyle);
    $sheet->setCellValue('D2', 'Edad');
    $sheet->getStyle('D2')->applyFromArray($headerStyle);
    $sheet->setCellValue('E2', 'Nombre del Stand');
    $sheet->getStyle('E2')->applyFromArray($headerStyle);
    $sheet->setCellValue('F2', 'Fecha de asistencia al evento');
    $sheet->getStyle('F2')->applyFromArray($headerStyle);
    $sheet->setCellValue('G2', 'Hora');
    $sheet->getStyle('G2')->applyFromArray($headerStyle);

    // Añadir datos filtrados
    foreach ($filteredData['usersInfo'] as $key => $userInfo) {
        $row = $key + 3; // +2 para evitar sobrescribir los encabezados
        $sheet->setCellValue('A' . $row, $userInfo['name']);
        $sheet->setCellValue('B' . $row, $userInfo['email']);
        $sheet->setCellValue('C' . $row, $userInfo['genere']);
        $sheet->setCellValue('D' . $row, $userInfo['age']);
        $sheet->setCellValue('E' . $row, $userInfo['stand_name']);
        $sheet->setCellValue('F' . $row, $userInfo['date']);
        $sheet->setCellValue('G' . $row, $userInfo['time']);

        // Aplicar estilo de borde a la fila
        $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '9c9c9c'], // Color del borde
                ],
            ],
        ]);
    }
     // Ajustar automáticamente el ancho de las columnas según el contenido
     foreach (range('A', 'G') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Aplicar bordes a las columnas para las líneas verticales
    foreach (range('A', 'G') as $column) {
        $sheet->getStyle($column . '1:' . $column . $sheet->getHighestRow())
            ->getBorders()->getRight()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
            ->getColor()->setRGB('9c9c9c');
    }
$sheet->getStyle('A1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);


    // Configurar encabezados y tipo de contenido para la descarga
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Informacion_Eventos.xlsx"');
    header('Cache-Control: max-age=0');

    // Crear un Writer y guardar el archivo Excel en la salida del navegador
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}
private function calcularEstrellas($promedio)
{
    // Define los rangos para asignar estrellas
    $rango1 = 1;
    $rango2 = 2;
    $rango3 = 3;
    $rango4 = 4;
    $rango5 = 5;

    // Asigna estrellas según el promedio en los rangos definidos
    if ($promedio >= $rango1 && $promedio < $rango2) {
        return 1;
    } elseif ($promedio >= $rango2 && $promedio < $rango3) {
        return 2;
    } elseif ($promedio >= $rango3 && $promedio < $rango4) {
        return 3;
    } elseif ($promedio >= $rango4 && $promedio < $rango5) {
        return 4;
    } elseif ($promedio >= $rango5) {
        return 5;
    } else {
        // Si el promedio está fuera de los rangos, devuelve 0 estrellas
        return 0;
    }
}
public function mostrarComentarios($standId, $criterioId)
{
    // Obtener las evaluaciones basadas en el stand y el criterio
    $evaluaciones = Evaluation::where('stand_id', $standId)
        ->where('criterio_id', $criterioId)
        ->get();

    // Pasar las evaluaciones a la vista para mostrar los feedbacks
    return view('metricas.metricas_stand_comentarios', compact('evaluaciones'));
}

}