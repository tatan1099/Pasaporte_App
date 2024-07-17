@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        
    </head>
    <body>
    <div class="container">
            <div class="card">
                <div class="card-header">
                    <h1>Editar Usuario </h1>
                </div>
                @auth
                    @if(auth()->user()->hasRole('Empresa'))
                        <div class="card-body">
                            <form method="post" action="{{route('user.updates',$user->id)}}">
                    @elseif(auth()->user()->hasRole('Administrador'))
                        <div class="card-body">
                            <form method="post" action="{{route('user.update',$user->id)}}">
                
                @method('PUT')
                        @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text">Nombre y Apellido</span>
                        <input type="text" class="form-control" name="name" value="{{$user->name}}" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Documento</span>
                        <input type="text" class="form-control" name="document" value="{{$user->document}}" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">E-mail</span>
                        <input type="text" class="form-control" name="email" value="{{$user->email}}" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Número de celular</span>
                        <input type="text" class="form-control" name="phone" value="{{$user->phone_number}}" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Dirección</span>
                        <input type="text" class="form-control" name="address" value="{{$user->address}}" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Fecha de nacimiento</span>
                        <input type="date" class="form-control" name="birthday" value="{{$user->birthday}}" required>
                    </div>
                    <div class="mb-3">
                        <select required class="form-control input-register" id="age" name="age">
                            <option value="" disabled>Seleccione su edad</option>
                                @for ($i = 18; $i <= 120; $i++)
                                    <option value="{{ $i }}" {{ $i =$user->age ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <select required class="form-control input-register" name="genere" required>
                            <option value="" disabled>Seleccione su género</option>
                            <option value="F" {{ $user->genere == 'F' ? 'selected' : '' }}>Femenino</option>
                            <option value="M" {{ $user->genere == 'M' ? 'selected' : '' }}>Masculino</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Crear Contraseña</span>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Confirmar Contraseña</span>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    @error('password')
                    <div class="alert alert-danger" role="alert">
                        Las contraseñas no coinciden.
                    </div>
                    @enderror
                    <input type="hidden" name="rol_id" value="{{$user->rol_id}}">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    @auth
                        @if(auth()->user()->hasRole('Administrador'))
                            <a href="{{route('user.listarusuarios')}}" class="btn btn-primary">Volver</a>
                        @endif
                  @endauth
                
                    </form>
                </div>
            </div>
        </div>
    </body>
    </html>
@endsection