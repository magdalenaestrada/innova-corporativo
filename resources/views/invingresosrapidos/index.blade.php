@extends('admin.layout')


@section('content')
    <div class="container">
        <br>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('INGRESOS RÁPIDOS REGISTRADOS') }}

                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-sm btn-special" href="#" data-toggle="modal" data-target="#ModalCreate">
                                {{ __('CREAR INGRESO RÁPIDO') }}
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" text-center table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('FECHA DE CREACIÓN DE LA COMPRA') }}
                                        </th>



                                       



                                        <th scope="col">
                                            {{ __('PROVEEDOR') }}
                                        </th>


                                        <th scope="col" >
                                            {{ __('COSTO TOTAL') }}
                                        </th>



                                        <th scope="col">
                                            {{ __('ACCIÓN') }}
                                        </th>
                                    </tr>
                                </thead>

                                <tbody style="font-size:13px">
                                    @if (count($invingresosrapidos) > 0)
                                        @foreach ($invingresosrapidos as $invingresosrapido)
                                            <tr>
                                                <td scope="row">
                                                    {{ $invingresosrapido->id }}
                                                </td>
                                                <td scope="row">
                                                    {{ $invingresosrapido->created_at }}
                                                </td>

                                                @if (is_array($invingresosrapido->productos) && count($invingresosrapido->productos) > 0)
                                                    <td scope="row">
                                                        {{ $invingresosrapido->productos[0]->nombre_producto }}
                                                    </td>
                                                @endif



                                                <td scope="row">
                                                    @if ($invingresosrapido->proveedor)
                                                        {{ $invingresosrapido->proveedor->razon_social }}
                                                    @endif
                                                </td>


                                                <td scope="row" class="text-center">


                                                    <div class="d-flex justify-content-between pl-4">
                                                        <p>S/.</p> 
                                                    
                                                        <p>{{ number_format($invingresosrapido->total, 2) }}</p>
                                                            
                                                        
                                                    </div>
                                              
                                                </td>



                                                <td>
                                                    <div class="btn-group align-items-center">
                                                        <div>
                                                            @if ($invingresosrapido->estado !== 'ANULADO')
                                                                <a href="{{ route('invingresosrapidos.anular', $invingresosrapido->id) }}"
                                                                    class="bin-button btn anular mr-1"
                                                                    style="margin-left: 5px;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 39 7" class="bin-top">

                                                                        <line stroke-width="4" stroke="white" y2="5"
                                                                            x2="39" y1="5"></line>
                                                                        <line stroke-width="3" stroke="white" y2="1.5"
                                                                            x2="26.0357" y1="1.5" x1="12">
                                                                        </line>
                                                                    </svg>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 33 39" class="bin-bottom">
                                                                        <mask fill="white" id="path-1-inside-1_8_19">
                                                                            <path
                                                                                d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z">
                                                                            </path>
                                                                        </mask>
                                                                        <path mask="url(#path-1-inside-1_8_19)"
                                                                            fill="white"
                                                                            d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z">
                                                                        </path>
                                                                        <path stroke-width="4" stroke="white"
                                                                            d="M12 6L12 29"></path>
                                                                        <path stroke-width="4" stroke="white" d="M21 6V29">
                                                                        </path>
                                                                    </svg>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 89 80" class="garbage">
                                                                        <path fill="white"
                                                                            d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z">
                                                                        </path>
                                                                    </svg>
                                                                </a>
                                                            @endif

                                                        </div>




                                                        <div class="">
                                                            <a class="btn btn-secondary btn-sm" href="#"
                                                                data-toggle="modal"
                                                                data-target="#ModalShow{{ $invingresosrapido->id }}">
                                                                {{ __('VER') }}
                                                            </a>
                                                        </div>

                                                    </div>

                                                    @if ($invingresosrapido->estado == 'ANULADO')
                                                        <p class="text-red">ANULADO</p>
                                                    @endif


                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">
                                                {{ __('No hay datos disponibles') }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item {{ $invingresosrapidos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $invingresosrapidos->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $invingresosrapidos->lastPage(); $i++)
                                    <li class="page-item {{ $invingresosrapidos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $invingresosrapidos->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $invingresosrapidos->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $invingresosrapidos->nextPageUrl() }}">
                                        {{ __('Siguiente') }}
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('invingresosrapidos.modal.create')

    @foreach ($invingresosrapidos as $invingresosrapido)
        @include('invingresosrapidos.modal.show', ['id' => $invingresosrapido->id])
    @endforeach


@stop

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/updateadvice.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/jquery.printPage.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.btnprn').printPage();

        });
    </script>
    <script>
        @if (session('crear-ingreso-rapido') == 'Ingreso rapido creado con éxito.')
            Swal.fire('Ingreso rápido', 'creado exitosamente.', 'success');
        @elseif (session('crear-orden') == 'Orden de compra creada con éxito.')
            Swal.fire('Orden de compra', 'creada exitosamente.', 'success');
        @elseif (session('cancelar-orden-compra') == 'Orden de compra cancelada exitosamente.')
            Swal.fire('Orden de compra', 'cancelada con exito.', 'success');
        @elseif (session('actualizar-recepcion') == 'Recepción exitosa de productos.')
            Swal.fire('Ingreso al almacen', ' Productos recepcionados e ingresados al almacen con éxito.', 'success');
        @elseif (session('status') == 'Ingreso rápido anulado con éxito.')
            Swal.fire('Ingreso rápido', 'Anulado con éxito (revise su inventario).', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>
    <script>
        $(document).on('click', '.anular', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: '¿Está seguro que quiere eliminar este ingreso rápido?',
                text: 'Estos cambios no son reversibles',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, continuar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Example of handling modal for cancellation
            $('.open-cancel-modal').click(function() {
                var id = $(this).data('id');
                $('#ModalCancelar' + id).modal('show');
            });
        });
    </script>



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

@endpush
