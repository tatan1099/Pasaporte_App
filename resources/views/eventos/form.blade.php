@extends('layouts.app')
@section('content')
<body>
<div class="container-fluid">
        <div class="card-header align-items-center text-center">
        </div>
        <div class="card-body">
        <div class="containerDF">
         <div id="success-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: none; z-index: 9999;">
                <div class="alert alert-success" role="alert" style="position: relative;">
                    <span id="success-message"></span>
                </div>
            </div>
            <style>
        @media (max-width: 575px) { 
            .containerDF {
                background-color: {{ $detalleEvento->color_contenedor_1 }};
            }
        }
    </style>

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

    <div class="text-center">
        <img class="logo-detallesrelacionadosalstandempres logo-visitadostands img-fluid" src="{{asset('images/logoStand.png')}}" alt="">
        <form action="{{ route('standrelacionado', $detalleEvento->id) }}">
        <button type="submit" class="btn btn-primary metricasVER">Ver stands</button>
    </form>
    </div>
               
                <div class="stand-cardEV" style="background-color: {{ $detalleEvento->color_contenedor_1 }};margin:0 auto;">
                    <ul>
                        <li class="stands-card" style=" background-color: {{ $detalleEvento->color_contenedor_3 }};">
                            <div style="width: 100%; height: 100%; background-color: {{ $detalleEvento->color_contenedor_3 }};"></div>
                            <span  class="nombreDEF" style="color:{{ $detalleEvento->color_contenedor_2 }}">{{ $detalleEvento->name }}</span>
                        </li>
                    </ul>
                    <!-- Contenido del lado izquierdo -->
                    <div class="informacion-imagen-container">
                        <div class="lado-izquierdo">
                            <div class="informacion-container">
                                <div>
                                <div class="contenedorform">
                                    <span class="descripcionevento" style="color: {{ $detalleEvento->color_contenedor_4 }};">Descripción</span>  
                                </div>       
                                    <p class="textodescripcionevento" style= "color: {{ $detalleEvento->color_contenedor_4 }};">{{$detalleEvento->description}}</p>
                                </div>
                                    <div class="horizontal-layout">
                                    <div class="col-DF iconoossdetalles">
                                        <a class="link-icono" href="{{$detalleEvento->facebook}}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-facebook me-3" id="icono-red-social"></i>
                                        </a>
                                        <a class="link-icono" href="{{$detalleEvento->instagram}}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-instagram me-3" id="icono-red-social"></i>
                                        </a>
                                        <a class="link-icono" href="{{$detalleEvento->web}}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-tiktok" id="icono-red-social"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido del lado derecho -->
                        
                        <div class="col-lg-6">
                            <div id="contenedor-imagenform" class="contenedor-imagenform">
                                <img id="imagen" class="img-fluid imagenformeventodetails" src="{{ asset($detalleEvento->banner) }}" alt="">
                            </div>
                        </div>
                            
                        
                            <!-- Texto "Selecciona un stand" encima del carrusel -->
                            <span class="seleccionstand" style= "color: {{ $detalleEvento->color_contenedor_4 }};">Selecciona un stand</span>

                            <!-- Carrusel de imágenes del evento -->
                            <div id="innerlogostand" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($detalleEvento->stands as $stand)
                                        @if ($stand->logo)
                                            <div class="carousel-item  {{ $loop->first ? 'active' : '' }}">
                                                <a href="{{ route('stands.show', ['idStand' => $stand->id]) }}" >
                                                    <img src="{{ asset($stand->logo) }}" class="imagecarouselsolucionnnn img-fluid" alt="Logo del stand {{ $stand->nombre }}">
                                                    <span class="titulodetalles">{{ $stand->name }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="containerBotonesprevNext">
                            <a class="carousel-control-prev-formDF" href="#carouselEvento" role="button" data-slide="prev">
                                <button type="button" class="prevVerevento" onclick="prevImage2()">&#10094; Anterior</button>
                            </a>
                            <a class="carousel-control-next-formDF" href="#carouselEvento" role="button" data-slide="next">
                                <button type="button" class="nextVereventos" onclick="nextImage2()"> Siguiente &#10095;</button>
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function prevImage2() {
        $('#innerlogostand').carousel('prev');
    }

    function nextImage2() {
        $('#innerlogostand').carousel('next');
    }

    // Opcional: Puedes inicializar el carrusel si no lo has hecho
    $(document).ready(function() {
        $('#innerlogostand').carousel({
            interval: false // desactivar auto-desplazamiento
        });
    });
</script>
<script>
    // Función para mostrar el mensaje de éxito
    function showSuccessMessage(message) {
        const successMessageContainer = document.getElementById('success-message-container');
        const successMessageElement = document.getElementById('success-message');

        // Mostrar el mensaje de éxito
        successMessageElement.innerText = message;
        successMessageContainer.style.display = 'block';

        // Ocultar el mensaje después de 3 segundos
        setTimeout(function () {
            successMessageContainer.style.display = 'none';
        }, 3000);
    }
</script>
@endsection
