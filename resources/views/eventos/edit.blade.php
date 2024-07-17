@section('content')
<body style="background-image: url('{{ asset('images/fondoblanco.png') }}');">
    <div class="container ">
        <div class="card-empresa">
            <img class="logo-evaluation" src="{{asset('images/logoUser.png')}}" alt="">

            <div class="card-header align-items-center text-center">
                <h3>Editar Usuario Evento</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('event.update',$event->id)}}">
                    @method('PUT')
                    @csrf
                    <div class="input-group mb-3">
                        <label for="name" class="label">Nombre</label>
                        <input type="text" id="name" name="name" value="{{$event->name}}" class="form-control" required autocomplete="off" placeholder="Nombre" oninput="this.value = this.value.replace(/^[ ]+|[ ]{2,}/g, '')">
                    </div>

                    <div class="input-group mb-3">
                        <label for="email" class="label">Email</label>
                        <input type="email" id="email" name="email" value="{{$place->email}}" class="form-control" required autocomplete="email" placeholder="Email">
                    </div>

                    <div class="input-group mb-3">
                        <label for="floatingInput" class="label">Dirección</label>
                        <input type="text" id="input-empresa" name="address"
                            value="{{$place->address}}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="floatingInput" class="label">Latitud</label>
                        <input type="text" id="input-empresa" name="latitude"
                            value="{{$place->latitude}}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="floatingInput" class="label">Longitud</label>
                        <input type="text" id="input-empresa" name="length" value="{{$place->length}}">
                    </div>
                    <select id="input-empresa" name="schedule_id" required placeholder="Seleccione un Horario">
                        @foreach($schedules as $schedule)
                        <option value='{{$schedule -> id}}' @if($schedule->id == $place->schedule->id) selected @endif>
                            {{$schedule->day}}, {{$schedule->hour_start}} - {{$schedule->hour_end}}
                        </option>
                        @endforeach
                    </select>
                    <div class="row mt-3 text-center">
                        <div class="col">
                            <button type="submit" class="btn btn-primary" id="btn">Guardar</button>
                            <a href="{{route('places.index')}}" class="btn btn-danger" id="btn">Volver</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

@endsection