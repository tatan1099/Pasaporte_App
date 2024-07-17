<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
</head>    
@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="caja-adminplaceditCREATE mt-2">  
    <div class="card-empresa">
    <div id="success-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: none; z-index: 9999;">
                <div class="alert alert-success" role="alert" style="position: relative;">
                    <span id="success-message"></span>
                </div>
            </div>
        <br>
        <br>
        <br>
        <img class="logo-editplace mx-auto d-block" src="{{asset('images/Lugar.png')}}" alt="">
            <br>
        <div class="text-center">
            <h3 class="registroplaceuserds">EDITAR LUGAR</h3>
        </div>
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
        <div class="card-body">
            <form method="post" action="{{route('places.update',$place->id)}}"class="formularioplace">
                @method('PUT')
                @csrf
                  <div class="mb-3 rounded formplaceregis">
                    <label for="name" class="form-label2">Nombre</label>
                    <input type="text" id="name" name="name" class="form-control anchorselectsplacesedit" value="{{$place->name}}" required autocomplete="name" autofocus placeholder="Nombre" oninput="validateName(this)">
                </div> 

                <div class="mb-3 rounded">
                    <label for="email" class="form-label2">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control anchorselectsplacesedit" value="{{$place->email}}" required autocomplete="email" placeholder="E-mail">
                </div>

                <div class="mb-3 rounded">
                    <label for="floatingInput" class="form-label2">Dirección</label>
                    <input type="text"  name="address" value="{{$place->address}}" class="form-control anchorselectsplacesedit" >
                </div>
                <div class="mb-3 rounded">
                    <label for="floatingInput" class="form-label2">Latitud</label>
                    <input type="text"  name="latitude" class="form-control anchorselectsplacesedit"
                        value="{{$place->latitude}}">
                </div>
                <div class="mb-3 rounded">
                    <label for="floatingInput" class="form-label2">Longitud</label>
                    <input type="text" name="length" value="{{$place->length}}" class="form-control anchorselectsplacesedit">
                </div>
                <div class="mb-3 rounded">
                <label for="floatingInput" class="form-label2">Horario</label>
                <select name="schedule_id" required placeholder="Seleccione un Horario" class="form-select horeriolugareditar">
                    @foreach($schedules as $schedule)
                    <option value='{{$schedule -> id}}' @if($schedule->id == $place->schedule->id) selected @endif>
                        {{$schedule->day}}, {{$schedule->hour_start}} - {{$schedule->hour_end}}
                    </option>
                    @endforeach
                </select>
                </div>
                <div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary" id="botonneditar">Guardar</button>
                        <button type="button" onclick="window.location.href='{{route('places.index')}}'" class="btn btn-primary" id="botonneditar">Volver</button>

                    </div>
                </div>
   
            </form>
        </div>
    </div>
</div>
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