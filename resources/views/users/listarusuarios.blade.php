@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card-body">
        <div class="caja-adminplace cajalistausuariosadmin">
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
            <img class="logo-empsinactivarUser mx-auto" src="{{asset('images/Usuario.png')}}" alt="">
            <h1 class="listadousuarios display-4">
                <span class="grayy-textolistplace2 d-md-inline">LISTA DE</span> <br>
                <span class="rojo-textlistplaceUUser d-md-inline">USUARIOS</span>
            </h1>
            <div class="tables-responsiveuserr tabless">
                <table class="tablessuser">
                    <thead>
                        <tr>
                            <th scope="col" class="borde-redondeado">Nombre</th>
                            <th scope="col" class="itss">Rol</th>
                            <th scope="col" class="titulosusuarios">Número de Teléfono</th>
                            <th scope="col" class="titulosusuarioss">E-mail</th>
                            <th scope="col" class="estilo-borde-redondeado">Acciones</th>
                            <!-- <th scope="col" class="estiloss">acciones</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="ListausuariosposicionDatos" data-titulo="Nombre">{{ $user->name}}<hr class="lineas"></td>
                            <td class="ListausuariosposicionDatos" data-titulo="Rol">{{ $user->rol->name }}<hr class="lineas"></td>
                            <td class="ListausuariosposicionDatos"  data-titulo="Número de Teléfono">{{ $user->phone_number }}<hr class="lineas"></td>
                            <td class="ListausuariosposicionDatos" data-titulo="Email">{{ $user->email }}<hr class="lineas"></td>
                            <td>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-editar-listausuarioss" id="">Editar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
@endsection           