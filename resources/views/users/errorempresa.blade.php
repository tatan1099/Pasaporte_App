@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mensaje de Activación</title>
<link rel="stylesheet" href="{{ asset('css/styles.css') }}"> <!-- Enlaza tu archivo CSS externo -->
</head>
<body>
    
<div class="activation-message-container">
    <div class="activation-message"> <!-- Contenedor para las palabras -->
    <div id="container">
  <div id="">
  </div>
  <div id="error-box">
    <div class="face2">
      <div class="eye"></div>
      <div class="eye right"></div>
      <div class="mouth sad"></div>
    </div>
    <div class="shadow move"></div>
    
  </div>
</div>
        <p class="tituloempresanoacti">Usted no ha sido activado para ingresar al sistema.</p>
        <p class="colornoactivda">¡Por favor, esperé a ser activado por un administrador para poder acceder al sistema!</p>
    </div>
</div>
</body>
</html>
@endsection