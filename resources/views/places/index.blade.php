<head>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head> 
@extends('layouts.app')
@section('content')
<div class="container-fluid">
        <div class="card-header align-items-center text-center">
        </div>
        <div class="card-body">
        <div class="caja-adminplace">
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
                <img class="logo-visitados mx-auto" src="{{asset('images/Lugar.png')}}" alt="Imagen responsive">
                <h1 class="listadolugares display-4">
                <div class="grayy-textolistplace d-md-inline">
                    LISTADO DE <br> 
                    <span class="rojo-textlistplace">LUGARES</span>
                </div>
                </h1>
                <button onclick="window.location.href='{{ route('places.create') }}'" class="btn btn-primary" id="botonneditarLuGAA">Crear nuevo lugar</button>
            <div class="tables-responsivelugares tablelugares">
                <table class="tabla">
                <thead>
                        <tr>
                            <th scope="col" style="display: none;"></th>
                            <th scope="col" class="borde-redondeadoluG">Nombre</th>
                            <th scope="col" class="itemss">E-mail</th>
                            <th scope="col" class="itemss">Dirección</th>
                            <th scope="col" class="iteemss">Latitud</th>
                            <th scope="col" class="iteemss">Longitud</th>
                            <th scope="col" class="itmss">Horario</th>
                            <th scope="col" class="estilo-borde-redondeadoluG">Acción</th>
                            <th scope="col" class="estyleluG"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($places as $place)
                        <tr>
                            <td scope="row" style="display: none;">{{$place->id}}</td>
                            <td data-titulo="Nombre:">{{$place->name}}<hr class="lineas"></td>
                            <td data-titulo="E-mail:">{{$place->email}}<hr class="lineas"></td>
                            <td data-titulo="Dirección:">{{$place->address}}<hr class="lineas"></td>
                            <td data-titulo="Latitud:">{{$place->latitude}}<hr class="lineas"></td>
                            <td data-titulo="Longitud:">{{$place->length}}<hr class="lineas"></td>
                            <td data-titulo="Horario:">{{$place->schedule->day}}, {{$place->schedule->hour_start}} a
                                {{$place->schedule->hour_end}}<hr class="lineas">
                            </td>
                            <td><a href="{{route('places.edit',$place->id)}}" class="btn btn-editar Btn-editarLugaresadmin">Editar</a></td>
                            <form method="post" action="{{route('places.destroy',$place->id)}}">
                                @method('DELETE')
                                @csrf
                                <td scope="row"><button type="submit" class="btn btn-eliminar btn-eliminarlugaresadmin" >Eliminar</button></td>
                                
                            </form>
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
<script>
        function showSuccessMessage(message) {
        var successMessageContainer = document.getElementById('success-message-container');
        var successMessage = document.getElementById('success-message');
        successMessage.textContent = message;
       successMessageContainer.style.display = 'block';
                                
      setTimeout(function() {
     successMessageContainer.style.display = 'none';
            }, 3000);
     }

    document.addEventListener('DOMContentLoaded', function () {
   var errorMessageContainer = document.getElementById('error-message-container');
     if (errorMessageContainer) {
                  setTimeout(function() {
                    errorMessageContainer.style.display = 'none';
            }, 3000);
     }
       });
     </script>
@endsection