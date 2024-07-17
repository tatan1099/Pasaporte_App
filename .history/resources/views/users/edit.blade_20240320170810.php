@extends('layouts.app')

@section('content')
<style>
       
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        
            <h1>Editar Usuario</h1>
        </div>
        <div class="card-body">
                @auth
                    @if(\Auth::user()->hasRole('Administrador'))
                        <form method="post" action="{{route('user.update',$user->id)}}">
                    @endif
                @endauth
                @auth
                    @if(\Auth::user()->hasRole('Empresa'))
                        <form method="post" action="{{route('user.updates',$user->id)}}">
                    @endif
                @endauth
                        @method('PUT')
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text">Nombre y Apellido</span>
                            <input type="text" class="form-control" name="name" value="{{$user->name}}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Documento</span>
                            <input type="text" class="form-control" name="document" value="{{$user->document}}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Email</span>
                            <input type="text" class="form-control" name="email" value="{{$user->email}}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Numero de celular</span>
                            <input type="text" class="form-control" name="phone" value="{{$user->phone_number}}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Dirección</span>
                            <input type="text" class="form-control" name="address" value="{{$user->address}}" >
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Fecha de nacimiento</span>
                            <input type="date" class="form-control" name="birthday" value="{{$user->birthday}}">
                        </div>
                    

                        <div class="mb-3">
                            <select required class="form-control input-register" name="genere" required>
                                <option value="" disabled>Seleccione su género</option>
                                <option value="F" {{ $user->genere == 'F' ? 'selected' : '' }}>Femenino</option>
                                <option value="M" {{ $user->genere == 'M' ? 'selected' : '' }}>Masculino</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="age">Edad</label>
                            <select class="form-select" id="age" name="age">
                                <option value="" disabled>Selecciona tu edad</option>
                                @for ($i = 18; $i <= 120; $i++)
                                    <option value="{{ $i }}" {{ $user->age == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
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
                        <input type="hidden" name="rol_id" value="{{ $user->rol_id }}">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        @auth
                            @if(\Auth::user()->hasRole('Administrador'))
                                <a href="{{route('user.listarusuarios')}}" class="btn btn-primary">Volver</a>
                            @endif
                        @endauth

                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
</body>
</html>
@endsection 