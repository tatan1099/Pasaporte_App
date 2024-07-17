@extends('layouts.app')
@section('content')
<div class="container-fluid">
<div class="crearusuarioeventosadmin">
<div class="caja-crearusuarioevento " >  
    <div class="card-empresa">
        <br>
        <br>
        <br>
        <img class="logos-crearusuarioadminevent" src="{{asset('images/Usuario.png')}}" alt="" >
        <br>
        <div class=" align-items-center text-center">    
            <h3 ><span class="titulocrearusuarioadmin">CREAR ADMIN - EVENTO</span></h3>
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
            <form action="{{ route('eventos.store') }}" method="POST">
                @csrf
                 <div class="mb-8 rounded">
                    <label for="name" class="form-labelnameeven">Nombre Evento</label>
                    <input type="text" id="name" name="name" class="form-controlnameeven" required autocomplete="off" placeholder="Nombre del evento" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                </div>  

                <div class="mb-8 rounded">
                    <label for="email" class="form-labelcorreoele">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-controlemail" required placeholder="Correo electrónico">
                </div>

                <div class="mb-8 rounded">
                    <label for="password" class="form-labelcontra">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-controlpassword" required placeholder="Contraseña" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>


                <div class="mb-8 rounded">
                    <label for="document" class="form-labeldoc">Documento</label>
                    <input type="text" id="document" name="document" class="form-controldoc" required minlength="6" maxlength="10" placeholder="Documento" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div class="mb-8 rounded">
                    <label for="number" class="form-labeltel">Número Telefónico</label>
                    <input type="tel" id="number" name="phone_number" class="form-controltel" required placeholder="Número telefónico" pattern="\d*" minlength="6" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
<br>
                <div class="mb-8 rounded">
                <label for="multi_evento" class="form-labelmultieven textocrearamasde">¿El administrador creará mas de 1 evento?</label>
                <input type="checkbox" class="checkbox" id="multi_evento" name="multi_evento" value="1">
                </div>
              
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-Crear-UsuarioEventoo" >Crear Usuario</button>
                    <a href="{{route('eventos.index')}}" class="btn btn-primary btn-volverEventoo" >Volver</a>
             </div>
            </form>
        </div>
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
    <script>
        document.getElementById('{{ route('eventos.store') }}').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe automáticamente

            var email = document.getElementsByName('email')[0].value; // Obtiene el valor del campo de correo electrónico por su nombre

            // Realiza una solicitud AJAX para verificar si el correo electrónico ya existe
            fetch('{{ route('check.email') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    alert('El correo electrónico ya está en uso. Por favor, utiliza otro.');
                } else {
                    // Si el correo electrónico no existe, envía el formulario
                    document.getElementById('registrationForm').submit();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>

@endsection