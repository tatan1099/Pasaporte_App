@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container">
        <div class="card-evaluation mt-3">
            <img class="logo-evaluation" src="{{asset('images/logoUser.png')}}" alt="">
            <div class="card-header">
                Evaluación de Stand
                <div class="input-group mb-3">
                    <!--<h1>Bienvenido - {{ $user->name }} </h1> -->
                </div>
            </div>
            <div class="card-body">
            <form action="{{ route('evaluation.store', ['qr_code' => $qr_code]) }}" method="POST">
                @csrf
                @foreach($criterios as $criterio)
                <div class="card mb-3 p-3">
                    <label>Pregunta {{ $criterio->description }}</label>
                    <input type="hidden" name="criterio_id[]" value="{{$criterio->id}}">
                    <input class="form-control" type="number" name="puntuacion[]" required>
                </div>
                @endforeach
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Feedback" name="feedback" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Feedback</label>
                </div>
                <button id="btn" type="submit" class="btn btn-primary m-3">Enviar</button>
            </form>
            </div>
        </div>
    
    </div>
</body>
@endsection