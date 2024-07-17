@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="" >


        
        <div class="container-fluid" id="container-login">
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

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card" id="card-login">
                        <div class="card-body">
                            <div class="text-center">
                                @php
                                $logo = \App\Models\Logo::latest()->first(); // Obtener el último logo creado en la base de datos
                                @endphp
                                <div class="logo-inicio00 mx-auto">
                                    @if ($logo)
                                        <img src="{{ asset($logo->logo) }}" alt="Logo" class="img-fluid" height="180px">
                                    @endif
                                </div>
                            </div>
                            <h1 class="listadolugares display-4">
            
                            </h1>       
                            <h5 class="text-center mb-4 login">Pasaporte Virtual</h5>

                            <form method="POST" action="{{ route('login') }}" class="form">
                                @csrf
                                <div class="form-group">
                                    <input id="email" type="email" placeholder="E-mail" class="form-controles @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input id="password" type="password" placeholder="Contraseña" class="form-controles @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-block mt-3 btnplaceslog">
                                        {{ __('Ingresar') }}
                                    </button>
                                </div>

                                @if (Route::has('password.request'))
                                    <div class="form-group text-center display 4">
                                        <a href="{{ route('password.request') }}" class="link">
                                            <span class="contraseñapalabra">¿Has olvidado tu contraseña?</span>
                                        </a>
                                    </div>
                                @endif

                                <div class="form-group text-center">
                                    <div class="social-icons d-flex justify-content-center">
                                        <a href="{{ route('login-google') }}" class="mr-2">
                                            <img src="{{ asset('images/google.png') }}" alt="" class="img-fluid" style="width: 77px; height: 92px;">
                                        </a>
                                        <a href="{{ route('login-facebook') }}">
                                            <img src="{{ asset('images/Facebookk.png') }}" alt="" class="img-fluid" style="width: 46px; height: 46px;">
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <a href="{{ route('register') }}" class="btn btn-secondarylog btn-lg btn-block">
                                        {{ __('Registrarse') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


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