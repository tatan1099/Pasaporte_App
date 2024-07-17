@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-empresa">
        <img class="logo-evaluation" src="{{asset('images/logoUser.png')}}" alt="">
        <div class="card-header text-center">
            <h1>Registrar Agenda</h1>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card-body">
            <form method="post" action="{{route('agenda.store')}}">
                @csrf
                <div class="input-group mb-3">
                    <select name="place_id" required id="input-empresa">
                        <option value="" disabled selected>Seleccione el Lugar de Presentacion</option>
                        @foreach($places as $place)
                        <option value='{{$place-> id}}'>{{$place->name}}, {{$place->schedule->day}}
                            {{$place->schedule->hour_start}} - {{$place->schedule->hour_end}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <select id="input-empresa" name="stand_id" required>
                        <option value="" disabled selected>Seleccione el Stand</option>
                        @foreach($stands as $stand)
                        <option value='{{$stand-> id}}'>{{$stand->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <label for="floatingInput" class="label">Fecha de Inicio</label>
                    <input type="date" id="input-empresa" name="date_start" required>
                </div>
                <div class="input-group mb-3">
                    <label for="floatingInput" class="label">Fecha de Finalización</label>
                    <input type="date" id="input-empresa" name="date_end" required>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary" id="btn">Registrar</button>
                        <a href="{{route('agenda.index')}}" class="btn btn-danger " id="btn">Volver</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection