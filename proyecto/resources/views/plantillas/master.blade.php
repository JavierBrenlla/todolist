<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDoLis - @yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- https://material.io/resources/icons/?style=baseline -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <!-- https://material.io/resources/icons/?style=outline -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- https://material.io/resources/icons/?style=round -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Round" rel="stylesheet">
    <!-- https://material.io/resources/icons/?style=sharp -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Sharp" rel="stylesheet">
    <!-- https://material.io/resources/icons/?style=twotone -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Two+Tone" rel="stylesheet">
</head>

<body>
    <nav
        class="navbar navbar-expand-sm navbar-expand-lg navbar-expand-md navbar-expand-xl navbar-dark bg-dark flex-row container text-left">
        <a href="/listar_proyectos/{{ auth()->user()->id }}" class="btn btn-primary text-white m-2 botones">Proyectos</a>
        <a href="/listar_listas" class="btn btn-primary text-white m-2 botones">Listas</a>
        @auth
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-nome">
                @csrf
            </form>
            <a class="nav-link" aria-current="page" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><button
                    class="btn btn-primary m-2 btn-salir"><span class="material-icons-outlined salir">
                        power_settings_new
                        </span></button></a>

        @else
            <a class="btn btn-primary text-white m-2" aria-current="page" href="{{ route('login') }}">Login</a>
        @endauth

        @auth
        @else
            <a class="btn btn-primary text-white m-2" aria-current="page" href="{{ route('register') }}">Registrar
                Usuario</a>
        @endauth
    </nav>

    <div id="app" data-app>
        @yield('central')
    </div>

    <div>
        @yield('contenido')
    </div>

    <div id="scripts">
        @yield('scripts')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('css/app.css') }}"></script>
</body>

</html>
