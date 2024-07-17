@extends('layouts.app')
@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">


    <!-- Mensaje de éxito -->
    <div id="success-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: none; z-index: 9999;">
        <div class="alert alert-success" role="alert" style="position: relative;">
            <span id="success-message"></span>
        </div>
    </div>
    
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showSuccessMessage('{{ session('success') }}');
        });
    </script>
    @endif

    @if(session('error'))
    <div id="error-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: block; z-index: 9999;">
        <div class="alert alert-danger" role="alert" style="position: relative;">
            <span id="error-message">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="containerDetailStand">
                <div class="card-headerDF align-items-center text-center">
                    <div>
                        <img class="logo-visitadostandsD " src="{{ asset($stand->event->logo) }}" alt="Logo de visitados"> 
                    </div>
                    @auth
                        @if(\Auth::user()->hasRole('Empresa'))
                        <form id="formMetricas" action="{{ route('metricas.stand.usuarios-visitantes', $stand->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="btonmetricas">
                                <img src="{{ asset('images/MetricasBtn.png') }}" alt="Ver Métricas" class="img-fluid">
                            </button>
                        </form>
                        @endif
                    @endauth

                    <input type="hidden" name="evento_id" value="{{ $stand->evento_id }}">
                    <input type="hidden" name="stand_id" value="{{ $stand->id }}">

                    @auth
                        @if(\Auth::user()->hasRole('Empresa'))
                        <form action="{{ route('stand.qr', $stand->id) }}" method="GET" target="_blank">
                            <button type="submit" class="btoncodigo">
                                <img src="{{ asset('images/QrBtn.png') }}" alt="Generar código QR" class="img-fluid">
                            </button>
                        </form>
                        @endif
                    @endauth

                    @auth
                        @if(\Auth::user()->hasRole('Visitante'))
                        <form action="{{ route('calificacion', ['evento_id' => $stand->evento_id, 'stand_id' => $stand->id]) }}" method="GET">
                            <button type="submit" class="Detail btn">Generar Calificación</button>
                        </form>
                        @endif
                    @endauth        
                </div>

                <div class="stand-cardDE" style="background-color: {{ $stand->color_contenedor_1 }};">
                    <ul>
                        @if($stand)
                        <li class="DF stands-card stands-card-pequeñadetailss" style="background-color: {{ $stand->color_contenedor_3 }};">
                            <span class="Nombredetalles" style="color: {{ $stand->color_contenedor_2 }}">{{ $stand->name }}</span>
                        </li>

                        <!-- Contenido del lado izquierdo -->
                        <div class="info-imagen-container">
                            <div class="left-side">
                                <div class="info-container">
                                <div>
                                        <p class="eventositemsdescripcion" style="color: {{ $stand->color_contenedor_4 }};">Descripción del stand</p><br>
                                        <div class = "prueba450">
                                        <p class="EventoDetails" style="color: {{ $stand->color_contenedor_4 }};">{{ $stand->description }}</p>
                                        </div>
                                    </div>                                 
                            </div>
                            </div>

                            <!-- Contenido del lado derecho -->
                            <div class="contenedor-imagenstand" id="contendor-imagenstand">
                                <img class="bannereventodetails" src="{{ asset($stand->banner) }}" alt="">
                            </div>
                        </div>
                       

                        <div class="horizontal-layout">
                                            <div class="info-item">
                                                <h4 class="titulosdetails" style="color: {{ $stand->color_contenedor_4 }};">Evento</h4>
                                                <p  style="color: {{ $stand->color_contenedor_4 }};">{{ $stand->event->name }}</p>
                                            </div>
                                            <div class="info-item">
                                                <h4 class="titulosdetails" style="color: {{ $stand->color_contenedor_4 }};">Contacto</h4>
                                                <p style="color: {{ $stand->color_contenedor_4 }};">{{ $stand->user->phone_number }}</p>
                                            </div>
                                            <div class="info-item">
                                                <h4 class="titulosdetails" style="color: {{ $stand->color_contenedor_4 }};">Lugar</h4>
                                                <p  style="color: {{ $stand->color_contenedor_4 }};">{{ $stand->places->name }}</p>
                                            </div>
                                            
                                            <div class="col-DE">
                                                <a class="link-icono" href="{{ $stand->facebook }}" target="_blank" rel="noopener noreferrer">
                                                    <i class="bi bi-facebook me-3" id="icono-red-social"></i>
                                                </a>
                                                <a class="link-icono" href="{{ $stand->instagram }}" target="_blank" rel="noopener noreferrer">
                                                    <i class="bi bi-instagram me-3" id="icono-red-social"></i>
                                                </a>
                                                <a class="link-icono" href="{{ $stand->web }}" target="_blank" rel="noopener noreferrer">
                                                    <i class="bi bi-tiktok" id="icono-red-social"></i>
                                                </a>
                                            </div>
                                        </div>

                        <!-- Carrusel de imágenes -->
                        
                        <div id="carouselExampleControlsdetailS" class="carousel slide" data-ride="carousel">
                            
                        <a class="carousel-control-prev" href="#carouselExampleControlsejemplostand" role="button" data-slide="prev">
                                <button type="button" class="prevDetails" onclick="prevImage2()">&#10094; Anterior</button>
                            </a><div class="Detailimg carousel-inner">
                                @php
                                    $numImages = 10; // Número total de imágenes
                                @endphp
                                @for ($i = 1; $i <= $numImages; $i++)
                                    @if ($stand->{"images{$i}"})
                                        <div class="carousel-item text-center {{ $i == 1 ? 'active' : '' }}">
                                            <img src="{{ asset($stand["images{$i}"]) }}"  class="imagenlistinv " alt="Imagen {{ $i }}">
                                        </div>
                                    @endif
                                @endfor
                            </div>
                            
                            <a class="carousel-control-next" href="#carouselExampleControlsejemplostand" role="button" data-slide="next">
                                <button type="button" class="nextDetails" onclick="nextImage2()">Siguiente &#10095;</button>
                            </a>
                        </div>
                        </div>

                        <div class="row text-center"></div>
                        @else
                        <p>No se encontró el stand.</p>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    var errorMessageContainer = document.getElementById('error-message-container');
    if (errorMessageContainer) {
        setTimeout(function() {
            errorMessageContainer.style.display = 'none';
        }, 3000);
    }
});

function showSuccessMessage(message) {
    var successMessageContainer = document.getElementById('success-message-container');
    var successMessage = document.getElementById('success-message');
    successMessage.textContent = message;
    successMessageContainer.style.display = 'block';

    setTimeout(function() {
        successMessageContainer.style.display = 'none';
    }, 3000);
}
</script>
</html>
@endsection