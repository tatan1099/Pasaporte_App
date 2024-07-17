@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<div class="container-fluid">
        <div class="card-header align-items-center text-center">
        </div>
        <div class="card-body">
        <div class="caja-adminplace cajaactivarempresadministrador">
         <div id="success-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: none; z-index: 9999;">
                <div class="alert alert-success" role="alert" style="position: relative;">
                    <span id="success-message"></span>
                </div>
            </div>

                @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        showSuccessMessage('{{ session('success') }}');
                    });
                </script>
                @endif
                  <div id="success-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: none; z-index: 9999;">
                <div class="alert alert-success" role="alert" style="position: relative;">
                    <span id="success-message"></span>
                </div>
            </div>
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    showSuccessMessage('{{ session('success') }}');
                });
            </script>
            @endif
            @if(session('error'))
            <div id="error-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: block; z-index: 9999;">
                <div class="alert alert-danger" role="alert" style="position: relative;">
                    <span id="error-message">{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        
        <img class="logo-visitadosACT mx-auto" src="{{asset('images/Empresa.png')}}" alt="">            
        <h1 class="listadolugaresACT display-4">
        <span class="grayy-textolistplace d-md-inline">ACTIVAR</span> <br>
        <span class="rojo-textlistplaceACT d-md-inline">EMPRESAS</span>
        
        </h1>
<body>
@auth
@php
$mostrarMenuAdmin = \Auth::user()->hasRole('Administrador');
@endphp 
@if($mostrarMenuAdmin)
<form method="POST" action="{{ route('users.activarEmpresa') }}">      
    @csrf
         <div class="tables-responsiveuser1actv tableACT">
        <table class="tabla">
            <thead>
                <tr>
                    <th hidden>ID</th>
                    <th scope="col" class="redondeado">Nombre</th>
                    <th scope="col" class="iteemmss">E-mail</th>
                    <th class="estyle">Activado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td hidden>{{ $user->id }}</td>
                    <td data-titulo="Nombre:">{{ $user->name }}<hr class="lineas"></td>
                    <td data-titulo="E-mail:">{{ $user->email }}<hr class="lineas"></td>
                    <td data-titulo="Activado:">
                    <input type="checkbox" name="users[]" value="{{ $user->id }}" class="actcheck" {{ $user->activado ? 'checked' : '' }}>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <button type="submit" class="btn btn-block mt-3 btnplaces btn-ActivarEmpresasActualizar" id="butoonn">  Actualizar</button>      
        
  
    </form>
    @endif
 @endauth
 @auth
@php
$mostrarMenuAdmin = \Auth::user()->hasRole('Evento');
@endphp 
@if($mostrarMenuAdmin)
<form method="POST" action="{{ route('usuarios.activaraEmpresasa') }}">      
    @csrf
    <div class="tables-responsiveuser1actv tableACT">
        <table class="tabla">
            <thead>
                <tr>
                    <th hidden>ID</th>
                    <th scope="col" class="redondeado">Nombre</th>
                    <th scope="col" class="iteemmss">E-mail</th>
                    <th class="estyle">Activado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td hidden>{{ $user->id }}</td>
                    <td data-titulo="Nombre:">{{ $user->name }}<hr class="lineas"></td>
                    <td data-titulo="E-mail:">{{ $user->email }}<hr class="lineas"></td>
                    <td data-titulo="Activado:">
                    <input type="checkbox" name="users[]" value="{{ $user->id }}" class="actcheck" {{ $user->activado ? 'checked' : '' }}>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <button type="submit" class="btn btn-block mt-3 btnplaces" id="butoonn">  Actualizar</button>
        
  
    </form>
@endif
 @endauth
</body>
</div>
</div>
</div>
     <script>
    // Función para mostrar el mensaje de éxito
    function showSuccessMessage(message) {
        const successMessageContainer = document.getElementById('success-message-container');
        const successMessageElement = document.getElementById('success-message');

        // Mostrar el mensaje de éxito
        successMessageElement.innerText = message;
        successMessageContainer.style.display = 'block';

        // Ocultar el mensaje después de 3 segundos
        setTimeout(function () {
            successMessageContainer.style.display = 'none';
        }, 3000);
    }
</script>
</html>
@endsection