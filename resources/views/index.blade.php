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
            
            @if($eventos->isNotEmpty())
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner ">
                    @foreach($eventos as $key => $event)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                        <a href="{{ route('Event.Detallesevento', $event->id) }}">
                            <img src="{{ asset($event->logo) }}" class="imagenlistinvindex" alt="{{ $event->name }}">
                        </a>
                    </div>
                    @endforeach
                </div>
                
            </div>
            @else
            <p>No hay eventos disponibles en este momento.</p>
            @endif
        </div>
    </div>
</div>

@endsection
