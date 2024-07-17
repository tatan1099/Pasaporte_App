<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid ">
        <div class="caja-adminplacedit mt-5">
            <div class="carta-empresaplacesusers">
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
                <img class="logos-evaluationregistro mx-auto d-block" src="{{asset('images/Lugar.png')}}" alt="">
                <br>
                <div class="text-center">
                    <h3 class="registroplace ">REGISTRO DE LUGARES</h3>
                </div>

                <div class="card-body">
                    <form method="post" action="{{route('places.store')}}">
                        @csrf

                        <div class="mb-3 rounded formplaceregis formplaceregiscreate">
                            <input type="text" id="name" name="name" class="form-control" required autocomplete="off" autofocus placeholder="Nombre" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                        </div>

                        <div class="mb-3 rounded formplaceregis formplaceregiscreate">
                            <input type="email" id="email" name="email" class="form-control" required autocomplete="email" placeholder="E-mail">
                        </div>

                        <div class="mb-3 rounded formplaceregis formplaceregiscreate">
                            <input class="form-control" type="text" name="address" required placeholder="Dirección">
                        </div>

                        <div class="mb-3 rounded formplaceregis formplaceregiscreate">
                            <input type="text" name="latitude" required class="form-control" placeholder="Latitud">
                        </div>

                        <div class="mb-3 rounded formplaceregis formplaceregiscreate">
                            <input type="text" name="length" required class="form-control" placeholder="Longitud">
                        </div>

                        <div class="mb-3 rounded formplaceregis formplaceregiscreate">
                            <select name="schedule_id" required class="form-select posiciondelselectplacencreat">
                                <option value="" disabled selected>Seleccione un Horario</option>
                                @foreach($schedules as $schedule)
                                <option value='{{$schedule->id}}'>{{$schedule->day}}, {{$schedule->hour_start}} - {{$schedule->hour_end}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                                <button type="submit" class="btn btn-primary btnRegistrarplacecreate" id="botonneditar">Registrar</button>
                                <button type="button" onclick="window.location.href='{{route('places.index')}}'" class="btn btn-primary btnvolverplacecreateadmin" id="botonneditar">Volver</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
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

    document.addEventListener('DOMContentLoaded', function() {
        var errorMessageContainer = document.getElementById('error-message-container');
        if (errorMessageContainer) {
            setTimeout(function() {
                errorMessageContainer.style.display = 'none';
            }, 3000);
        }
    });
</script>
@endsection
