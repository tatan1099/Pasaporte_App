<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

@extends('layouts.app')

@section('content')
<div class="large-header">
    <div class="container-fluid" id="container-login">
        <div class="row justify-content-center">
            <div class="col-md-25">
                <div class="card" id="card-login">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}" class="form">
                            @csrf
                            <div class="row mb-3">
                                <!-- <div class="col-md-12 d-flex justify-content-center text-center">
                                @php
                                        $logo = \App\Models\Logo::first(); // Obtener el primer logo almacenado en la base de datos
                                    @endphp
                                    @if ($logo)
                                        <img src="{{ asset($logo->logo) }}" alt="Logo" height="180px" style="margin-top: 16px;">
                                    @else
                                        <img src="{{ asset('images/logo1.png') }}" alt="Logo" height="180px" style="margin-top: 16px;">
                                    @endif                                </div>
                            </div> -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <input id="email" type="email" placeholder="E-mail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="width: 350px;margin-top:50px;margin-left: auto">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <input id="password" type="password" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="width: 350px;margin-left:auto;">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <!-- <div class="row mb-1 justify-content-center">
                                    <div class="col-md-6 offset-md-2">
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                    {{ __('Recuérdame') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->
                                </div>
                            </div>

                            <div class="row mb-0 d-flex justify-content-center text-center">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-secondary text-white" id="btn">
                                        {{ __('Ingresar') }}
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 d-flex justify-content-center text-center">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="link" style="font-size: 20px;margin-top:20px;">
                                            ¿Has olvidado tu contraseña?
                                        </a>
                                    @endif
                                </div>
                            </div>

                                <div class="social-icons">
                                    <div id="google-container">
                                        <a id="link-google" href="{{route('login-google')}}"> 
                                            <img src="{{ asset('images/google.png') }}" alt="" class="google">
                                        </a>
                                    </div>
                                    <div id="facebook-container">
                                        <a id="link-google" href="{{route('login-google')}}"> 
                                            <img src="{{ asset('images/Facebookk.png') }}" alt="" class="facebook">
                                        </a>
                                </div>
                            </div>
                            </div>

                                <div class="row mb-0 d-flex justify-content-center text-center">
                            <div class="col-md-12">
                                <a href="{{ route('register') }}" class="btn btn-secondary text-white" id="btn-register" style="font-size: 17px;">
                                    {{ __('Registrarse') }}
                                </a>
                            </div>
                        </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    @media only screen and (max-width: 2000px) and (max-height: 2340px)  {

.large-header {
    height: 100vh;
}

.large-header::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("{{ asset('images/fondoblanco.png') }}"); /* Ruta de la imagen de fondo */
    background-size: cover;
    background-position: center;
    z-index: -1; /* Asegura que la imagen de fondo esté detrás del contenido */
}
    }
</style> 
@endsection
