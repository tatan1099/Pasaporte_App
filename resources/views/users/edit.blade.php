@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="containereditaruseradmin col-12 col-md-8">
            <div class="caja-adminE">
                <div class="row text-center">
                    <div class="col-12">
                        <span class="StandEdite-heading editar">EDITAR USUARIO</span>
                    </div>
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
                    <form method="post" action="@if(auth()->user()->hasRole('Administrador')) {{ route('user.update', $user->id) }} @elseif(auth()->user()->hasRole('Empresa')) {{ route('user.updates', $user->id) }} @elseif(auth()->user()->hasRole('Evento')) {{ route('user.updatess', $user->id) }} @endif">
                        @method('PUT')
                        @csrf

                        <div class="input-group mb-3">
                            <span class="input-group-text">Nombre y Apellido</span>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Documento</span>
                            <input type="text" class="form-control" name="document" value="{{ $user->document }}" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Email</span>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Número de celular</span>
                            <input type="text" class="form-control" name="phone" value="{{ $user->phone_number }}" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Dirección</span>
                            <input type="text" class="form-control" name="address" value="{{ $user->address }}" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Fecha de nacimiento</span>
                            <input type="date" class="form-control" name="birthday" value="{{ $user->birthday }}" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Género</span>
                            <select class="form-select select-ageeditarr" name="genere" required>
                                <option value="F" {{ $user->genere === 'F' ? 'selected' : '' }}>Femenino</option>
                                <option value="M" {{ $user->genere === 'M' ? 'selected' : '' }}>Masculino</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Edad</span>
                            <select class="form-select select-ageeditarr" name="age" required>
                                @for ($i = 18; $i <= 120; $i++)
                                    <option value="{{ $i }}" {{ $user->age == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Nueva Contraseña</span>
                            <input type="password" class="form-control" name="password" placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Confirmar Contraseña</span>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar contraseña">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary Btn-guardareditaruserss">Guardar</button>
                            <a href="@if(auth()->user()->hasRole('Administrador')) {{ route('user.listarusuarios') }}  @elseif(auth()->user()->hasRole('Empresa')) {{ route('empresa.inicio') }}  @elseif(auth()->user()->hasRole('Evento')) {{ route('empresas.index') }} @endif" class="btn btn-secondary btn-volverdetodaslas">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const birthdayInput = document.querySelector('input[name="birthday"]');
        const today = new Date();
        const minAge = 18;
        const maxAge = 120;
        const minDate = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate());
        const maxDate = new Date(today.getFullYear() - maxAge, today.getMonth(), today.getDate());
        const minDateString = minDate.toISOString().split('T')[0];
        const maxDateString = maxDate.toISOString().split('T')[0];
        birthdayInput.setAttribute('min', maxDateString);
        birthdayInput.setAttribute('max', minDateString);
    });
</script>
<script>
    function showSuccessMessage(message) {
        const successMessageContainer = document.getElementById('success-message-container');
        const successMessage = document.getElementById('success-message');
        successMessage.textContent = message;
        successMessageContainer.style.display = 'block';
        setTimeout(function() {
            successMessageContainer.style.display = 'none';
        }, 3000);
    }
    document.addEventListener('DOMContentLoaded', function () {
        const errorMessageContainer = document.getElementById('error-message-container');
        if (errorMessageContainer) {
            setTimeout(function() {
                errorMessageContainer.style.display = 'none';
            }, 3000);
        }
    });
</script>
<script>
    function showErrorMessage(message) {
        const errorMessageContainer = document.getElementById('error-message-container');
        const errorMessageElement = document.getElementById('error-message');
        errorMessageElement.innerHTML = message;
        errorMessageContainer.style.display = 'block';
        setTimeout(function () {
            errorMessageContainer.style.display = 'none';
        }, 3000);
    }
</script>
<script>
    const documentInput = document.getElementById('document');
    documentInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var password = document.getElementById('passwordInput');
        var confirmPassword = document.getElementById('confirmPasswordInput');
        var passwordError = document.getElementById('password-error');

        function validatePasswords() {
            if (confirmPassword.value && password.value !== confirmPassword.value) {
                passwordError.textContent = 'Las contraseñas no coinciden.';
            } else {
                passwordError.textContent = '';
            }
        }

        confirmPassword.addEventListener('input', validatePasswords);
    });
</script>
@endsection