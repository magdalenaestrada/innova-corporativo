<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="mobile-web-app-status-bar" content="#01d679">
    <meta name="mobile-web-app-capable" content="yes">

    <title>GRUPO INNOVA</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet"/>

    <!-- Estilos solo para la portada -->
    <link rel="stylesheet" href="{{ asset('css/flipdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index1.css') }}">
</head>

<body>
    {{-- LOGIN ARRIBA A LA DERECHA --}}
    @if (Route::has('login'))
        <div class="login-container">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
            @endauth
        </div>
    @endif

    {{-- COPOS DE NIEVE --}}
    <div class="snowflakes">
        @for ($i = 0; $i < 10; $i++)
            <div class="snowflake">🌟</div>
        @endfor
    </div>

    {{-- LUCES SUPERIORES --}}
    <ul class="lightrope">
        @for ($i = 0; $i < ceil(request()->server('HTTP_SEC_CH_UA_PLATFORM') ? 30 : 40); $i++)
            <li></li>
        @endfor
    </ul>

    {{-- CONTADOR --}}
    <div style="margin-top: 27px" id="flipdown" class="flipdown"></div>
    <h1>Grupo Innova Corporativo</h1>

    {{-- Script del contador --}}
    <script src="{{ asset('js/flipdown.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var now = new Date();
            var year = now.getFullYear();
            var christmas = new Date(year, 11, 25, 0, 0, 0);

            if (now > christmas) {
                christmas = new Date(year + 1, 11, 25, 0, 0, 0);
            }

            var countdown = Math.floor(christmas.getTime() / 1000);

            if (typeof FlipDown !== 'undefined') {
                new FlipDown(countdown, 'flipdown').start();
            }
        });
    </script>
</body>
</html>
