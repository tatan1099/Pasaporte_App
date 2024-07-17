@extends('layouts.app')

@section('content')
<div class="container-fluid containerusuarioempresa">
    <div class="row justify-content-center col-md-8">
<div class="caja-empresausers"> 
<br>
<br>
    <div class="card-empresa">
        <img class="logg-visitadosempresa" src="{{asset('images/Usuario.png')}}" alt="">
        <div class="card-header align-items-center text-center">
        <h1 class="listas-eventosusuarios-empresa">
            <span  class="rojo-crearusuempresaeve textlistplaceUser">EMPRESA</span>
        </h1>
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
            <form action="{{ route('empresa.store') }}" method="POST">
                @csrf
                <div class="mb-3 rounded formcreateempressssa">
                    <input type="text"  name="name" class=" formusuarioempresa" required autocomplete="off" autofocus placeholder="Nombre Empresa" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                </div>

                <div class="mb-3 rounded formcreateempressssa">
                    <input type="email" class="form-control formusuarioempresacorreo" name="email" required autofocus placeholder="Correo Electronico">
                </div>

                <div class="mb-3 rounded formcreateempressssa">
                    <input type="password" id="input-password" name="password" class="form-control formusuarioempresacontraseña" required autocomplete="off" placeholder="Ingrese contraseña,mínimo 8 caracteres" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>

                <div class="mb-3 rounded formcreateempressssa">
                    <input type="text" id="document" name="document" class="form-control formusuarioempresadocumento" required minlength="6" maxlength="10" placeholder="Documento" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div class="mb-3 rounded formcreateempressssa">
                    <input type="text" id="phone_number" name="phone_number" class="form-control formusuarioempresanum" required minlength="6" maxlength="15" placeholder="Número Telefónico" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

              <div>
                    <div class="col accionescreate">
                        <button type="submit" class="createuserem" id="">Crear Usuario</button>
                      //  <button onclick="window.location.href='{{ route('empresas.index') }}'" class="createuseremvolver">Volver</button>
                    </div>
                </div>
                </form>
            </div>
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