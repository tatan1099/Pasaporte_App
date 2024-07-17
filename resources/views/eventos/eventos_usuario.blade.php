@extends('layouts.app')
@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class=" containereventosdeladmineventos container-fluid ">
    
            <div class="caja-eventosexistentesusuario "> 
                <img class="logo-eventosexistentesdeladmin mx-auto" src="{{asset('images/Evento.png')}}" alt="">
                    <br></br>
                    <h1><span class="gray-texteventosexistentesadmin d-md-inline">EVENTOS</span></h1>
                @csrf
                    <div class="tableusuarioseventosadmin-responsive tableeventousuario">
                        <table>
                            <thead>
                                <tr>
                                    <th style="display: none;">ID</th>
                                    <th scope="col" class="borde-redondeadonombreusuarioeventadmin">Nombre</th>
                                    <th scope="col" class="itemsdescrieventoadminusuario ">Descripción</th>
                                    <th scope="col"  class="borde-redondeadoaccioneseventoadminusuario">Acciones</th>
                                    
                                </tr>
                            </thead>
                        </table>
                            <table class="tableusuarioeventoadmin tableusariosadmineventos">
                                <tbody>
                                    @foreach ($eventos as $evento)
                                    <tr>
                                        <td style="display: none;">{{ $evento->id }}</td>
                                        <td data-titulo="Nombre del Evento:" style="color: black;">{{ $evento->name }}<hr class="lineas"></td>
                                        <td data-titulo="Descripción:" >{{ $evento->description }}<hr class="lineas"></td>
                                        <td>
                                            <a href="{{ route('UserEvent.standsevent',$evento->id) }}" class="btn btn-danger btn-block"  id="accionesadmineventosuaurios"> Stands</a>
                                            <a href="{{ route('UserEvent.eventosdetalle', $evento->id) }}" class="btn btn-danger btn-block"  id="accionesadmineventosuaurios">Detalles</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                    </div>
            </div>
    </div>
</body>

                
        
@endsection