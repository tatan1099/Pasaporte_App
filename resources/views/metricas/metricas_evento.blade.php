@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center col-md-8">
        <div class="caja-admin-metricasEvento">
                <img class="logo-metricasEvento" src="{{asset('images/Metricas.png')}}" alt="">
                <label class="titleMetricasEvento textmetricas">Metricas del Evento</label>
                <div class="col">
                <div class="container-metricasEvento2">
                    @auth
                        @if(auth()->user()->hasRole('Evento'))
                            <div class="buttons-metricas ">
                                <form action="{{ route('informe.excel', $eventId) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="stand_id" value="{{ $standId }}">
                                    <input type="hidden" name="age" value="{{ $selectedAge }}">
                                    <input type="hidden" name="gender" value="{{ $selectedGender }}">
                                    <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                                    <input type="hidden" name="selected_place" value="{{ $selectedPlaceId }}">
                                    <button type="submit" class="buttonsresponsiveEventos ExporToExcelMetricasE btn ">Exportar a Excel</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                    
                    @auth
                        @if(\Auth::user()->hasRole('Evento'))
                            <form id="formMetricas" action="{{ route('metricas.graficapersonasgeneroxstand_evento',$eventId) }}" method="GET">
                            @csrf
                                <button type="submit" class="buttonsresponsiveEventos ShowGraphMetricasE btn">Ver Gráficas</button>
                            </form>
                        @endif
                    @endauth

                    @auth
                        @if(auth()->user()->hasRole('Administrador'))
                            <div class="buttons-metricas">
                                <form action="{{ route('exportar.excel', $eventId) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="stand_id" value="{{ $standId }}">
                                    <input type="hidden" name="age" value="{{ $selectedAge }}">
                                    <input type="hidden" name="gender" value="{{ $selectedGender }}">
                                    <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                                    <input type="hidden" name="selected_place" value="{{ $selectedPlaceId }}">
                                    <button type="submit" class="ExporToExcelMetricasA buttonsresponsiveEventos btn ">Exportar a Excel</button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    @auth
                        @if(\Auth::user()->hasRole('Administrador'))
                            <form id="formMetricas" action="{{ route('metrica.graficapersonasgeneroxstand_evento',$eventId) }}" method="GET">
                            @csrf
                                <button type="submit" class="ShowGraphMetricasA buttonsresponsiveEventos btn ">Ver Gráficas</button>
                            </form>
                        @endif
                        </div>
                    @endauth

                    <div class="contenedorMetricas">
                    <!-- Formulario para seleccionar el stand -->
                    <form id="formSelectStandM" method="GET">
                        <label for="formSelectStandM" class="formSelectStandM form-label" ><span class="standselectt">Selecciona un stand:</span></label>
                        <select id="selectStandM" name="stand_id" class="form-select">
                            <option value="">Todos los stands</option>
                                @foreach ($stands as $stand)
                                    <option value="{{ $stand->id }}" {{ $stand->id == $standId ? 'selected' : '' }}>{{ $stand->name }}</option>
                                @endforeach
                        </select>
                        <input type="hidden" name="age" value="{{ $selectedAge }}">
                        <input type="hidden" name="gender" value="{{ $selectedGender }}">
                        <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                    </form>

                    <!-- Formulario para seleccionar la edad -->
                    <form id="formSelectAgeM" method="GET">
                        <label for="SelectAgeMetricas" class="formSelectAgeM form-label"><span class="standselecttt">Selecciona una edad:</span></label>
                        <select id="SelectAgeMetricas" name="age" class="form-select"> <!-- Cambiado el ID a "SelectAgeMetricas" -->
                            <option value="">Todas las edades</option>
                            <option value="18-25" {{ $selectedAge == '18-25' ? 'selected' : '' }}>18-25</option>
                            <option value="26-35" {{ $selectedAge == '26-35' ? 'selected' : '' }}>26-35</option>
                            <option value="36-45" {{ $selectedAge == '36-45' ? 'selected' : '' }}>36-45</option>
                            <option value="46-55" {{ $selectedAge == '46-55' ? 'selected' : '' }}>46-55</option>
                            <option value="56-65" {{ $selectedAge == '56-65' ? 'selected' : '' }}>56-65</option>
                            <option value="66-75" {{ $selectedAge == '66-75' ? 'selected' : '' }}>66-75</option>
                            <option value="76-85" {{ $selectedAge == '76-85' ? 'selected' : '' }}>76-85</option>
                            <option value="86-95" {{ $selectedAge == '86-95' ? 'selected' : '' }}>86-95</option>
                            <!-- Agrega las opciones para otras edades según tu necesidad -->
                        </select>
                        <input type="hidden" name="stand_id" value="{{ $standId }}">
                        <input type="hidden" name="gender" value="{{ $selectedGender }}">
                        <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                    </form>

                    <!-- Formulario para seleccionar el género -->
                    <form id="formSelectGenderM" method="GET">
                        <label for="formSelectGenderM" class="formSelectGenderM form-label" ><span class="standselectdt">Selecciona un genero:</span></label>
                        <select class="formSelectGenderM form-select" id="selectGenderM" name="gender">
                            <option value="">Todos los géneros</option>
                            <option value="M" {{ $selectedGender == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ $selectedGender == 'F' ? 'selected' : '' }}>Femenino</option>
                            <!-- Agrega más opciones según tus necesidades -->
                        </select>
                        <input type="hidden" name="stand_id" value="{{ $standId }}">
                        <input type="hidden" name="age" value="{{ $selectedAge }}">
                        <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                    </form>

                    <!-- Formulario para seleccionar el lugar -->
                    <form id="formSelectPlaceM" method="GET">
                        <label class="form-label" for="selectPlaceM"><span class="standselectddt">Selecciona un Lugar:</span></label>
                        <select class="formSelectPlaceM form-select" id="selectPlaceM" name="selected_place">
                            <option value="">Todos los lugares</option>
                            @foreach ($places as $place)
                                <option value="{{ $place->place->id }}" {{ $place->place->id == $selectedPlaceId ? 'selected' : '' }}>
                                    {{ $place->place->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="stand_id" value="{{ $standId }}">
                        <input type="hidden" name="age" value="{{ $selectedAge }}">
                        <input type="hidden" name="gender" value="{{ $selectedGender }}">
                        <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                    </form>

                    

                    <!-- Formulario para seleccionar la fecha -->
                    <form id="formSelectDateM" method="GET">
                        <label for="selectedDate" class="formSelectDateM form-label"><span class="standselectcct">Selecciona una fecha:</span></label>
                        <input class="formSelectDateM form-date" type="date" id="selectedDate" name="selected_date" value="{{ $selectedDate }}"> <!-- Cambiado el ID a "selectedDate" -->
                        <input type="hidden" name="stand_id" value="{{ $standId }}">
                        <input type="hidden" name="age" value="{{ $selectedAge }}">
                        <input type="hidden" name="gender" value="{{ $selectedGender }}">
                    </form>

                    <!-- Formulario para restablecer todos los filtros -->
                    <form id="ResetFilterMetrica" class="ResetFilterMetrica" method="GET">
                        <input type="hidden" name="eventId" value="{{ $eventId }}">
                        <button type="submit" class="ResetFilterMetrica btn">Eliminar consulta</button>
                    </form>
                    </div>
                    

                    <!-- Tabla de resultados -->
                    <span class="titleMetricasE">Asistencia al evento</span>
                    <div class="tables-responsiveMetricasEvento tablesa1">
                        <table class="tabla ">
                            <thead>
                                <tr>
                                    <th scope="col"  class="tableMetricasName">Nombre del Visitante</th>
                                    <th scope="col"class="tableMetricasEmail">Correo Electrónico</th>
                                    <th scope="col"class="tableMetricasGender">Género</th>
                                    <th scope="col"class="tableMetricasAge">Edad</th>
                                    <th scope="col"class="tableMetricasNameStand">Nombre del Stand</th>
                                    <th scope="col" class="tableMetricasDate">Fecha de asistencia al evento</th>
                                    <th scope="col" class="tableMetricasHour">Hora</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($usersInfo as $userInfo)
                                        <tr>
                                            <td class="bodyTablesa1" data-titulo="Nombre">{{ $userInfo['name'] }}<hr class="lineas"></td>
                                            <td class="bodyTablesa1" data-titulo="E-mail">{{ $userInfo['email'] }}<hr class="lineas"></td>
                                            <td class="bodyTablesaDif" data-titulo="Género">{{ $userInfo['genere'] }}<hr class="lineas"></td>
                                            <td class="bodyTablesaDif" data-titulo="Edad">{{ $userInfo['age'] }}<hr class="lineas"></td>
                                            <td class="bodyTablesa1" data-titulo="Nombre del Stand">{{ $userInfo['stand_name'] }}<hr class="lineas"></td>
                                            <td class="bodyTablesaDifer" data-titulo="Fecha de asistencia">{{ $userInfo['date'] }}<hr class="lineas"></td>
                                            <td class="bodyTablesa1" data-titulo="Hora">{{ $userInfo['time'] }}<hr class="lineas"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                    <span class="titleciretioscaE">Criterios del evento</span>
                    <div class="tables-responsivemetricasEv tableMetricasEvento2">
                        <table class="tabla">
                            <thead>
                                <tr>
                                    <th scope="col" class="titleMetricasCriterio">Criterio</th>
                                    <th class="titleMetricasPromedio">Promedio</th>
                                    <th scope="col" class="titleMetricasStar">Estrellas</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($evaluaciones as $evaluacion)
                                    <tr>
                                        <td data-titulo="Nombre del criterio">
                                            @if ($evaluacion->criterio){{ $evaluacion->criterio->name }}
                                            @else Criterio no encontrado
                                            @endif
                                        <hr class="lineas"></td>
                                        <td  data-titulo="Promedio">{{ $evaluacion->avg_rank }}<hr class="lineas"></td>
                                        <td  data-titulo="Percepción">
                                            @php
                                            // Obtenemos el promedio de la evaluación
                                                $promedio = $evaluacion->avg_rank;
                                            @endphp
                                            <div class="calificacion EstrellaCalificacionMetricas">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $promedio)
                                                    <!-- Rellenar la estrella si $i es menor o igual al promedio -->
                                                        <label class="estrella-rellena" for="estrella{{ $evaluacion->id }}{{ $i }}">&#9733;</label>
                                                    @else
                                                    <!-- Mostrar una estrella vacía si $i es mayor que el promedio -->
                                                        <label class="estrella-vacia" for="estrella{{ $evaluacion->id }}{{ $i }}">&#9734;</label>
                                                    @endif
                                                @endfor
                                            </div>
                                        <hr class="lineas"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
                document.addEventListener("DOMContentLoaded", function() {
    // Captura el evento de cambio en el combobox de stands
    document.getElementById('selectStandM').addEventListener('change', function() {
        // Envía automáticamente el formulario cuando se selecciona un stand
        document.getElementById('formSelectStandM').submit();
    });

    // Captura el evento de cambio en el combobox de la edad
    document.getElementById('SelectAgeMetricas').addEventListener('change', function() {
        document.getElementById('formSelectAgeM').submit();
    });

    // Captura el evento de cambio en el campo de fecha
    document.getElementById('selectedDate').addEventListener('change', function() {
        // Envía el formulario automáticamente cuando se seleccione una fecha
        document.getElementById('formSelectDateM').submit();
    });

    // Captura el evento de cambio en el combobox del lugar
    document.getElementById('selectPlaceM').addEventListener('change', function() {
        // Envía el formulario cuando se seleccione un nuevo lugar
        document.getElementById('formSelectPlaceM').submit();
    });
      // Captura el evento de cambio en el combobox del género
      document.getElementById('selectGenderM').addEventListener('change', function() {
                document.getElementById('formSelectGenderM').submit();
            });
});

    </script>
    </div>
</div>
@endsection