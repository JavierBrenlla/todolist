<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDoLis - @yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark flex-row container text-left">
        <a href="http://" class="btn btn-primary text-white m-2">Proyectos</a>
        <a href="http://" class="btn btn-primary text-white m-2">Listas</a>
        @auth
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-nome">
                @csrf
            </form>
            <a class="nav-link" aria-current="page" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><button
                    class="btn btn-primary m-2">Salir</button></a>

        @else
            <a class="btn btn-primary text-white m-2" aria-current="page" href="{{ route('login') }}">Login</a>
        @endauth

        @auth
        @else
            <a class="btn btn-primary text-white m-2" aria-current="page" href="{{ route('register') }}">Registrar
                Usuario</a>
        @endauth
    </nav>

    {{-- <main class="container">
        @yield('central')
    </main> --}}

    <div id="app" data-app>
        @yield('central')
    </div>


    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
