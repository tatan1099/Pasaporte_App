@extends('layouts.app')
@section('content')

    <div class=" container-fluid containereventosdeladministradordelevento ">
        <div class="card-header align-items-center text-center"></div>
            <div class="card-body">
                <div class="caja-listaeventosuserevent">
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
                    <img class="logg-eventosdisponibles mx-auto" src="{{asset('images/Evento.png')}}" alt="">
        
                    <form action="{{ route('UserEvent.store') }}" method="POST" enctype="multipart/form-data">
                        <a href="{{ route('UserEvent.index') }}" class="btn btn-success btn-block  botoncreareeventovistaeventos">Crear Evento</a>   
                        @csrf
                        <h1><span class="gris-textoeventosdisponibles d-md-inline">EVENTOS</span> <br> <span class="red-texteventosdisponibles d-md-inline">VIGENTES</span></h1>
                        <div class="tablaeventosdisponibles-responsive tableeventovigente">
                            <table class="tabla">
                                <thead>
                                    <tr>
                                        <th scope="col" style="display: none;">ID</th>
                                        <th scope="col" class="borde-redondeadonombreeventosdisp">Nombre</th>
                                        <th scope="col" class="itemdescripeventosdispo">Descripción</th>
                                        <th  scope="col" class="estilo-borde-redondeadoaccioneseventosdisponi" >Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($eventos as $evento)
                                        <tr>
                                            <td style="display: none;" >{{ $evento->id }}</td>
                                            <td data-titulo="Nombre">{{ $evento->name }}<hr class="lineas"></td>
                                            <td  data-titulo="Descripción">{{ $evento->description }}<hr class="lineas"></td>
                                            <td>
                                                <div class="d-flex flex-wrap">
                                                    <div class="p-1">
                                                        <form method="GET" action="{{ route('UserEvent.edit', $evento->id) }}">
                                                            @csrf
                                                            <button type="button" onclick="window.location='{{ route('UserEvent.edit', $evento->id) }}'" class="btn accioneseditareventosdispbtn btn-block">Editar</button>
                                                        </form>
                                                    </div>
                                                    <div class="p-1">
                                                        <form method="GET" action="{{ route('UserEvent.standsevento', $evento->id) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-lg btn-block verstandisbtnvisteven">Ver Stands</button>
                                                        </form>
                                                    </div>
                                                    <div class="p-1">
                                                        <form method="GET" action="{{ route('UserEvent.eventosdetalles', $evento->id) }}">
                                                            @csrf
                                                            <button type="submit" class="btn datileventdiseventos btn-block">Detalles</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                    
                                            </td>   
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                                    
                    </form>  
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