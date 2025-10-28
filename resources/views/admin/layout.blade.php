@extends('adminlte::page')

@section('title', 'DASHBOARD')

@section('css')


    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modals.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('css')





@stop

@section('js')
    <!-- Load all required JS files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- Custom script to handle document search -->
    <script>
        $(document).ready(function() {
            function isRucOrDni(value) {
                return value.length === 8 || value.length === 11;
            }

            function buscarDocumento(url, inputId, datosId) {
                var inputValue = $(inputId).val();
                var tipoDocumento = inputValue.length === 8 ? 'dni' : 'ruc';

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
                        if (tipoDocumento === 'dni') {
                            $(datosId).val(response.nombres + ' ' + response.apellidoPaterno + ' ' +
                                response.apellidoMaterno);
                        } else {
                            $(datosId).val(response.razonSocial);
                        }
                        $(datosId).removeClass('is-invalid').addClass('is-valid');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        $(datosId).val('');
                        $(datosId).removeClass('is-valid').addClass('is-invalid');
                    }
                });
            }

            // Button click handlers
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

            $('#buscar_trabajador_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_trabajador',
                    '#datos_trabajador');
            });

            $('#buscar_proveedor_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_proveedor',
                    '#datos_proveedor');
            });

            $('#buscar_solicitante_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_solicitante',
                    '#nombre_solicitante');
            });

            $('#buscar_responsable_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_responsable',
                    '#nombre_responsable');
            });

            // Input validation
            $('.documento-input').on('input', function() {
                var value = $(this).val();
                var isValid = isRucOrDni(value);
                $(this).toggleClass('is-valid', isValid);
                $(this).toggleClass('is-invalid', !isValid);
            });

            $('.datos-input').on('input', function() {
                var value = $(this).val();
                $(this).toggleClass('is-valid', value.trim().length > 0);
                $(this).toggleClass('is-invalid', value.trim().length === 0);
            });
        });
    </script>






@stop
