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
                    <div class="row card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('PESOS REGISTRADOS') }}

                        </div>


                    </div>

                    <div class="row align-items-center justify-content-between p-3">



                        <div class="col-md-6 input-container">


                        </div>



                        <a href="#" class="button_export-excel" data-toggle="modal" data-target="#ModalExport">
                            <span class="button__text">
                                <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 50 50">
                                    <path d="M28.8125 .03125L.8125 5.34375C.339844
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
                                        20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z"></path>
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






                    <div class="card-body">


                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                @if (count($pesos) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                {{ __('Nro') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('Horas') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('Fechas') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('Neto') }}
                                            </th>
                                            <th>
                                                {{ __('Placa') }}
                                            </th>

                                            <th>
                                                {{ __('Producto') }}
                                            </th>


                                            <th>
                                                {{ __('RazonSocial') }}
                                            </th>


                                            <th>
                                                {{ __('Conductor') }}
                                            </th>
                                            <th>
                                                {{ __('destino') }}
                                            </th>
                                            <th>
                                                {{ __('origen') }}
                                            </th>





                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pesos as $peso)
                                            <tr>
                                                <td scope="row">
                                                    {{ $peso->NroSalida }}
                                                </td>
                                                <td scope="row">
                                                    {{ $peso->Horas }}
                                                </td>

                                                <td scope="row">
                                                    {{ $peso->Fechas }}
                                                </td>

                                                <td scope="row">
                                                    {{ $peso->Neto }}
                                                </td>
                                                <td scope="row">
                                                    {{ $peso->Placa }}
                                                </td>

                                                <td scope="row">
                                                    {{ $peso->Producto }}
                                                </td>

                                                <td scope="row">
                                                    {{ $peso->RazonSocial }}
                                                </td>


                                                <td scope="row">
                                                    {{ $peso->Conductor }}
                                                </td>

                                                <td scope="row">
                                                    {{ $peso->destino }}
                                                </td>

                                                <td scope="row">
                                                    {{ $peso->origen }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            {{ __('No hay datos disponibles') }}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end flex-wrap">
                                <!-- Previous Page Link -->
                                <li class="page-item {{ $pesos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(['page' => $pesos->currentPage() - 1]) }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">{{ __('Anterior') }}</span>
                                    </a>
                                </li>

                                <!-- First 7 Pages -->
                                @for ($i = 1; $i <= 7 && $i <= $pesos->lastPage(); $i++)
                                    <li class="page-item {{ $pesos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Ellipsis if needed before middle pages -->
                                @if ($pesos->currentPage() > 10)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <!-- Middle Pages (2 before and 2 after current page) -->
                                @for ($i = max(8, $pesos->currentPage() - 2); $i <= min($pesos->lastPage() - 7, $pesos->currentPage() + 2); $i++)
                                    @if ($i > 7 && $i < $pesos->lastPage() - 6)
                                        <li class="page-item {{ $pesos->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor

                                <!-- Ellipsis if needed before last 7 pages -->
                                @if ($pesos->currentPage() < $pesos->lastPage() - 10)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <!-- Last 7 Pages -->
                                @for ($i = max($pesos->lastPage() - 6, 8); $i <= $pesos->lastPage(); $i++)
                                    <li class="page-item {{ $pesos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Page Link -->
                                <li class="page-item {{ $pesos->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(['page' => $pesos->currentPage() + 1]) }}"
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

    @include('pesos.modal.export')




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
        @if (session('eliminar-inventarioingreso') == 'inventarioingreso eliminado con éxito.')
            Swal.fire('inventarioingreso', 'eliminado exitosamente.', 'success');
        @elseif (session('crear-orden') == 'Orden de compra creada con éxito.')
            Swal.fire('Orden de compra', 'creada exitosamente.', 'success');
        @elseif (session('cancelar-orden-compra') == 'Orden de compra cancelada exitosamente.')
            Swal.fire('Orden de compra', 'cancelada con exito.', 'success');
        @elseif (session('actualizar-recepcion') == 'Recepción exitosa de productos.')
            Swal.fire('Ingreso al almacen', ' Productos recepcionados e ingresados al almacen con éxito.', 'success');
        @elseif (session('cancelar-al-credito') == 'Orden cancelada al crédito con éxito.')
            Swal.fire('Orden de compra al crédito', ' Cancelada completamente con éxito.', 'success');
        @elseif (session('anular-orden-compra') == 'Orden de compra anulada con éxito.')
            Swal.fire('Orden de compra', 'Anulada con éxito.', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>
    <script>
        $(document).on('click', '.anular', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: '¿Está seguro que quiere anular esta orden de compra?',
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

    <script type="text/javascript">
        $(document).ready(function() {
            //alert();


            //Search inrgeso
            $('#searchi').on('input', function(e) {
                e.preventDefault();
                let search_string = $(this).val();
                $.ajax({
                    url: "{{ route('search.ingreso') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {

                        $('#ingresos-table tbody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }

                });

            });





        });
    </script>
@endpush
