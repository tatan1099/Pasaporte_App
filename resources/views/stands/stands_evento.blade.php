@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
            <div class="card-header align-items-center text-center">
            </div>
            <div class="card-body">
            <div class="caja-adminplacestandsev">
            <div id="success-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: none; z-index: 9999;">
                    <div class="alert alert-success" role="alert" style="position: relative;">
                        <span id="success-message"></span>
                    </div>
                </div>
        <img class="logo-visitadosstandsevt mx-auto" src="{{asset('images/logoStand.png')}}" alt="">
        
        <h1 class="listadolugaresstandssv display-4">
            <span class="grayy-textolistplace TextoSDtandsEvento d-md-inline">STANDS</span> <br>
        </h1>       
    <div class="card-body">
            <div class="row_EventStandEvento mb-5">
                    @foreach ($stands as $stand)
                    <div class="custom-col-md-4 mb-5">
                        <div class="card" id="card-standrelacionevenetosSTANDSempre2">
                            @csrf
                            <img class="logoStand2" src="{{ asset($stand->logo) }}" alt="{{$stand->name}}">
                                <div class="calificacion">
                                    @php
                                    $calification = $stand->calification; // Obtener la calificación del stand
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++) @if ($i <=$calification) <!-- Rellenar la estrella si $i es menor o
                                        igual a $calification -->
                                        <label class="estrella-rellena" for="estrella{{$stand->id}}{{$i}}">&#9733;</label>
                                        @else
                                        <!-- Mostrar una estrella vacía si $i es mayor que $calification -->
                                        <label class="estrella-vacia" for="estrella{{$stand->id}}{{$i}}">&#9734;</label>
                                        @endif
                                        @endfor
                                </div>
                                <div class="input-group mb-3 cardsstandsevent">
                                    <label for="floatingInput" class="label-stand nombrempresastar">Nombre Empresa</label>
                                    <input type="text" id="input-stand" name="name" value="{{$stand->name}}" readonly class="nombrestar"><hr class="lineasstands">
                                </div>
                                <div class="input-group mb-3 cardsstandsevent">
                                    <label for="floatingInput" class="label-stand direccionstar">Dirección</label>
                                <textarea id="input-stand2" name="direccion" readonly class="direccionempresastar">{{$stand->places->address}}</textarea>
                                
                                </div>
                                <div class="input-group mb-3 cardsstandsevent">
                                    <label for="floatingInput" class="label-stand telefonostar">Número Telefonico</label>
                                    <hr class="lineasstandstel"><input type="email" id="input-stand" name="email" value="{{$stand->user->phone_number}}" readonly class="telefonoempresastar"><hr class="lineasstandstell">
                                </div>
                                <div class="input-group mb-3 cardsstandsevent">
        <label for="floatingInput" class="label-stand descripcionempresa">Descripción</label>
        <!-- Usar la etiqueta <textarea> para permitir múltiples líneas de entrada -->
        <textarea id="input-stand2" readonly style="margin-top:5%;">{{$stand->description}}</textarea>
    </div>

                                <div class="input-group mb-3 justify-content-center webstar">
                                    <a href="{{$stand->web}}">{{$stand->web}}</a>
                                </div>
                                <div class="row text-center redessociales">
                                    <div class="col">
                                        <a class="link-icono" href="{{$stand->facebook}}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-facebook me-3" id="icono-red-social"></i>
                                        </a>
                                        <a class="link-icono" href="{{$stand->instagram}}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-instagram me-3" id="icono-red-social"></i>
                                        </a>
                                        <a class="link-icono" href="{{$stand->tiktok}}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-tiktok" id="icono-red-social"></i>
                                        </a>
                                    </div>
                                </div>
                                <br>
                                @auth
                                    @if(\Auth::user()->hasRole('Evento'))
                                        <form id="formMetricas" action="{{ route('metricas.stand_visitantes', $stand->id) }}" method="GET" >
                                            <button type="submit" class="btn btn-primary metricas">Ver Métricas</button>
                                        </form>
                                    @endif
                                @endauth
                                @auth
                                    @if(\Auth::user()->hasRole('Administrador'))
                                        <form id="formMetricas" action="{{ route('metricas.stand_visitant', $stand->id) }}" method="GET" >
                                            <button type="submit" class="btn btn-primary metricas">Ver Métricas</button>
                                        </form>
                                    @endif
                                @endauth
                                @auth
                                    @if(\Auth::user()->hasRole('Visitante'))
                                            <form action="{{ route('stands.show', ['idStand' => $stand->id]) }}">
                                                <button type="submit" class="btn btn-primary metricas">
                                        
                                                    Ver Detalles
                                                </button>
                                            </form>
                                    @endif
                                @endauth
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>
</body>
@endsection