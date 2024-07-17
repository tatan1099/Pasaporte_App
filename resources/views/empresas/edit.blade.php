@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container">
        <div class="card-empresa">
            <img class="logo-evaluation" src="{{asset('images/logoUser.png')}}" alt="">
            <div class="card-header align-items-center text-center">
                <h2>Editar usuario - Empresa</h2>
            </div>
            
            <div class="card-body">
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
                <form action="{{ route('empresa.update', $empresa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="input-group mb-3">
                        <label for="floatingInput" class="label">Nombre Empresa</label>
                        <input type="text" class="form-control" id="input-empresa" name="name" required autocomplete="off" autofocus placeholder="Nombre Empresa" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')" value="{{$empresa->name}}">
                    </div>
                
                    <div class="input-group mb-3">
                        <label for="floatingInput" class="label">Correo Electronico</label>
                        <input type="email" class="form-control" id="input-empresa" name="email"
                            value="{{$empresa->email}}">
                    </div>

                            <div class="input-group mb-3">
                    <label for="document" class="label">Documento</label>
                    <input type="text" id="document" name="document" class="form-control input-register" required pattern="[0-9]{6,10}" maxlength="10" placeholder="Documento" value="{{$empresa->document}}">
                </div>

                <div class="input-group mb-3">
                    <label for="phone_number" class="label">Número Telefónico</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control input-register" required pattern="[0-9]{6,10}" maxlength="210" placeholder="Número Telefónico" value="{{$empresa->phone_number}}">
                </div>
                    <div class="row text-center">
                        <div class="col">
                            <button type="submit" class="btn btn-primary" id="btn">Actualizar Usuario</button>
                            <a href="{{route('empresa.index')}}" class="btn btn-primary" id="btn">Volver</a>
                        </div>
                    </div>

                </form>
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