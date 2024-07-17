@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card caja-adminplacecontra">
                    <div class="card-header rojo-textlistplacerestcontra text-center">{{ __('Restablecer contraseña') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="card-header alert alert-success alertaEmailContraseña text-center" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="card-header rojo-textlistplacerestcontra22 text-center">{{ __('Direccion de E-mail') }}</label>
                                <input id="email" type="email" class="form-controlrestcontra @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary restablecontraseña">
                                    {{ __('Restablecer contraseña') }}
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
