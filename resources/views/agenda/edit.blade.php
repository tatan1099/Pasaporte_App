@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-empresa">
        <img class="logo-evaluation" src="{{asset('images/logoUser.png')}}" alt="">

        <div class="card-header text-center">
            <h1>Editar Agenda</h1>
        </div>

        <div class="card-body">

            <form method="post" action="{{route('agenda.update', $agenda->id)}}">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label class="label">Seleccione el Lugar de Presentacion</label>
                    <select id="input-empresa" name="place" required>
                        @foreach($places as $place)
                        <option value='{{$place}}'>{{$place->name}}, {{$place->schedule->hour_start}} -
                            {{$place->schedule->hour_end}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="label">Seleccione el Stand</label>
                    <select id="input-empresa" name="stand_id" required>
                        @foreach($stands as $stand)
                        <option value='{{$stand->id}}' @if($stand->id == $agenda->stand->id) selected @endif>
                            {{$stand->name}}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="row text-center">
                    <div class="col">
                        <button type="submit" class="btn btn-primary" id="btn">Registrar</button>
                        <a href="{{route('agenda.index')}}" class="btn btn-danger" id="btn">Volver</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection