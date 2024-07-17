<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pasaporte Virtual</title>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
     <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
    <!-- <script src="{{ asset('apexcharts-bundle/dist/apexcharts.js')}}"></script> -->
    <script src="/apexcharts-bundle/dist/apexcharts.min.js"></script>
    <script src="{{ asset('js/scanner.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="header"></div>
  <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu" style="width: 0px;">
  <div id="sidebarMenu">
  <div class="col-md-12 d-flex justify-content-center text-center">
                                    @php
                                    $logo = \App\Models\Logo::latest()->first(); // Obtener el último logo creado en la base de datos
                                    @endphp
                                    <div class="logo-inicio">
                                        @if ($logo)
                                            <img src="{{ asset($logo->logo) }}" alt="Logo" height="180px">
                                        @else
                                            <img src="{{ asset('images/logo1.png') }}" alt="Logo" height="180px" style="margin-top: 16px;">
                                        @endif
                                    </div>    
                                </div>
  <label for="openSidebarMenu" class="sidebarIconToggle">
    <div class="spinner diagonal part-2"></div>
  </label>
    <ul class="sidebarMenuInner">
                        @auth
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('eventos.listaEventos') }}">|<span style= "margin-left: 15px; font-size: 12px;">INICIO</a>
                        </li> -->
                        <!--Menu para el visitante-->
                        @php
                        $mostrarMenu = \Auth::user()->hasRole('Visitante');
                        @endphp
                        @if($mostrarMenu)
                        <li class="sidebarMenuInner">
                            <a class="nav-link" href="{{ route('eventos.listaEventos') }}" style="color: white; font-size: 18px; margin-left: 5px; margin-top: -3px;">Inicio</a>
                        </li>
                        <hr class="linea">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('qr-scanner')}}">Escanear Qr</a>
                        </li>  
                        <hr class="linea">                       
                        @endif
                        @endauth
                        
                        <!--Menu para el admin-->
                        @auth
                        @php
                        $mostrarMenuAdmin = \Auth::user()->hasRole('Administrador');
                        @endphp 
                        @if($mostrarMenuAdmin)
                        <li class="">
                            <a class="admin" href="{{ route('eventos.index') }}">EVENTOS</span></a>
                        </li>
                        <hr class="linea">
                        <li class="">
                            <a class="dropdown-item" href="{{ route('places.index') }}">LUGARES</span></a>
                        </li>
                        <hr class="linea">
                        <li class="">
                            <a class="dropdown-item" href="{{ route('user.listarusuarios') }}">USUARIOS</a>
                        </li>
                        <hr class="linea">
                        <li class="">
                            <a class="dropdown-item" href="{{ route('logo.create') }}">LOGO</a>
                        </li>
                        <hr class="linea">
                        <li class="">
                            <a class="dropdown-item" href="{{ route('user.empresasnoactivadas') }}"style="margin-left:-37px;">Activar Empresas</a>
                        </li>
                        <hr class="linea">
                        @endif
                        @endauth
                        <!--Menu para la empresa-->
                        @auth
                        @php
                        $user = \Auth::user();
                        $mostrarMenuEmpresa = $user->hasRole('Empresa') && $user->Empresa_verificada;
                        @endphp
                        @if($mostrarMenuEmpresa)
                        <li class="nav-item">
                         <a class="" href="{{ route('stand.index') }}" style="margin-top:330px;margin-left:20px;">Gestionar Stand</a>                               
                        </li>
                        <hr class="linea">
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="{{ route('user.editse',['id'=>$user->id]) }}">Perfil</a> -->
                        </li>
                        <hr class="linea">
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"style="margin-left:20px">Registrarse</a>
                        </li>
                        <hr class="linea">
                        @endif
                        @endauth
                        <!--Menu para el evento-->
                        @auth
                        @php
                        $mostrarMenuEvento = \Auth::user()->hasRole('Evento');
                        @endphp
                        @if($mostrarMenuEvento)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('empresas.index') }}">Gestionar Empresa</a>
                        </li>
                       
                        <hr class="linea">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('places.index') }}">Lugares</a>
                        </li>
                        <hr class="linea">
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('UserEvent.listaeventos') }}">Evento</a>
                        </li>
                        <hr>
                        @endif
                        @endauth
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        
                            @if (Route::has('login'))
                                    <li><a class="dropdown-item" href="{{ route('login') }}">Entrar</a></li>
                                    @endif
                                    <hr>
                                    @if (Route::has('register'))
                                    <li><a class="dropdown-item" href="{{ route('register') }}">Registro</a></li>
                                    @endif
                                    <hr>
                                    @if (Route::has('invitados.create'))
                                    <li><a class="dropdown-item" href="{{ route('invitados.create') }}">Entrar sin <br> registro</a></li>
                                    @endif
                                    <hr>
                                </ul>
                            </div>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span class="{{ Auth::user()->hasRole('Administrador') ? 'admin-name' : (Auth::user()->hasRole('Visitante') ? 'visitor-name' : (Auth::user()->hasRole('Empresa') ? 'company-name' : 'event-name')) }}">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="" aria-labelledby="navbarDropdown" style="background-color: rgb(143, 35, 58);">
                        <a class="dropdown-item" href="http://127.0.0.1:8000/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-left: 29px;margin-top: 13px;background-color:rgb(176, 77, 105);border-radius:20px;">Salir</a>                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </div>
                            <hr style="border-color:#e57207; margin-top: 23px; margin-left:-6px;width:271px;">
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
            </ul>
    </div>        
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
        <main class="">
            @yield('custom-padding')
        </main>    
    </div>
</body>
</html>
