@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="row justify-content-center col-md-8">
<div class="containerstars">
        <div class="caja-admin-metricasStand">
        <img class="logo-metricaStand" src="{{ asset('images/logoStand.png') }}" alt="">
<h2 class="titulo-visitantesmetricas h1-md">Visitantes del stand</h2>

<!-- Formulario para filtrar por edad -->
<form id="formSelectAge" method="GET" class="d-flex flex-wrap justify-content-start align-items-center">
    <div class="form-groupmetrica mx-2">
        <label for="selectAge">Selecciona una edad:</label>
        <select id="selectAge" name="edad" class="mi-select">
            <option value="">Todas las edades</option>
            <option value="18-25" {{ $filtroEdad == '18-25' ? 'selected' : '' }}>18-25</option>
            <option value="26-35" {{ $filtroEdad == '26-35' ? 'selected' : '' }}>26-35</option>
            <option value="36-45" {{ $filtroEdad == '36-45' ? 'selected' : '' }}>36-45</option>
            <!-- Agrega las opciones para otros rangos de edad según sea necesario -->
        </select>
    </div>

    <div class="form-groupmetrica mx-2">
        <label for="selectGender">Selecciona un género:</label>
        <select id="selectGender" name="genero" class="mi-select">
            <option value="">Todos los géneros</option>
            <option value="M" {{ $filtroGenero == 'M' ? 'selected' : '' }}>Masculino</option>
            <option value="F" {{ $filtroGenero == 'F' ? 'selected' : '' }}>Femenino</option>
            <!-- Agrega más opciones según sea necesario -->
        </select>
    </div>

    <div class="form-groupmetrica mx-2">
        <label class="seleccionarfechaclasss" for="selectDate">Selecciona una fecha:</label>
        <input  type="date" id="selectDate" name="fecha" value="{{ $filtroFecha }}" class="mi-select">
        <button type="submit" class="btn filtrarMetricaStand mx-2">Filtrar</button>
    </div>
    
</form>
<div class="posicionfiltrar d-flex flex-wrap mx-2" >
        <form id="formResetFilters" method="GET" class="mx-2">
            <input type="hidden" name="idStand" value="{{ $idStand }}">
            <button type="submit" class="filtrardeletemetricaStand btn">Eliminar consulta</button>
        </form>
    
        @if(auth()->user()->hasRole('Empresa'))
        <form action="{{ route('exportar.excel.stands', $idStand) }}" method="POST" class="mx-2">
            @csrf
            <input type="hidden" name="edad" value="{{ $filtroEdad }}">
            <input type="hidden" name="genero" value="{{ $filtroGenero }}">
            <input type="hidden" name="fecha" value="{{ $filtroFecha }}">
            <button type="submit" id="filtrarexcelEvento" class="filtrarexcelEvento btn mx-2">Exportar a Excel</button>
        @endif
        @auth
        @if(auth()->user()->hasRole('Administrador'))
            <form action="{{ route('exportar.excel.stand', $idStand) }}" method="POST">
                @csrf
                <input type="hidden" name="edad" value="{{ $filtroEdad }}">
                <input type="hidden" name="genero" value="{{ $filtroGenero }}">
                <input type="hidden" name="fecha" value="{{ $filtroFecha }}">
                <button type="submit" id="filtrarexcelEvento" class="filtrarexcelEvento btn mx-2">Exportar a Excel</button>
            </form>
        @endif

        @if(auth()->user()->hasRole('Evento'))
            <form action="{{ route('informe.excel.stand', $idStand) }}" method="POST">
                @csrf
                <input type="hidden" name="edad" value="{{ $filtroEdad }}">
                <input type="hidden" name="genero" value="{{ $filtroGenero }}">
                <input type="hidden" name="fecha" value="{{ $filtroFecha }}">
                <button type="submit" id="filtrarexcelEvento" class="filtrarexcelEvento btn mx-2">Exportar a Excel</button>
            </form>
        @endif
        @endauth
    </div>

</form>


<div class="tables-responsivemetricasmetri table1">
    <table class="tabla">
        <thead>
            <tr>
                <th scope="col" class="tableRoundedNameMetricas">Nombre</th>
                <th class="tableTittleEmail">E-mail</th>
                <th class="tableTittleGender">Género</th>
                <th class="tableTittleAge">Edad</th>
                <th class="tableTittleDate">Fecha</th>
                <th scope="col" class="tableRoundedHourMetricas">Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datosUsuarios as $usuario)
            <tr>
                <td data-titulo="Nombre">{{ $usuario['name'] }}<hr class="lineas"></td>
                <td data-titulo="E-mail">{{ $usuario['email'] }}<hr class="lineas"></td>
                <td data-titulo="Género">{{ $usuario['genere'] }}<hr class="lineas"></td>
                <td data-titulo="Edad">{{ $usuario['age'] }}<hr class="lineas"></td>
                <td data-titulo="Fecha">{{ $usuario['date'] }}<hr class="lineas"></td>
                <td data-titulo="Hora">{{ $usuario['time'] }}<hr class="lineas"></td> 
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class=evaluacionstarr2>
    <h2 class="evaluacionstands">Evaluaciones asociadas al Stand</h2>
    <div class="tables-responsivemetricass table2">
        <table class="tabla">           
            <thead>
                <tr>
                    <th scope="col" class="tableRoundedRank">Rank</th>
                    <th class="tittleTableCriterio">Criterio</th>
                    <th class="tittleTableEstrellas">Estrellas</th>
                    <th scope="col" class="tableRoundedAcciones">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($evaluaciones as $evaluacion)
                <tr>
                    <td data-titulo="Rank">{{ $evaluacion->avg_rank }}<hr class="lineas"></td>
                    <td data-titulo="Criterio">
                        @if ($evaluacion->criterio)
                            {{ $evaluacion->criterio->name }}
                        @else
                            No se encontró un criterio asociado
                        @endif
                        <hr class="lineas"></td>
                    <td data-titulo="Estrellas">
                        @php
                            $promedio = $evaluacion->avg_rank;
                        @endphp
                        <div class="calificacion Extrellascalificacion">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $promedio)
                                    <label class="estrella-rellena" for="estrella{{ $evaluacion->id }}{{ $i }}">&#9733;</label>
                                @else
                                    <label class="estrella-vacia" for="estrella{{ $evaluacion->id }}{{ $i }}">&#9734;</label>
                                @endif
                            @endfor
                        </div>
                        <hr class="lineas"></td>
                    <td>
                    @auth
                    @if(auth()->user()->hasRole('Empresa'))
                     <a href="{{ route('metricas.stand.comentarios', ['standId' => $idStand, 'criterioId' => $evaluacion->criterio->id]) }}" class="btn leercomentario">Leer Feedback</a>
                    @endif
                    @endauth
                    @auth
                    @if(auth()->user()->hasRole('Evento'))
                     <a href="{{ route('metrica.stand.comentarios', ['standId' => $idStand, 'criterioId' => $evaluacion->criterio->id]) }}" class="btn leercomentario">Leer Feedback</a>
                    @endif
                    @endauth
                    @auth
                    @if(auth()->user()->hasRole('Administrador'))
                     <a href="{{ route('metrica.stand.comentario', ['standId' => $idStand, 'criterioId' => $evaluacion->criterio->id]) }}" class="btn leercomentario">Leer Feedback</a>
                    @endif
                    @endauth
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @auth
        @if(auth()->user()->hasRole('Empresa'))
            <form method="GET" action="{{ route('metricas.stand.grafica', ['idStand' => $idStand]) }}">
                <button type="submit" class="btn  mostrarGraficaAdmin">Mostrar Gráfica</button>
            </form>
        @endif

        @if(auth()->user()->hasRole('Administrador'))
            <form method="GET" action="{{ route('metricas.stands.graficas', ['idStand' => $idStand]) }}">
                <button type="submit" class="btn  mostrarGraficaAdmin">Mostrar Gráfica Admin</button>
            </form>
        @endif

        @if(auth()->user()->hasRole('Evento'))
            <form method="GET" action="{{ route('metrica.stands.grafica', ['idStand' => $idStand]) }}">
                <button type="submit" class="btn  mostrarGraficaAdmin">Mostrar Gráfica</button>
            </form>
        @endif
    @endauth
</div>
</div>
</div>
</div>

@endsection

@push('scripts')
<!-- Script para enviar el formulario cuando se seleccione una edad, género o fecha -->
<script>
    document.getElementById('selectAge').addEventListener('change', function() {
        document.getElementById('formSelectAge').submit();
    });

    document.getElementById('selectGender').addEventListener('change', function() {
        document.getElementById('formSelectAge').submit();
    });

    document.getElementById('selectDate').addEventListener('change', function() {
        document.getElementById('formSelectAge').submit();
    });
</script>
@endpush
