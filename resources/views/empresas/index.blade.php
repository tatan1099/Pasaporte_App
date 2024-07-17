@extends('layouts.app')
@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container-fluid">
        <div class="card-header align-items-center text-center">
        </div>
        <div class="card-body">
        <div class="caja-adminusersempresas">
            <img class="logg-visitadosempresausuarioss mx-auto img-fluid" src="{{asset('images/Empresa.png')}}" alt="">
            <h1 class="tituloempresassindex display-4"><span class="titulousersempresasss d-md-inline">EMPRESAS</span></h1>
            <a href="{{ route('empresa.create') }}" class="usuario-empresa   btn btn-primary">Crear empresa</a>
            <div class="tablees-responsive  tableempresasindex">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th scope="col" class="borde-redondeadonombreempresa">Nombre Empresa</th>
                            <th scope="col" class="itemsemailempresausuaio">Email</th>
                            <th scope="col" class="itemsnitempresausuaio">Nit</th>
                            <th scope="col"  class="itemsnnumerodetelefonoempresausuaio">Número Teléfonico</th>
                            {{-- <th scope="col" class="estilo-borde-redondeadousersempresa">Acciones</th> --}}
                            <th scope="col" class="estilo">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr> 
                                <td data-titulo="Nombre">{{ $empresa->name }}<hr class="lineas"></td>
                                <td data-titulo="Email">{{ $empresa->email }}<hr class="lineas"></td>
                                <td data-titulo="Documento">{{ $empresa->document }}<hr class="lineas docuempresausuario"></td>
                                <td data-titulo="Numero de telefono">{{ $empresa->phone_number }}<hr class="lineas"></td>
                                <td>
                                    <form id="formeventos" action="{{route('Empresa.user.edits', ['id' => $empresa->id]) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn posiconboton "
                                        id="btn-acciones ">Editar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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