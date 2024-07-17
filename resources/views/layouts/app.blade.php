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
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href="/node_modules/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
<nav class="">
   
        <span class="open-slide">
            <a href="#" onclick="toggleSlideMenu()">
                <label for="openSidebarMenu" class="sidebarIconToggle">
                <div class='iconarrow'><i class='iconarrow bx bxs-right-arrow bx-lg' style='color:#e57207'></i></div>
                </label>
            </a>
        </span>
    </nav>
    <div id="side-menu" class="side-nav">
    <a href="" onclick="closeSlideMenu()"></a>  
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
                        <ul class="sidebarMenuInner">                       
                        @auth
                        @php
                        $mostrarMenu = \Auth::user()->hasRole('Visitante');
                        @endphp
                        @if($mostrarMenu)
                        <li class="eventoadmin00">
                            <a class="nav-linklayaoutini" href="{{ route('eventos.listaEventos') }}">Inicio</a>
                        </li>
                        <hr class="linea">
                        <li class="eventoadmin00">
                            <a class="nav-link" href="{{route('qr-scanner')}}">Escanear Qr</a>
                            <hr class="lineaescanearqr">
                        </li>                                          
                        @endif
                        @endauth
                         <!--Menu para el admin-->
                        @auth
                        @php
                        $mostrarMenuAdmin = \Auth::user()->hasRole('Administrador');
                        @endphp 
                        @if($mostrarMenuAdmin)
                        <li class="eventoadmin00">
                            <a class="admin" href="{{ route('eventos.index') }}">Eventos</span></a>
                        </li>
                        <hr class="linea">
                        <li class="eventoadmin00">
                            <a class="dropdown-item" href="{{ route('places.index') }}">Lugares</span></a>
                        </li>
                        <hr class="linea">
                        <li class="eventoadmin00">
                            <a class="dropdown-item" href="{{ route('user.listarusuarios') }}">Usuarios</a>
                        </li>
                        <hr class="linea">
                        <li class="eventoadmin00">
                            <a class="dropdown-item" href="{{ route('logo.create') }}">Logo</a>
                        </li>
                        <hr class="lineaempresaactivlogo">
                        <li class="eventoadmin00">
                            <a class="dropdown-item" href="{{ route('user.empresasnoactivadas') }}"style="margin-left:-37px;">Activar Empresas</a>
                            
                        </li>
                        <hr class="lineaempresaactiv">        
                        @endif
                        @endauth
                        
                        @auth
                        @php
                        $user = \Auth::user();
                        $mostrarMenuEmpresa = $user->hasRole('Empresa') && $user->Empresa_verificada;
                        @endphp
                        @if($mostrarMenuEmpresa)
                        <li class="nav-item">
                         <a class="gestionarstandss00" href="{{ route('stand.index') }}">Gestionar Stand</a>                               
                        </li>
                        <hr class="linea">
                        <li class="eventoadmin00">
                            <a class="nav-link" href="{{ route('Empresa.user.edit', $user->id) }}">Editar Empresa</a>
                            <hr class="lineaempresaactivlogoempresa">
                        </li>                                                                 
                        @endif
                        @endauth
                        <!--Menu para el evento-->
                        @auth
                        @php
                        $mostrarMenuEvento = \Auth::user()->hasRole('Evento');
                        @endphp
                        @if($mostrarMenuEvento)
                        <li class="eventoadmin00">
                            <a class="nav-link" href="{{ route('empresas.index') }}">Gestionar Empresa</a>
                        </li>                       
                        <hr class="linea">
                        <li class="eventoadmin00">
                            <a class="nav-link" href="{{ route('places.index') }}">Lugares</a>
                        </li>
                        <hr class="linea">
                        <li class="eventoadmin00">
                        <a class="nav-link" href="{{ route('UserEvent.listaeventos') }}">Eventos</a>
                        </li>
                        <hr class="linea">
                        <li class="eventoadmin00">
                            <a class="dropdown-item" href="{{ route('empresasnoactivadas') }}"style="margin-left:-37px;">Activar Empresas</a>
                            
                        </li>
                        <hr class="lineaempresaactiv">
                        @endif
                        @endauth
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        
                            @if (Route::has('login'))
                                    <li><a class="eventoadmin00" href="{{ route('login') }}">Entrar</a></li>
                                    @endif
                                    <hr class="linea">
                                    @if (Route::has('register'))
                                    <li><a class="eventoadmin00" href="{{ route('registroes') }}">Registro</a></li>
                                    @endif
                                    <hr class="linea">
                                    @if (Route::has('invitados.create'))
                                    <li><a class="eventoadmin00" href="{{ route('invitados.create') }}">Entrar sin <br> registro</a></li>
                                    <hr class="lineaempresaactivlogo">
                                    @endif
                            </div>
                        </li>
                        @endif
                           
                        @else
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="contenidol">
                                
                        <span>{{ Auth::user()->name }}</span>
                       
                       </div>


                       <li class="nav-item">
    <div class="d-flex justify-content-center align-items-center" aria-labelledby="navbarDropdown" style="background-color: rgb(143, 35, 58); margin-top: auto;">
        <a class="btn btnsalir" href="http://127.0.0.1:8000/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-size: 14px;">Salir</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</li>


                        @endguest
                   
                        </div>
                        <div id="main">
        <main class="py-4">
            @yield('content')
        </main>
        <main class="">
            @yield('contenido')
        </main>
        
    </div>  
    <script>
    // Script para dispositivos de escritorio
    if (window.matchMedia && window.matchMedia('(min-width: 576px)').matches) {
        var scrollPosition = 0;
        function toggleSlideMenu() {
            var sideMenu = document.getElementById('side-menu');
            var mainContent = document.getElementById('main');
            if (sideMenu.style.width === '250px') {
                closeSlideMenu(mainContent);
            } else {
                openSlideMenu(mainContent);
            }
            moveTriangle(); // Llama a la función para mover el triángulo
        }

        function openSlideMenu(mainContent) {
            scrollPosition = window.scrollY || window.pageYOffset;
            document.getElementById('side-menu').style.width = '250px';
            mainContent.style.marginLeft = '80px'; // Ajusta el margen izquierdo del contenido principal
            mainContent.style.transition = "margin-left 0.3s ease";
            moveTriangle(); // Llama a la función para mover el triángulo
        }

        function closeSlideMenu(mainContent) {
            document.getElementById('side-menu').style.width = '0';
            mainContent.style.marginLeft = '0'; // Restaura el margen izquierdo del contenido principal
            mainContent.style.transition = "margin-left 0.3s ease"; 
            document.body.style.overflowY = 'auto'; // Restaura el desplazamiento vertical en el body
            window.scrollTo(0, scrollPosition); 
            moveTriangle(); // Llama a la función para mover el triángulo
        }

        function moveTriangle() {
            var triangle = document.querySelector('.iconarrow i');
            var sideMenuWidth = parseInt(document.getElementById('side-menu').style.width);
            if (sideMenuWidth === 0) {
                triangle.style.transform = 'rotate(0deg)'; // Gira el icono hacia la izquierda cuando se abre el sidebar
                triangle.style.left = '5px'; // Mueve el triángulo hacia la izquierda cuando el menú está cerrado
                triangle.style.marginLeft = '1.2vh';
            } else {
                triangle.style.left = '36px'; // Mueve el triángulo hacia la derecha cuando el menú está abierto
                triangle.style.marginLeft = '16.6vh';
            }
        }
    }
</script>

<script>
    // Script para dispositivos móviles
    if (window.matchMedia && window.matchMedia('(max-width: 575px)').matches) {
        var scrollPosition = 0;
        function toggleSlideMenu() {
            var sideMenu = document.getElementById('side-menu');
            var mainContent = document.getElementById('main');
            if (sideMenu.style.width === '250px') {
                closeSlideMenu(mainContent);
            } else {
                openSlideMenu(mainContent);
            }
            moveTriangle(); // Llama a la función para mover el triángulo
        }

        function openSlideMenu(mainContent) {
            scrollPosition = window.scrollY || window.pageYOffset;
            document.getElementById('side-menu').style.width = '250px';
            mainContent.style.marginLeft = '240px'; // Ajusta el margen izquierdo del contenido principal
            mainContent.style.transition = "margin-left 0.3s ease";
            moveTriangle(); // Llama a la función para mover el triángulo
        }

        function closeSlideMenu(mainContent) {
            document.getElementById('side-menu').style.width = '0';
            mainContent.style.marginLeft = '0'; // Restaura el margen izquierdo del contenido principal
            mainContent.style.transition = "margin-left 0.3s ease"; 
            document.body.style.overflowY = 'auto'; // Restaura el desplazamiento vertical en el body
            window.scrollTo(0, scrollPosition); 
            moveTriangle(); // Llama a la función para mover el triángulo
        }

        function moveTriangle() {
            var triangle = document.querySelector('.iconarrow i');
            var sideMenuWidth = parseInt(document.getElementById('side-menu').style.width);
            if (sideMenuWidth === 0) {
                triangle.style.transform = 'rotate(0deg)'; // Gira el icono hacia la izquierda cuando se abre el sidebar
                triangle.style.left = '-30px'; // Mueve el triángulo hacia la izquierda cuando el menú está cerrado
                triangle.style.marginLeft = '1.2vh';
            } else {
                triangle.style.transform = 'rotate(-180deg)'; // Gira el icono hacia la izquierda cuando se abre el sidebar
                triangle.style.left = '20px'; // Mueve el triángulo hacia la derecha cuando el menú está abierto
                triangle.style.marginLeft = '16.6vh';
            }
        }
    }
</script>




</body>
</html>