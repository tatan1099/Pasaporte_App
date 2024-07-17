@extends('layouts.app')
@section('content')
<div class="container-fluid  containeradminstradoresevento">
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

    <div class="card-header align-items-center text-center"></div>
    <div class="caja-admineventosvistaadmin ">

            <img class="logo-usuariosadmineventos mx-auto" src="{{asset('images/Adminevento.png')}}" alt="">
            <br>
            <a href="{{route('eventos.create')}}" class="btn btn-danger btn-block  crearnuevoadminevento">Nuevo administrador</a>
            <h1 ><span class="gray-textadminevento d-md-inline">ADMIN </span> <br> <span class="red-textadminevento  d-md-inline">EVENTOS</span></h1>
            <div class=" tableadminevento-responsive tableevento">
            <table class="tabla">
                <thead>
                    <tr>
                        <th scope="col" style="display: none;"></th>
                        <th scope="col" class="borde-redondeadonombre tituloNombreevento">Nombre</th>
                        <th scope="col" class="itemsevento">E-mail</th>
                        <th scope="col" class="itemseventodoc">Documento</th>
                        <th scope="col" class="itemseventotel">Número de Teléfono</th>
                        <th scope="col" class="itemseventomulti">Varios eventos</th>
                        <th scope="col" class="borde-redondeadoacciones">Acciones</th>         
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventos as $event)
                    <tr>
                        <td class="tituloNombreevento" data-titulo="Nombre:">{{ $event->name }}<hr class="lineas "></td>
                        <td class="tituloNombreevento" data-titulo="E-mail:" class="long-email">{{ $event->email }}<hr class="lineas"></td>
                        <td class="tituloNombreevento" data-titulo="Documento:">{{ $event->document }}<hr class="lineas"></td>
                        <td class="tituloNombreevento"  data-titulo="Teléfono:">{{ $event->phone_number }}<hr class="lineas"></td>
                        <td class="tituloEventoevento"  data-titulo="Varios eventos:">
                            @if($event->multi_evento == 1)
                                Sí
                            @else
                                No
                            @endif
                            <hr class="lineas ">
                        </td>
                        <td class="dffdff">
                            <form id="formeventos"  action="{{ route('UserEvent.eventosusuario', ['id' => $event->id]) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-vereventoss" id="btn-acciones btnVereventosAdmin" style="width: 150px; text-align: center;">Ver eventos</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              
            </table>
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
