@extends('layouts.app')
@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
<div class="container-fluid ">
    <div class="row">
        <div class="col-md-8">
        <div class="align-items-center text-center">
            <div class="card-body d-flex">
                <div class="caja-adminlogovistadmin">
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
                
                    <img class="logo-logo mx-auto" src="{{asset('images/Logo.png')}}" alt="">        
                    
                    <span class="grayy-texto cargartextlogo  d-inline">CARGAR</span>
                
                    <span class="red-text  Nuevologotext d-inline" >NUEVO LOGO</span>
                   
                     
                    <br>
                    <br>
                    <br>
                    <div class="col-md-8">
                    <form method="post" action="{{route('logo.store')}}" method="POST" enctype="multipart/form-data">  
                        @csrf
                        <label for="logo" class="form-label00 label-register">Logo URL</label>
                        
                        
                            <input type="file" class="form-controllogo logoimages form-control" id="logo" name="logo" accept="image/*" required>
                        
                        
                        <button type="submit" class="btn-block btn btn-success botonlogo">Enviar</button>
                    </form>
                    
                </div>
            </div>
            <div>
            </div>
            </div>
        
</body>
    <script>
        document.getElementById('logo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const maxSizeInBytes = 3 * 1024 * 1024; // 3 MB en bytes

            if (file && file.size > maxSizeInBytes) {
                event.target.value = ''; // Limpiar el valor del input si el archivo es demasiado grande
                alert('El tamaño del archivo excede el límite de 3MB.');
            }
        });
    </script>
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
        }, 15000);
    }
</script>

@endsection