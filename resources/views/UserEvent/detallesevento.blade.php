<header>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</header>
@extends('layouts.app')
@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
            <div class="card-header align-items-center text-center">
            </div>
            <div class="card-body">
            <div class="caja-adminplace caja-adminEventoDetallesj">
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
                    <div class="text-center">
                    <img class="logo-detallesrelacionadosalstand mx-auto img-fluid" src="{{ asset('images/Evento.png') }}" alt="">
                </div>
                    <div class="evento-contenedor text-center display-4">
                        <span class="mb-3 rounded titulodetalleevento">{{ $evento->name }}</span>
                    </div>
                    <div class="text-center">
                    <span class="Textdetalleeventoadminvis descripcion-evento" name="description">{{ $evento->description }}</span>
                </div>                
                    <div class="col-Iconosredes col-IconosredesDetalleseventostand text-center my-3">
                        <a class="link-icono" href="{{$evento->facebook}}" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-facebook me-3" id="red-socialdetalleseventoadmin"></i>
                        </a>
                        <a class="link-icono" href="{{$evento->instagram}}" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-instagram me-3" id="red-socialdetalleseventoadmin"></i>
                        </a>
                        <a class="link-icono" href="{{$evento->web}}" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-tiktok" id="red-socialdetalleseventoadmin"></i>
                        </a>
                    </div>
                    
                    @auth
                    @if(\Auth::user()->hasRole('Evento'))
                    
                    <div class="button-container">
        <form id="formMetricas" action="{{ route('metricas.metricas_evento', $evento->id) }}" method="GET">
            @csrf
            <button type="submit" class="btnvermetricasdetallesevento1">Ver Métricas</button>
        </form>

        <form action="{{ route('Detalleseventos', $evento->id) }}">
            <button type="submit" class="btnvermetricasdetallesevento1verdetalles">Ver Detalles</button>
        </form>
    </div>

                    
                            <form action="{{ route('UserEvent.agregar_lugarevento')}}" method="POST">
                                @csrf
                                    
                                    <div class="seleccionlugar1">
                                    <select name="place_id" class="form-controls">
                                        <option value="" selected disabled>Selecciona un lugar para el evento</option>
                                        @foreach($places as $place)
                                        <option value="{{ $place->id }}">{{ $place->name }}</option>
                                        @endforeach
                                    </select>  
                                <button type="submit" class="btn placesagregarr">Agregar Lugar</button>
                                <input style="display: none;" name="event_id" value="{{ $evento->id }}">
                                </form>
                            </div>
                                <p class=""></p>
                                <div class="tables-responsivelugares tablelugaresDeTTa">
                                <table class="tabla">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="borde-redondeadodetalle " class="borde-redondeado">Lugar</th>
                                            <th scope="col" class="itemsdetalle">E-mail</th>
                                            <th scope="col" class="itemsdetallelatitud" >Latitud</th>
                                            <th scope="col" class="itemsdetallelacciones">Acciones</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            @foreach($lugares as $lugar)
                                                <tr>
                                                    <td data-titulo="Nombre">{{ $lugar->place->name }}<hr class="lineas"></td>
                                                    <td data-titulo="Email">{{ $lugar->place->email }}<hr class="lineas"></td>
                                                    <td data-titulo="Latitud">{{ $lugar->place->latitude }}<hr class="lineas"></td>
                                                    <td>
                                                        <form action="{{ route('UserEvent.eliminarlugar_event', ['id' => $lugar->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                            <button type="submit"  class="btn btn-primary">Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                    
                        <br></br>
                        
                        <h3 class="Textdetalleeventoversioncriterios1"></h3>

                        <div class="tables-responsivelugares tablelugaresDeTTaLL">
                        <table class=tabla>
                            <thead>
                                <tr>
                                    <th scope="col" class="borde-redondeadodetallecri ">Nombre </th>
                                    <th scope="col" class="itemsdetalledescripcion ">Descripción</th>
                                    <th scope="col" class="borderedondeadodetalle">Acciones</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach($eventosc as $eventoc)
                                    <tr>
                                        <td data-titulo="Nombre">{{ $eventoc->criterio->name}}<hr class="lineas"></td>
                                        <td data-titulo="Descripcion">{{ $eventoc->criterio->description }}<hr class="lineas"></td>
                                        <td>
                                            <form action="{{ route('UserEvent.eliminarevent_criterio', ['id' => $eventoc->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"  class="btn btn-primary">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                    <form action="{{ route('UserEvent.agregar_criterioevento')}}" method="POST">
                        @csrf
                            <div class="seleccionlugar2">
                                    
                                <select name="criterio_id" class="form-controls">
                                    <option value="" selected disabled>Selecciona un criterio de calificación</option>
                                    @foreach($criterios as $criterio)
                                        <option value="{{ $criterio->id }}">{{ $criterio->name }}</option>
                                    @endforeach
                                </select>
                                <!-- Campos del formulario para agregar un criterio -->
                                <button type="submit"  class="btn placesagregarr02">Agregar Criterio</button> 
                            </div>
                        <!-- Campo oculto para enviar el ID del evento -->
                        <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                    </form>
                    
                    <br></br>
                    <h1 class="listadolugares display-4">
                        <div class="grayy-textolistplace d-md-inline">
                            <span class="rojo-textlistplacedetta d-md-inline">Crear un nuevo criterio</span>
                        </div>
                    </h1>
                    
                                <form action="{{ route('UserEvent.crearCriterio')}}" method="POST">
                                    @csrf
                                            <div class="card-empresa">
                                                <div class="mb-3 rounded formplaceregisDET">
                                                <label for="email" class="form-label2DETTA">Nombre del Criterio</label>
                                                    <input type="text" id="name" name="name" class="form-control">
                                                </div>
                                                <div class="mb-3 rounded formplaceregisDETT">
                                                <label for="email" class="form-label22DET">Descripción del Criterio</label>
                                                    <input type="text" id="description" name="description" class="form-control">
                                                </div>
                                                <!-- Campo oculto para enviar el ID del evento -->
                                                <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                                                <button type="submit" class="btnvermetricasdetallesevento1verdetallesSD">Crear Criterio</button>
                                            </div>
                                        </form>
                                    </div>

                        </div>   
            
                                @endif
                                @endauth
                                @auth()
                                @if(\Auth::user()->hasRole('Administrador'))
                                <div class="button-container">
                                    <form id="formMetricas" action="{{ route('metricas.metricas_even', $evento->id) }}" method="GET" >
                                        @csrf
                                        <button type="submit" class="btnvermetricasdetallesevento1">Ver Métricas</button>
                                        
                                    </form>
                                    <form action="{{ route('dedtalleseventosese', $evento->id) }}">
                                    <button type="submit" class="btnvermetricasdetallesevento1verdetalles">
                                        
                                            Ver Detalles
                                        </button>
                                    </form>
                                </div>
                                <div class="containerLLug">
                                    <p class="Textdetalleeventoversionadminluegares titulolugarmoviladmin   Lugaresdeleventoclass">Lugares del Evento</p>
                                </div>    
                                <div class="tables-responsivelugaresADMINdett tablelugaresDeTTadetalles">
                                    
                                    <table class="tabla">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="borde-redondeadodetalleseventodeladminp " class="borde-redondeado">Lugar</th>
                                                <th scope="col" class="itemsdetalleeventoadminvis">E-mail</th>
                                                <th scope="col" class="itemsdetallelatituddetalleadmin" >Latitud</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lugares as $lugar)
                                                <tr>
                                                    <td data-titulo="Nombre:">{{ $lugar->place->name }}<hr class="lineas"></td>
                                                    <td data-titulo="E-mail:">{{ $lugar->place->email }}<hr class="lineas"></td>
                                                    <td data-titulo="Latitud:">{{ $lugar->place->latitude }}<hr class="lineas"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="containerLLug">
                                    <p class="Textdetalleeventoversionadminluegaress titulolugarmoviladmin">Criterios de Calificación del evento</p>
                                </div>    
                                <div class="tables-responsivelugaresADMINdett tablelugaresDeTTaLLdetta2">
                                        <table class=tabla>
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="borde-redondeadodetallecrivistadmin ">Nombre </th>
                                                    <th scope="col" class="borde-redondeadodetallecrivistadmindes ">Descripción</th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                    @foreach($eventosc as $eventoc)
                                                        <tr>
                                                            <td data-titulo="Nombre:">{{ $eventoc->criterio->name}}<hr class="lineas"></td>
                                                            <td data-titulo="Descripción:">{{ $eventoc->criterio->description }}<hr class="lineas"></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    
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
   <!-- <script>
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
</script> -->
@endsection