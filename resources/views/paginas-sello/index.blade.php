@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Passport Registrado</h1>
            </div>
            <div class="card-body">
                <img src="{{ asset('storage/videos/Animación_sello_gif.gif') }}" alt="GIF PASAPORTE"> 
            </div>
        </div>      
    </div>
</body>
    <script>
    setTimeout(function() {
        window.location.href = '/passport';
    }, 4000);
</script>
@endsection