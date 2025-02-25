@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
            <div class="card-header align-items-center text-center">
            </div>
            <div class="card-body">
            <div class="caja-adminplacestandsev">
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
        @auth
        @php
        $mostrarBoton = \Auth::user()->hasRole('Empresa');
        @endphp
        @if($mostrarBoton)
        
        <div class="text-center">
        <img class="logo-detallesrelacionadosalstandempre mx-auto img-fluid" src="{{asset('images/logoStand.png')}}" alt="">
        </div>
        <div style="text-align: center;">
        <a href="{{route('stand.create')}}" class="btn" id="btnC">Crear Stand</a>
    </div>
        @endif
        @endauth
        <div class="card-body">
        <div class="row_EventStandEvento mb-5">
        @foreach ($stands as $stand)
                    <div class="custom-col-md-4 mb-5">
                        <div class="card" id="card-standrelacionevenetosSTANDSempre">
                            @csrf
                            <img class="logoStand" src="{{ asset($stand->logo) }}" alt="{{$stand->name}}">
                                <div class="calificacion">
                                    @php
                                    $calification = $stand->calification; // Obtener la calificación del stand
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++) @if ($i <=$calification) <!-- Rellenar la estrella si $i es menor o
                                        igual a $calification -->
                                        <label class="estrella-rellena" for="estrella{{$stand->id}}{{$i}}">&#9733;</label>
                                        @else
                                        <!-- Mostrar una estrella vacía si $i es mayor que $calification -->
                                        <label class="estrella-vacia" for="estrella{{$stand->id}}{{$i}}">&#9734;</label>
                                        @endif
                                        @endfor
                                </div>
                                <div class="input-group mb-3 cardsstandsevent">
                                    <label for="floatingInput" class="label-stand nombrempresastar">Nombre Empresa</label>
                                    <input type="text" id="input-stand" name="name" value="{{$stand->name}}" readonly class="nombrestar"><hr class="lineasstands">
                                </div>
                                <div class="input-group mb-3 cardsstandsevent">
                                    <label for="floatingInput" class="label-stand direccionstar">Dirección</label>
                                <textarea id="input-stand2" name="direccion" readonly class="direccionempresaindex">{{$stand->places->address}}</textarea>
                                
                                </div>
                                <div class="input-group mb-3 cardsstandsevent">
                                    <label for="floatingInput" class="label-stand telefonostar">Número Telefonico</label>
                                    <hr class="lineasstandstel"><input type="email" id="input-stand" name="email" value="{{$stand->user->phone_number}}" readonly class="telefonoempresastar"><hr class="lineasstandstell">
                                </div>
                                <div class="input-group mb-3 cardsstandsevent">
                                    <label for="floatingInput" class="label-stand descripcionempresa">Descripción</label>
                                        <textarea class="Descripcionstandempresa" id="input-stand2" readonly style="margin-top:5%; ">{{$stand->description}}</textarea>
                                        </div>

                                <div class="input-group mb-3 justify-content-center webstar">
                                    <a href="{{$stand->web}}">{{$stand->web}}</a>
                                </div>
                                <div class="row text-center redessociales">
                                    <div class="col">
                                        <a class="link-icono" href="{{$stand->facebook}}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-facebook me-3" id="icono-red-social"></i>
                                        </a>
                                        <a class="link-icono" href="{{$stand->instagram}}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-instagram me-3" id="icono-red-social"></i>
                                        </a>
                                        <a class="link-icono" href="{{$stand->tiktok}}" target="_blank" rel="noopener noreferrer">
                                            <i class="bi bi-tiktok" id="icono-red-social"></i>
                                        </a>
                                    </div>
                                </div>
                                        @auth
                                        @if(\Auth::user()->hasRole('Empresa'))
                                        <div class="button-containerempre">
                                            <form id="formMetricas" action="{{ route('stand.edit', $stand->id) }}" method="GET" >
                                                @csrf
                                                <button type="submit" class="btnvermetricasdetallesevento1Edit">Editar</button>
                                            </form>
                                                @endif
                                            @endauth
                                            <form action="{{ route('stand.show', $stand->id) }}">
                                                <button type="submit" class="btnvermetricasdetallesevento1verdetallesvv">
                                        
                                                    Ver Detalles
                                                </button>
                                            </form>
                                            
                                        </div>
                                            
                                
                </div>
                </div>
                @endforeach
        </div>

    </div>
    </div>
    </div>
        </div>
</body>
<script>
    // Función para mostrar el mensaje de éxito y recargar la página después de 3 segundos
    function showSuccessMessage(message) {
        const successMessageContainer = document.getElementById('success-message-container');
        const successMessageElement = document.getElementById('success-message');

        // Mostrar el mensaje de éxito
        successMessageElement.innerText = message;
        successMessageContainer.style.display = 'block';

        // Ocultar el mensaje y recargar la página después de 3 segundos
        setTimeout(function () {
            successMessageContainer.style.display = 'none';
            location.reload(); // Recargar la página
        }, 3000);
    }

    // Verificar si estamos en la página de detalles del evento
    const isEventDetailsPage = document.getElementById('event-details-page');
    if (isEventDetailsPage) {
        // Mostrar el mensaje de éxito si hay un mensaje de éxito en la sesión
        const successMessage = '{{ session('success') }}';
        if (successMessage) {
            showSuccessMessage(successMessage);
        }
    }
</script>


@endsection