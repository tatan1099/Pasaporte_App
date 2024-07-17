@extends('layouts.app')

@section('content')
<div class="container" id="container-stand">
    <div class="card-body">
        @auth
        @php
        $mostrarBoton = \Auth::user()->hasRole('Empresa');
        @endphp
        @if($mostrarBoton)
        <div style="display:;  justify-content: center; margin-bottom: 20px;margin-top:100px; background-color" >
            <a href="{{route('stand.create')}}" class="btn btn-primary text-white" id="btn">Crear stand</a>
        </div>
        @endif
        @endauth

        <div class="row mb-5">
            @foreach ($stands as $stand)
            <div class="col-md-4 mb-5">
                <div class="card" id="card-stantes">
                    <img class="logoStand" src="{{$stand->logo}}" alt="{{$stand->name}}">
                    <div class="calificacion">
                        @php
                        $calification = $stand->calification; // Obtener la calificación del stand
                        @endphp
                        @for ($i = 1; $i <= 5; $i++) @if ($i <=$calification) <!-- Rellenar la estrella si $i es menor o igual a $calification -->
                        <label class="estrella-rellena" for="estrella{{$stand->id}}{{$i}}">★</label>
                        @else
                        <!-- Mostrar una estrella vacía si $i es mayor que $calification -->
                        <label class="estrella-vacia" for="estrella{{$stand->id}}{{$i}}">☆</label>
                        @endif
                        @endfor
                    </div>
                    <div class="input-group mb-3">
                        <label for="floatingInput" class="label-stand">Nombre Empresa</label>
                        <input type="text" id="input-stand" name="name" value="{{$stand->name}}" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <label for="floatingInput" class="label-stand">Dirección</label>
                        <input type="text" id="input-stand" name="direccion" value="{{$stand->user->address}}" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <label for="floatingInput" class="label-stand">Número Telefonico</label>
                        <input type="email" id="input-stand" name="email" value="{{$stand->user->phone_number}}" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <label for="floatingInput" class="label-stand">Descripción</label>
                        <input type="email" id="input-stand" name="email" value="{{$stand->description}}" readonly>
                    </div>
                    <div class="input-group mb-3 justify-content-center">
                        <a href="{{$stand->web}}">{{$stand->web}}</a>
                    </div>
                    <div class="row text-center">
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
                    <div class="text-center">
                        <a href="{{ route('stand.show', $stand->id) }}" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
