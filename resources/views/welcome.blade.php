<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="mobile-web-app-status-bar" content="#01d679">
    <meta name="mobile-web-app-capable" content="yes">


    <title>Agrotrac</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/flipdown.css') }}">


    <link rel="stylesheet" type="text/css"  href="{{ asset('css/index1.css')}}"  />
    <link
      href="https://fonts.googleapis.com/css?family=Berkshire+Swash"
      rel="stylesheet"
    />

  
</head>

<body>
   
        @if (Route::has('login'))
            <div class="login-container">
                @auth
                    <a href="{{ url('/home') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar Sesión</a>


                @endauth
            </div>
        @endif


   
        <div class="snowflakes">
            <script>
                for (var i = 0; i < 10; i++) {
                    document.write("<div class='snowflake'>🌟   </div>");
                }
            </script>
        </div>
        <ul class="lightrope">
            <script>
                for (var i = 0; i < window.screen.width / 50; i++) {
                    document.write("<li></li>");
                }
            </script>
        </ul>
        <div style="margin-top: 27px" id="flipdown" class="flipdown"></div>
        <h1>AGROTRAC IMPORT & EXPORT S.R.L.</h1>

      






    
</body>

</html>
