@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
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

                    
        <div class="row justify-content-center col-md-8">
                <div class="card caja-admin-RegisterForm">
                    
                        <h2 class="WelcomeRegister h1-md text-center d-md-inline">REGISTRO</h2>
                        <form id="registrationForm" class="moverformregistro" method="POST" action="{{ route('user.store') }}">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control input-register input-registerinicioregistro" required autocomplete="name" autofocus placeholder="Nombres y Apellidos" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                            </div>
                            <div class="mb-3">
                                <input id="document" type="text" class="form-control input-register input-registerinicioregistro" name="document" required minlength="6" maxlength="10" placeholder="Documento" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control input-register input-registerinicioregistro" name="email" required autocomplete="email" placeholder="E-mail">
                            </div>
                            <div class="mb-3">
                                <input id="phone_number" type="text" pattern="\d*" class="form-control input-register input-registerinicioregistro" name="phone_number" required minlength="6" maxlength="10" placeholder="Número de Celular" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control input-register input-registerinicioregistro" name="address" required placeholder="Dirección">
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label form-labelfechana text-wrap" style="color: rgb(143, 35, 58);">Seleccione su fecha de nacimiento</label>
                                <input type="date" class="form-control input-register input-registerinicioregistro" name="birthday" required placeholder="Fecha de Nacimiento" max="{{ date('Y-m-d', strtotime('-18 years')) }}">
                            </div>
                            <div class="mb-3">
                                <select required class="form-control input-register input-registerinicioregistro" id="age" name="age">
                                    <option value="" disabled selected>Seleccione su edad</option>
                                    @for ($i = 18; $i <= 120; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <select required class="form-control input-register input-registerinicioregistro" name="genere">
                                    <option value="" disabled selected>Seleccione su género</option>
                                    <option value="F">Femenino</option>
                                    <option value="M">Masculino</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control input-register input-registerinicioregistro @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Ingrese contraseña, mínimo 8 caracteres">
                            </div>
                            <div class="mb-3">
                                <input id="password-confirm" type="password" class="form-control input-register input-registerinicioregistro" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Contraseña">
                            </div>
                            <span id="password-error" class="error-message mensajeErrorContra"></span>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="privacy_terms" required>
                                <label class="form-check-label" for="privacy_terms">Acepto los términos de privacidad</label>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_company" name="is_company">
                                <label class="form-check-label" for="is_company">Soy una empresa</label>
                            </div>
                            <div class="mb-3">
                                <button  type="submit" class="btn register btn-block  botonregistrarseusaer">
                                    Registrarse
                                </button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</body>
@endsection

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
document.getElementById('registrationForm').addEventListener('submit', function(event) {
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var password = document.querySelector('input[name="password"]');
    var passwordConfirmation = document.querySelector('input[name="password_confirmation"]');
    var passwordError = document.getElementById('password-error');

    function validatePasswords() {
        if (password.value !== passwordConfirmation.value) {
            passwordError.textContent = 'Las contraseñas no coinciden.';
            passwordError.classList.add('error-message');
        } else {
            passwordError.textContent = '';
            passwordError.classList.remove('error-message');
        }
    }

    password.addEventListener('input', validatePasswords);
    passwordConfirmation.addEventListener('input', validatePasswords);
});
</script>
