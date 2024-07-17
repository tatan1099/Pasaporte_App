@extends('layouts.app')

@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container">
        <div class="row">
            <div class="col ">
                <div class="card">
                    <div class="card-header align-items-center text-center">
                        <h1>Usuarios - Empresas</h1>
                    
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre Empresa</th>
                                        <th>Email</th>
                                        <th>Nit</th>
                                        <th>Número Teléfonico</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empresas as $empresa)
                                    <tr>
                                        <td>{{ $empresa->name }}</td>
                                        <td>{{ $empresa->email }}</td>
                                        <td>{{ $empresa->document }}</td>
                                        <td>{{ $empresa->phone_number }}</td>
                                        <td>
                                            <a href="{{ route('empresa.edit', ['empresa' => $empresa->id ])}}"
                                                class="btn btn-primary" id="btn-acciones">Editar</a>
                                        </td>
                                    
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div> 
</body>
@endsection