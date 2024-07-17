@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
    <div class="caja-admincalifi">
        <div class="card-bodyC">
            
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
        <h2 class="Calificacionr">Califica</h2>
            <span class="textoarribarcal">Tu experiencia</span>
            
            <form method="POST" action="{{ route('guardar_calificacion') }}">
                @csrf
                {{-- Recorremos los criterios y mostramos los campos de calificación y feedback --}}
                @foreach($criterios as $criterio)
                <div class="">
                    <div class="ratingcali">
                        <div class="criterio-rating">
                            <label>{{ $criterio->name }}:</label>
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                <input type="radio" id="criterio_{{ $criterio->id }}_{{ $i }}" name="criterios[{{ $criterio->id }}][rank]" value="{{ $i }}" class="criterioStar_1">
                                <label class="star" for="criterio_{{ $criterio->id }}_{{ $i }}"><img src="{{ asset('images/ICON_ESTRELLA_BLANCO.svg') }}" alt="Icono de estrella"></label>
                                @endfor
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn feedback-btn" data-target="{{ $criterio->id }}">Comentario</button>
                </div>
                <div class="">
                <textarea class="feedback-textarea" data-target="{{ $criterio->id }}" name="feedback[{{ $criterio->id }}][feedback]" placeholder="Feedback para {{ $criterio->name }}"></textarea>
                </div>       
                @endforeach
                @if($stand)
                        <input type="hidden" name="standid" value="{{ $stand->id }}">
                    @else
                        <p>El stand no fue encontrado.</p>
                    @endif
                <button class="btn-enviar" type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>


    <style>
.star img {
    width: 30px; /* Ajusta el ancho de las estrellas según sea necesario */
    height: 30px; /* Ajusta la altura de las estrellas según sea necesario */
}

.star.checked img {
    filter: brightness(0) saturate(100%) invert(16%) sepia(80%) saturate(2117%) hue-rotate(327deg) brightness(96%) contrast(92%);
}
</style>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const criteriosContainers = document.querySelectorAll(".ratingcali");

    criteriosContainers.forEach(function(criterioContainer) {
        const stars = criterioContainer.querySelectorAll(".star");
        const rankField = criterioContainer.querySelector('[name^="criterios["][name$="[rank]"]');

        stars.forEach(function (star, index) {
            star.addEventListener("click", function () {
                const rating = index + 1;
                console.log("Rating seleccionado:", rating); // Verifica el valor de rating en la consola
                stars.forEach(function(star, i) {
                    star.classList.toggle("checked", i < rating);
                });
                rankField.value = rating; // Actualiza el valor del campo oculto
            });
        });
    });
});

$(document).ready(function () {
    $('.feedback-btn').click(function () {
        var targetId = $(this).data('target');
        $('.feedback-textarea[data-target="' + targetId + '"]').toggle(); // Modificado
    });
});
</script>
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
    // Función para mostrar el mensaje de éxito
    function showSuccessMessage(message) {
        const successMessageContainer = document.getElementById('error-message-container');
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
