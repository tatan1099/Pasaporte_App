@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="caja-adminindex">
        <div class="card-body text-center">
            <br>
            <h1 class="listadolugaresindex display-4">
                <span class="grayy-textolistplaceindex d-md-inline">SELECCIONA UN EVENTO</span> <br>
                <a  
                href="#carouselExampleControls" role="button" data-slide="prev" class="crearnuevoadmineventoINdex btn btn-block">❮ Anterior
                </a>
                <a  
                href="#carouselExampleControls" role="button" data-slide="next" class="crearnuevoadmineventoINdex2 btn btn-block">Siguiente ❯
                </a>  
            </h1>   
            
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($eventos as $key => $event)
                        <div class="carousel-item text-center {{ $key === 0 ? 'active' : '' }}">
                            <a href="{{ route('Event.Detallesevento', $event->id) }}">
                                <img src="{{ asset($event->banner) }}" class="imagenlistinvindex" alt="{{ $event->name }}">
                            </a>
                        </div>
                    @endforeach
                </div>
                


    </div>
</div>
</div>
<style>
   .container-fluid {
        background-image: url("{{ asset('images/fondoblanco.png') }}");
        background-size: cover; /* Ajusta el tamaño de la imagen al tamaño del contenedor */
        background-position: center; /* Centra la imagen en el contenedor */
    }
</style>
@endsection

