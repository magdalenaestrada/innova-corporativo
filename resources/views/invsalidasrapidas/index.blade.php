@extends('admin.layout')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
    <div class="container">
        <br>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('SALIDAS RÁPIDAS REGISTRADOS') }}

                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-sm btn-special" href="#" data-toggle="modal" data-target="#ModalCreate">
                                {{ __('CREAR SALIDA RÁPIDA') }}
                            </a>
                        </div>



                    </div>
                    <div class="card-body">


                        <div class="row mb-3">

                            <div class="col-md-6">
                                <input type="text" name="searchs" id="searchs" class="input-search form-control"
                                    placeholder="Buscar Aquí...">
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <a href="#" class="button_export-excel" data-toggle="modal"
                                    data-target="#ModalExport">
                                    <span class="button__text">
                                        <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 50 50">
                                            <path
                                                d="M28.8125 .03125L.8125 5.34375C.339844
                                                                                                            5.433594 0 5.863281 0 6.34375L0 43.65625C0
                                                                                                            44.136719 .339844 44.566406 .8125 44.65625L28.8125
                                                                                                            49.96875C28.875 49.980469 28.9375 50 29 50C29.230469
                                                                                                            50 29.445313 49.929688 29.625 49.78125C29.855469 49.589844
                                                                                                            30 49.296875 30 49L30 1C30 .703125 29.855469 .410156 29.625
                                                                                                            .21875C29.394531 .0273438 29.105469 -.0234375 28.8125 .03125ZM32
                                                                                                            6L32 13L34 13L34 15L32 15L32 20L34 20L34 22L32 22L32 27L34 27L34
                                                                                                            29L32 29L32 35L34 35L34 37L32 37L32 44L47 44C48.101563 44 49
                                                                                                            43.101563 49 42L49 8C49 6.898438 48.101563 6 47 6ZM36 13L44
                                                                                                            13L44 15L36 15ZM6.6875 15.6875L11.8125 15.6875L14.5 21.28125C14.710938
                                                                                                            21.722656 14.898438 22.265625 15.0625 22.875L15.09375 22.875C15.199219
                                                                                                            22.511719 15.402344 21.941406 15.6875 21.21875L18.65625 15.6875L23.34375
                                                                                                            15.6875L17.75 24.9375L23.5 34.375L18.53125 34.375L15.28125
                                                                                                            28.28125C15.160156 28.054688 15.035156 27.636719 14.90625
                                                                                                            27.03125L14.875 27.03125C14.8125 27.316406 14.664063 27.761719
                                                                                                            14.4375 28.34375L11.1875 34.375L6.1875 34.375L12.15625 25.03125ZM36
                                                                                                            20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z">
                                            </path>
                                        </svg>

                                        Descargar
                                    </span>
                                    <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35"
                                            id="bdd05811-e15d-428c-bb53-8661459f9307" data-name="Layer 2" class="svg">
                                            <path
                                                d="M17.5,22.131a1.249,1.249,0,0,1-1.25-1.25V2.187a1.25,1.25,0,0,1,2.5,0V20.881A1.25,1.25,0,0,1,17.5,22.131Z">
                                            </path>
                                            <path
                                                d="M17.5,22.693a3.189,3.189,0,0,1-2.262-.936L8.487,15.006a1.249,1.249,0,0,1,1.767-1.767l6.751,6.751a.7.7,0,0,0,.99,0l6.751-6.751a1.25,1.25,0,0,1,1.768,1.767l-6.752,6.751A3.191,3.191,0,0,1,17.5,22.693Z">
                                            </path>
                                            <path
                                                d="M31.436,34.063H3.564A3.318,3.318,0,0,1,.25,30.749V22.011a1.25,1.25,0,0,1,2.5,0v8.738a.815.815,0,0,0,.814.814H31.436a.815.815,0,0,0,.814-.814V22.011a1.25,1.25,0,1,1,2.5,0v8.738A3.318,3.318,0,0,1,31.436,34.063Z">
                                            </path>
                                        </svg></span>
                                </a>
                            </div>
                        </div>





                        <div class="table-responsive">
                            <table class="table table-striped  table-hover" id="salidasrapidas-table">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>


                                        <th scope="col">
                                            {{ __('SOLICITANTE') }}
                                        </th>

                                        <th scope="col" class="text-center">
                                            {{ __('PRODUCTO') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('FECHA DE CREACIÓN DE LA ORDEN') }}
                                        </th>



                                        <th scope="col">
                                            {{ __('ACCIÓN') }}
                                        </th>
                                    </tr>
                                </thead>

                                <tbody style="font-size: 13px">
                                    @if (count($invsalidasrapidas) > 0)
                                        @foreach ($invsalidasrapidas as $invsalidarapida)
                                            <tr>
                                                <td scope="row">
                                                    {{ $invsalidarapida->id }}
                                                </td>

                                                <td scope="row">
                                                    {{ $invsalidarapida->nombre_solicitante }}
                                                </td>

                                                <td scope="row" class="text-center">
                                                    {{ $invsalidarapida->productos[0]->nombre_producto }}
                                                </td>


                                                <td scope="row">
                                                    {{ $invsalidarapida->created_at }}
                                                </td>

                                                <td>

                                                    <div class="btn-group align-items-center">

                                                        <div class="">
                                                            @if ($invsalidarapida->estado !== 'ANULADO' && $invsalidarapida->created_at >= $today)
                                                                <a href="{{ route('invsalidasrapidas.anular', $invsalidarapida->id) }}"
                                                                    class="bin-button btn anular" style="margin-left: 5px;">
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



                                                        <div class="ml-1" style="margin-top: -10px">
                                                            <a href="{{ route('invsalidasrapidas.prnpriview', $invsalidarapida->id) }}"
                                                                class="btnprn" style="margin-left: 5px;">
                                                                <div class="printer">
                                                                    <div class="paper">

                                                                        <svg viewBox="0 0 8 8" class="svg">
                                                                            <path fill="#0077FF"
                                                                                d="M6.28951 1.3867C6.91292 0.809799 7.00842 0 7.00842 0C7.00842 0 6.45246 0.602112 5.54326 0.602112C4.82505 0.602112 4.27655 0.596787 4.07703 0.595012L3.99644 0.594302C1.94904 0.594302 0.290039 2.25224 0.290039 4.29715C0.290039 6.34206 1.94975 8 3.99644 8C6.04312 8 7.70284 6.34206 7.70284 4.29715C7.70347 3.73662 7.57647 3.18331 7.33147 2.67916C7.08647 2.17502 6.7299 1.73327 6.2888 1.38741L6.28951 1.3867ZM3.99679 6.532C2.76133 6.532 1.75875 5.53084 1.75875 4.29609C1.75875 3.06133 2.76097 2.06018 3.99679 2.06018C4.06423 2.06014 4.13163 2.06311 4.1988 2.06905L4.2414 2.07367C4.25028 2.07438 4.26057 2.0758 4.27406 2.07651C4.81533 2.1436 5.31342 2.40616 5.67465 2.81479C6.03589 3.22342 6.23536 3.74997 6.23554 4.29538C6.23554 5.53084 5.23439 6.532 3.9975 6.532H3.99679Z">
                                                                            </path>
                                                                            <path fill="#0055BB"
                                                                                d="M6.756 1.82386C6.19293 2.09 5.58359 2.24445 4.96173 2.27864C4.74513 2.17453 4.51296 2.10653 4.27441 2.07734C4.4718 2.09225 5.16906 2.07947 5.90892 1.66374C6.04642 1.58672 6.1743 1.49364 6.28986 1.38647C6.45751 1.51849 6.61346 1.6647 6.756 1.8235V1.82386Z">
                                                                            </path>
                                                                        </svg>

                                                                    </div>
                                                                    <div class="dot"></div>
                                                                    <div class="output">
                                                                        <div class="paper-out"></div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>

                                                    </div>
                                                    @if ($invsalidarapida->estado == 'ANULADO')
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

                        <!-- Pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end flex-wrap">
                                <!-- Previous Page Link -->
                                <li class="page-item {{ $invsalidasrapidas->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $invsalidasrapidas->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">{{ __('Anterior') }}</span>
                                    </a>
                                </li>

                                <!-- First Page Link -->
                                <li class="page-item {{ $invsalidasrapidas->currentPage() == 1 ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $invsalidasrapidas->url(1) }}">1</a>
                                </li>

                                <!-- Second Page Link -->
                                @if ($invsalidasrapidas->lastPage() > 1)
                                    <li class="page-item {{ $invsalidasrapidas->currentPage() == 2 ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $invsalidasrapidas->url(2) }}">2</a>
                                    </li>
                                @endif

                                <!-- Ellipsis and Middle Pages -->
                                @if ($invsalidasrapidas->lastPage() > 3)
                                    @if ($invsalidasrapidas->currentPage() > 3)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($invsalidasrapidas->currentPage() > 2 && $invsalidasrapidas->currentPage() < $invsalidasrapidas->lastPage() - 1)
                                        <li class="page-item active">
                                            <a class="page-link"
                                                href="{{ $invsalidasrapidas->url($invsalidasrapidas->currentPage()) }}">{{ $invsalidasrapidas->currentPage() }}</a>
                                        </li>
                                    @endif

                                    @if ($invsalidasrapidas->currentPage() < $invsalidasrapidas->lastPage() - 2)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                <!-- Last Two Pages Links -->
                                @if ($invsalidasrapidas->lastPage() > 2)
                                    <li
                                        class="page-item {{ $invsalidasrapidas->currentPage() == $invsalidasrapidas->lastPage() - 1 ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $invsalidasrapidas->url($invsalidasrapidas->lastPage() - 1) }}">{{ $invsalidasrapidas->lastPage() - 1 }}</a>
                                    </li>
                                    <li
                                        class="page-item {{ $invsalidasrapidas->currentPage() == $invsalidasrapidas->lastPage() ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $invsalidasrapidas->url($invsalidasrapidas->lastPage()) }}">{{ $invsalidasrapidas->lastPage() }}</a>
                                    </li>
                                @endif

                                <!-- Next Page Link -->
                                <li class="page-item {{ $invsalidasrapidas->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $invsalidasrapidas->nextPageUrl() }}"
                                        aria-label="Next">
                                        <span aria-hidden="true">{{ __('Siguiente') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('invsalidasrapidas.modal.create')
    @include('invsalidasrapidas.modal.exportexcel')
@stop


@section('js')


    <script src="{{ asset('js/packages/jquery.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/updateadvice.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.printPage.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function create_tr(table_id) {
            let table_body = document.getElementById(table_id);
            let first_tr = table_body.firstElementChild;
            let tr_clone = first_tr.cloneNode(true);
            let row_number = table_body.children.length;

            table_body.appendChild(tr_clone); // Append the cloned row to the table body
            clean_first_tr(table_body.lastElementChild); // Clean the cloned row if needed

            // Dynamically update classes based on row index
            $(tr_clone).find('.cart-product').removeClass('buscador').addClass('buscador' + row_number);

            // Initialize Select2 on the appropriate element
            let $select2Input = $(tr_clone).find('.buscador' + row_number);
            $select2Input.select2({
                theme: "classic",
                dropdownParent: $('#ModalCreate')

            });

            // Remove any extra elements or handle existing values
            // Example: Removing elements that are not needed in cloned rows
            $select2Input.next().next().remove();
        }

        function clean_first_tr(firstTr) {
            let children = firstTr.children;
            children = Array.isArray(children) ? children : Object.values(children);
            children.forEach(x => {
                if (x !== firstTr.lastElementChild) {
                    let inputElement = x.firstElementChild;
                    if (inputElement) {
                        if (inputElement.type === 'checkbox') {
                            inputElement.checked = false; // Clear the checkbox
                        } else {
                            inputElement.value = ''; // Clear other input types
                        }
                    }
                }
            });

        }


        function remove_tr(This) {
            if (This.closest('tbody').childElementCount == 1) {
                Swal.fire('ERROR!!!', 'No elimine todas las filas', 'error');
            } else {
                This.closest('tr').remove();

            }
        }
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('.btnprn').printPage();

        });
        @if (session('eliminar-invsalidarapida') == 'invsalidarapida eliminado con éxito.')
            Swal.fire('invsalidarapida', 'eliminado exitosamente.', 'success');
        @elseif (session('crear-salida-rapida') == 'Salida rápida creada con éxito.')
            Swal.fire('Salida rápida', 'creada exitosamente.', 'success');
        @elseif (session('anular-salida-rapida') == 'Salida rápida anulada con éxito.')
            Swal.fire('Salida rápida', 'anulada existosamente.', 'success');
        @elseif (session('cancelar-al-credito') == 'Orden cancelada al crédito con éxito.')
            Swal.fire('Orden de compra al crédito', ' Cancelada completamente con éxito.', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif

        $(document).on('click', '.anular', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: '¿Está seguro que quiere anular esta salida del almacen?',
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

        //Search salida
        $('#searchs').on('input', function(e) {
            e.preventDefault();
            let search_string = $(this).val();
            $.ajax({
                url: "{{ route('search.salidarapida') }}",
                method: 'GET',
                data: {
                    search_string: search_string
                },
                success: function(response) {

                    $('#salidasrapidas-table tbody').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });

        });


        //edit fields based on found product
        $(document).on("change", ".cart-product", function() {
            var product = $(this).val();
            var url = "{{ route('get.product-image.by.product', ['product' => ':product']) }}";
            url = url.replace(':product', product);
            var currentRow = $(this).closest('tr');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var product = response.product;

                        productUnidad = currentRow.find('.product-unidad');
                        productUnidad.val(product.unidad.nombre);



                    } else {
                        // Handle error: product not found
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                }
            });
        });

        $('.buscador').select2({
            theme: "classic",
        });



        //API SUNAT
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


            $('#buscar_solicitante_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_solicitante',
                    '#nombre_solicitante');
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


        //AUTOFILL DOCUMENTO SOLICITANTE BASED ON THE NAME

        $('#nombre_solicitante').on('input', function(e) {
            e.preventDefault();
            let search_string = $(this).val();
            if (search_string.length >= 10) {
                console.log(1);
                $.ajax({
                    url: "{{ route('autocompdoc.persona') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {
                        console.log(1)
                        $('#documento_solicitante').val(response.documento);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });

            }


        });
    </script>

@endsection
