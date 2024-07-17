<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <div class="card">
        <div class="card-header">
            <h1>Usuarios Registrados</h1>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Documento</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Fecha de nacimiento</th>
                        <th scope="col">Género</th>
                        <th scope="col">Rol</th>

                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->document}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone_number}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->birthday}}</td>
                        <td>{{$user->genere}}</td>
                        <td>{{$user->rol->name}}</td>
                        <td><a href="{{route('user.edit',$user->id)}}" class="btn btn-primary">Editar</a></td>
                        <form method="post" action="{{route('user.destroy',$user->id)}}">
                            @method('DELETE')
                            @csrf
                            <td><button type="submit" class="btn btn-danger">Eliminar</button></td>
                        </form>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
        
    </div>
</body>
</html>