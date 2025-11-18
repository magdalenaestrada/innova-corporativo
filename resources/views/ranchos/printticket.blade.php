<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!--CSS-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>



    <div class="container">
    <br>
        <p class="text-center mr-1" style="margin-bottom: -5px">GRUPO INNOVA CORPORATIVO S.A.C.</p>



        <p class="text-center" style="margin-bottom: -5px">{{ __('TICKET') }} AGROTRAC - {{ $rancho->id }}</p>


        <p class="text-center" style="margin-bottom: -5px">
            {{ __('FECHA:') }} {{ $rancho->created_at->format('d/m/Y') }} <br>

        </p>
        <p class="text-center" style="margin-bottom: 0px">

            {{ __('HORA ') }} {{ $rancho->created_at->format('H:i:s') }}
        </p>

        <p class="text-center" style="font-size: 12px">

            {{ __('VÁLIDO PARA EL DÍA...') }}
        </p>



        <p style="font-size: 12px; margin-bottom: -1px"> <strong> {{ __('DATOS CLIENTE') }}: </strong> {{ $rancho->datos_cliente }} </p>



        <p style="font-size: 12px; margin-bottom: -1px"><strong> {{ __('DOCUMENTO COMENSAL') }}: </strong> {{ $rancho->documento_trabajador }} </p>

        <p style="font-size: 12px; margin-bottom: -1px"> <strong> {{ __('DATOS COMENSAL') }}: </strong> {{ $rancho->datos_trabajador }} </p>

        <p style="font-size: 12px; margin-bottom: -1px"> <strong> {{ __('CANTIDAD') }}: </strong> {{ $rancho->cantidad }} </p>
        <p style="font-size: 12px; margin-bottom: -1px"> <strong> {{ __('COMIDA') }}: </strong> {{ $rancho->comida->nombre }} </p>
        <p style="font-size: 12px; margin-bottom: -1px"> <strong> {{ __('LOTE') }}: </strong> {{ $rancho->lote }} </p>
        <br>
        <hr>

       <br>



    <div id="app">


        <main class="py-4">

        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="js/jquery.printPage.js"></script>
    <script>
        $(document).ready(function() {
            function isRucOrDni(value) {
                return value.length === 8 || value.length === 11;
            }

            function buscarDocumento(url, inputId, datosId) {
                var inputValue = $(inputId).val();
                var tipoDocumento = inputValue.length === 8 ? 'dni' : 'ruc';

                // Realizar la solicitud AJAX al controlador
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        documento: inputValue,
                        tipo_documento: tipoDocumento
                    },
                    success: function(response) {
                        console.log('API Response:', response);
                        // Manejar la respuesta del controlador
                        if (tipoDocumento === 'dni') {
                            $(datosId).val(response.nombres + ' ' + response.apellidoPaterno + ' ' +
                                response.apellidoMaterno);
                        } else {
                            $(datosId).val(response.razonSocial);
                        }

                        $(datosId).removeClass('is-invalid').addClass('is-valid');
                    },
                    error: function(xhr, status, error) {
                        // Manejar el error de la solicitud
                        console.log(xhr.responseText);
                        $(datosId).val('');
                        $(datosId).removeClass('is-valid').addClass('is-invalid');
                    }
                });
            }

            $('#buscar_cliente_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_cliente', '#datos_cliente');
            });

            $('#buscar_conductor_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_conductor',
                    '#datos_conductor');
            });

            $('#buscar_balanza_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_balanza', '#datos_balanza');
            });

            $('#buscar_socio_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_socio', '#datos_socio');
            });

            // Validar ruc o dni y cambiar el borde a verde al llenar los campos
            $('.documento-input').on('input', function() {
                var value = $(this).val();
                var isValid = isRucOrDni(value);

                $(this).toggleClass('is-valid', isValid);
                $(this).toggleClass('is-invalid', !isValid);
            });

            // Cambiar el borde a verde cuando se llenen los campos datos_cliente
            $('.datos-input').on('input', function() {
                var value = $(this).val();
                $(this).toggleClass('is-valid', value.trim().length > 0);
                $(this).toggleClass('is-invalid', value.trim().length === 0);
            });
        });
    </script>
    @stack('js')
</body>

</html>
