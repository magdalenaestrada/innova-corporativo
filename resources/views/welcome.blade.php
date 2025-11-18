<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="mobile-web-app-status-bar" content="#01d679">
    <meta name="mobile-web-app-capable" content="yes">

    <title>INNOVA</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet" />

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/flipdown.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index1.css') }}" />
</head>

<body>

    {{-- LOGIN ARRIBA A LA DERECHA --}}
    @if (Route::has('login'))
        <div class="login-container">
            @auth
                <a href="{{ url('/home') }}">Ir al panel</a>
            @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
            @endauth
        </div>
    @endif

    {{-- LUCES SUPERIORES --}}
    <ul class="lightrope">
        <script>
            for (var i = 0; i < window.screen.width / 50; i++) {
                document.write("<li></li>");
            }
        </script>
    </ul>

    {{-- COPOS DE NIEVE --}}
    <div class="snowflakes" aria-hidden="true">
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
    </div>

    {{-- CONTENIDO CENTRAL --}}
    <div style="height: 100vh; display:flex; flex-direction:column; align-items:center; justify-content:flex-start;">

        <h1>GRUPO INNOVA CORPORATIVO</h1>

        {{-- ÁRBOL DE NAVIDAD --}}
        <div class="tree-container">
            <div class="tree">
                {{-- Estrella --}}
                <div class="star"></div>

                {{-- Conos del árbol --}}
                <div class="tree-cone1 cone"></div>
                <div class="tree-cone2 cone"></div>
                <div class="tree-cone3 cone"></div>

                {{-- Tronco --}}
                <div class="trunk"></div>

                {{-- Adornos --}}
                <div class="ornament or1">
                    <div class="shine"></div>
                </div>
                <div class="ornament or2">
                    <div class="shine"></div>
                </div>
                <div class="ornament or3">
                    <div class="shine"></div>
                </div>
                <div class="ornament or4">
                    <div class="shine"></div>
                </div>
                <div class="ornament or5">
                    <div class="shine"></div>
                </div>
                <div class="ornament or6">
                    <div class="shine"></div>
                </div>

                {{-- Campanas --}}
                <div class="bells-container">
                    <div class="bell1">
                        <div class="bell-top"></div>
                        <div class="bell-mid"></div>
                        <div class="bell-bottom"></div>
                    </div>
                    <div class="bell2">
                        <div class="bell-top"></div>
                        <div class="bell-mid"></div>
                        <div class="bell-bottom"></div>
                    </div>
                    <div class="bow">
                        <div class="b1"></div>
                        <div class="b2"></div>
                        <div class="b3"></div>
                    </div>
                </div>

                {{-- Sombra del árbol --}}
                <div class="shadow"></div>

                {{-- Regalos --}}
                <div class="gift"></div>
                <div class="ribbon"></div>
                <div class="gift2"></div>
                <div class="ribbon2"></div>
            </div>
        </div>

        {{-- CONTADOR NAVIDAD --}}
        <div style="margin-top: 10px;" id="flipdown" class="flipdown"></div>

    </div>

    {{-- SCRIPT FLIPDOWN --}}
    <script src="{{ asset('js/flipdown.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Próxima Navidad
            var now = new Date();
            var year = now.getFullYear();
            var christmas = new Date(year, 11, 25, 0, 0, 0); // 11 = diciembre

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
