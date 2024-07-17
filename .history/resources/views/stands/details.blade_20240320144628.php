@extends('layouts.app')
@section('content')

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Stand</title>
</head>
<body>
@if($stand->images1)
    <img src="{{$stand->images}}" alt="Imagen 1">
@endif


<div class="container">
    <div class="card-header align-items-center text-center">
        <h3 class="titulo">Detalles del Stand</h3>
        <img class="logo-visitados" src="{{ asset('images/logoStand.png') }}" alt="">
        <form id="formMetricas" action="{{ route('metricas.stand.usuarios-visitantes', $stand->id) }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-success" id="btn" style="width: 150px;">Ver Métricas</button>
        </form>
    </div>

    <div class="stand-card" style="color: {{ $stand->color_contenedor_4 }};background-color: {{ $stand->color_contenedor_3 }};">
        <ul>
            @if($stand)
                <li class="stands-card" style="color: {{ $stand->color_contenedor_2 }}; background-color: {{ $stand->color_contenedor_1 }};">
                    <div style="width: 100%; height: 100%; background-color: {{ $stand->color_contenedor_1 }};"></div>
                    <span style="color: {{ $stand->color_contenedor_2 }};">{{ $stand->name }}</span>
                </li>
                <li>
    Nombre:
    @if ($stand->images1)
        <img src="{{ $stand->images1 }}" alt="Imagen 1">
    @else
        Sin imagen disponible
    @endif
</li>
<!-- Mostrar el logo -->
<!-- <img src="{{ asset($stand->logo) }}" alt="Logo">


<img src="{{ asset($stand->banner) }}" alt="Banner"> -->

<!-- Mostrar las imágenes adicionales -->
<!-- @if (!empty($stand->images1))
    <img src="{{ asset($stand->images1) }}" alt="Imagen 1">
@endif
@if (!empty($stand->images2))
    <img src="{{ asset($stand->images2) }}" alt="Imagen 2">
@endif -->
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @php
                    $numImages = 10; // Número total de imágenes
                @endphp

                @for ($i = 1; $i <= $numImages; $i++)
                    @if ($stand->{"images{$i}"})
                        <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                            <img class="d-block w-100" src="{{ asset($stand["images{$i}"]) }}" alt="Imagen {{ $i }}">
                        </div>
                    @endif
                @endfor
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
           

                <img class="d-block w-100" src="{{ $stand->images1 }}" alt="Imagen 1">

                <div class="info-container">
                    <div class="info-item">
                        <h4>Evento</h4>
                        <p>{{ $stand->event->name }}</p>
                    </div>
                    <div class="info-item">
                        <h4>Usuario</h4>
                        <p>{{ $stand->user->name }}</p>
                    </div>
                    <div class="info-item">
                        <h4>Lugar</h4>
                        <p>{{ $stand->places->name }}</p>
                    </div>
                </div>

                @auth
                    @if(\Auth::user()->hasRole('Empresa'))
                        <form action="{{ route('generar.qr', $stand->id) }}" method="GET" target="_blank">
                            <button type="submit" style="margin-top:20px;">Generar código QR</button>
                        </form>
                    @endif
                @endauth

                <div class="description-container">
                    <div class="description-box">
                        <h4 class="description-heading">Descripción</h4>
                        <p>{{ $stand->description }}</p>
                    </div>
                </div>
            @else
                <p>No se encontró el stand.</p>
            @endif
        </ul>
        <input type="hidden" name="evento_id" value="{{ $stand->evento_id }}">
        <input type="hidden" name="stand_id" value="{{ $stand->id }}">
        @auth
            @if(\Auth::user()->hasRole('Visitante'))
                <a href="{{ route('calificacion', ['evento_id' => $stand->evento_id, 'stand_id' => $stand->id]) }}">Generar Calificación</a>
            @endif
        @endauth

        <div class="container " id="container-stand">
            <!-- Formulario para redirigir a la página de métricas -->
        </div>
    </div>
</div>
<img src="{{ asset('storage/app/public/images/1710187023907-image1.jpg') }}" class="d-block w-100" alt="...">

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Envía el formulario automáticamente
        document.getElementById("formStandId").submit();

        // Redirige al usuario de nuevo al detalle del stand después de que se haya enviado el formulario
        document.getElementById("formStandId").addEventListener("submit", function(event) {
            window.location.href = "{{ route('stands.show', $stand->id) }}";
            event.preventDefault(); // Evita el envío del formulario nuevamente
        });
    });
</script>

</body>
</body>
</html>
@endsection