<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Agrotrac') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!--CSS-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>







    <div id="app">


        <main class="py-4">



            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card-header">
                            <div class="text-end">
                                <img style="width: 80px" src="{{ asset('images/agrotrac.jpeg') }}" alt="">
                            </div>
                            <div class="text-center" style="margin-top: -8%">

                                <h6 class="mb-5">
                                    {{ __('LIQ. COMEDOR') }} - AGROTRAC IMPORT & EXPORT S.R.L.
                                </h6>


                            </div>
                        </div class="mb-5">
                        <hr>
                        <div class="card-body">
                            <div class="row">



                                @php
                                    foreach ($abonado->ranchos as $rancho) {
                                        $documento_cliente = $rancho->documento_cliente;
                                        $datos_cliente = $rancho->datos_cliente;
                                        $lote = $rancho->lote;
                                    }

                                @endphp

                                <p><strong>Cliente</strong>: {{ $datos_cliente }} - {{ $documento_cliente }}</p>

                                <p><strong>Fecha de pago</strong>: {{ $abonado->fecha_cancelacion }}
                                </p>

                                <p><strong>Lote</strong>: {{ $lote }}
                                </p>

                                <div class="mt-2">
                                    @if (count($abonado->ranchos) > 0)
                                        <table class="table table-striped table-hover" style="font-size: 10px">
                                            <thead>
                                                <tr class="text-center">




                                                    <th scope="col">
                                                        {{ __('DATOS COMENSAL') }}
                                                    </th>
                                                    <th scope="col">
                                                        {{ __('CANTIDAD') }}
                                                    </th>

                                                    <th scope="col">
                                                        {{ __('FECHA CONSUMO') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($abonado->ranchos as $rancho)
                                                    <tr class="text-center" style="font-size: 10px">




                                                        <td scope="row">
                                                            @if ($rancho->datos_trabajador)
                                                                {{ $rancho->datos_trabajador }}
                                                            @else
                                                            @endif
                                                        </td>

                                                        <td scope="row">
                                                            {{ $rancho->cantidad }}
                                                        </td>


                                                        <td scope="row">
                                                            {{ $rancho->created_at }}

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    @endif


                                    <p class="col-md-12 text-end g-3 h5 mt-3">Cantidad:{{ $sum_cantidad_total }}
                                    </p>

                                </div>














                            </div>
                        </div>
                    </div>
                </div>
            </div>


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
