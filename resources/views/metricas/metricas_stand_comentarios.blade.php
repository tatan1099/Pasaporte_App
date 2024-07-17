@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
        <div class="col-md-8">
            <div class="row">
        <div class="big-card">
        <span class="textoarribar">Comentarios</span>
            <div class="feedback-cards">
                @if ($evaluaciones->isEmpty())
                    <p>No hay comentarios disponibles para este criterio y stand.</p>
                @else
                    @foreach ($evaluaciones as $evaluacion)
                        <div class="feedback-card">
                            <div class="feedback-card-header">
                               <div class="feedback-stars">
                                        <!-- Genera las estrellas rellenas según el puntaje -->
                                        @for ($i = 1; $i <= $evaluacion->rank; $i++)
                                            <img src="{{ asset('images/ICON_ESTRELLA_BLANCO.svg') }}" alt="Estrella llena" class="star-filled" style="width:35px;">
                                        @endfor
                                        
                                        <!-- Genera las estrellas vacías para completar hasta 5 estrellas -->
                                        @for ($i = $evaluacion->rank + 1; $i <= 5; $i++)
                                            <img src="{{ asset('images/ICON_ESTRELLA_BLANCO.svg') }}" alt="Estrella vacía" class="star-empty" style="width: 35px;">
                                        @endfor
                                    </div>

                            </div>
                            <div class="feedback-card-content">
                                 
                               <p class="feedback-comment {{ strlen($evaluacion->feedback) > 20 ? 'long-comment' : '' }}">{{ $evaluacion->feedback }}</p>
                               
                                <p>{{ $evaluacion->user->name }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            @if ($evaluaciones->isEmpty())
                <div class="no-feedback-card">
                    <div class="no-feedback-card-header">
                        <h1 class="no-feedback-card-title">Mensaje de No Hay Comentarios</h1>
                    </div>
                    <div class="no-feedback-card-content">
                        <p>No hay comentarios disponibles para este criterio y stand.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</div>
</body>
    <style>
    /* Estilo para estrella rellena */ 
.star-filled {
     filter: brightness(0) saturate(100%) invert(16%) sepia(80%) saturate(2117%) hue-rotate(327deg) brightness(96%) contrast(92%);
}


/* Estilo para estrella vacía */
.star-empty {
    filter: grayscale(100%);
}
 .long-comment {
            white-space: pre-line; /* Muestra el texto con saltos de línea */
            max-height: 60px; /* Altura máxima antes de mostrar el desbordamiento */
            overflow-y: auto; /* Agrega una barra de desplazamiento vertical si el contenido es demasiado largo */
        }

 .feedback-comment {
            margin-bottom: 5px; /* Espacio entre el comentario y el nombre de usuario */
        }
</style>

@endsection
