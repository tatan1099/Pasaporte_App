@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container">
        <div class="card-visitados">
        <img class="logo-visitados" src="{{asset('images/logoStand.png')}}" alt="">
            <div class="row">
                
                @foreach ($passports as $passport)
                <div class="col-6 col-md-2 p-5">
                        <a href="/stands/{{ $passport->stand->id }}">
                            <img class="logoEmpresa" src="{{ $passport->stand->logo }}"
                                alt="{{ $passport->stand->logo }} Image">
                            <div class="watermark">
                            <img class="watermark-img" src="{{ asset('images/visitado.png') }}" alt="sello de Visitado">
                            </div>
                        </a> 
                </div>
                @endforeach
            </div>
        </div>
                

        <!--<div class="card">
            <div class="card-header">
                <h1>Passports Registrados</h1>
                <a href="{{route('passport.create')}}" class="btn btn-success">Escanear Nuevo Stand</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Logo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($passports as $passport)
                        <tr>
                            <th scope="row">{{$passport->id}}</th>
                            <th>{{$passport->stand->name}}</th>
                            <td>{{$passport->date}}</td>
                            <td scope="col">
                                <img src="{{ asset('storage/videos/Animación_sello_gif.gif')}}" alt="GIF PASAPORTE"  width="200" height="150">
                            </td>                     
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>-->
        
    </div>
</body>
@endsection