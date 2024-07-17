@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Registro Exitoso</h1>
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
                <h4>Passport Listo!!! échale un vistazo a tus Passports</h4>
                <a href="{{route('passport.index')}}" class="btn btn-success">Mis Passports</a>
            </div>
        </div>
    </div>
@endsection