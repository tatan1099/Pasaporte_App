@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
    <div class="caja-adminplaceditCREATErest mt-2">  
        <div class="card-empresa Card-reset-password">
        <div id="success-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: none; z-index: 9999;">
                    <div class="alert alert-success" role="alert" style="position: relative;">
                        <span id="success-message"></span>
                    </div>
                </div>
            <br>
            <br>
            <br>
            <img class="logo-editplacerest mx-auto d-block" src="{{asset('images/Usuario.png')}}" alt="">
                <br>
            <div class="text-center">
                <h3 class="resetpasword">RESTABLECER CONTRASEÑA</h3>
            </div>
            <div id="success-message-container" class="position-fixed top-0 start-50 translate-middle-x text-center" style="display: none; z-index: 9999;">
                    <div class="alert alert-success" role="alert" style="position: relative;">
                        <span id="success-message"></span>
                    </div>
                </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="text-center2">
                            <div class="registroplaceuserdsAB d-md-inline">
                                <label for="email" class="col-form-label text-md-end labelresetcontraseña">{{ __('Correo electronico') }}</label>
                            </div>
                                <div class="mb-3 rounded formplaceregis form-resettpassword">
                                    <input id="email" type="email" class="form-control position @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        

                                <div class="">
                                    <div class="registroplaceuserdsAB d-md-inline">
                                    <label for="password" class="col-form-label text-md-end labelresetcontraseña">{{ __('Contraseña') }}</label>
                                </div>
                                <div class="mb-3 rounded formplaceregis">
                                    <input id="password" type="password" class="form-control position @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback mensajeerrorresetcon" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="">
                                <div class="registroplaceuserdsABb d-md-inline">
                                    <label for="password-confirm" class="col-form-label text-md-end labelresetcontraseña">{{ __('Confirmar contraseña') }}</label>
                            </div>
                                <div class="mb-3 rounded formplaceregis">
                                    <input id="password-confirm" type="password" class="form-control position" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-cambiarcontraseñareset">
                                        {{ __('Cambiar contraseña') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
@endsection
