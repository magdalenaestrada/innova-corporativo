@extends('admin.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/invherramientas.css') }}">
@endpush

@section('content')
    <div class="container">


        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('HERRAMIENTAS REGISTRADAS') }}

                        </div>
                        <div class="text-right col-md-6">
                            <a class="btn btn-sm btn-special" href="#" data-toggle="modal" data-target="#ModalCreate">
                                {{ __('CREAR HERRAMIENTA') }}
                            </a>
                        </div>

                    </div>



                    <div class="card-body ">

                        <div class="table-responsive">
                            <table id="products-table" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('NOMBRE') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('CODIGO DEL PRODUCTO') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('STOCK') }}
                                        </th>



                                        <th scope="col">
                                            {{ __('IMAGEN') }}
                                        </th>



                                        <th scope="col">
                                            {{ __('ACCIÓN') }}
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (count($invherramientas) > 0)
                                        @foreach ($invherramientas as $invherramienta)
                                            <tr>
                                                <td scope="row">
                                                    {{ $invherramienta->id }}
                                                </td>

                                                <td scope="row">
                                                    {{ $invherramienta->nombre }}
                                                </td>


                                                <td scope="row">
                                                    {{ $invherramienta->codigo }}
                                                </td>

                                                <td scope="row">
                                                    @if ($invherramienta->stock)
                                                        {{ $invherramienta->stock }}
                                                    @else
                                                        {{ __('-') }}
                                                    @endif
                                                </td>

                                                <td scope="row" class="text-center">
                                                    @if ($invherramienta->imagen)
                                                        s/{{ $invherramienta->imagen }}
                                                    @else
                                                        {{ __('-') }}
                                                    @endif
                                                </td>


                                                <td scope="row">


                                                </td>







                                                <td>


                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">
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
                                <li class="page-item {{ $invherramientas->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $invherramientas->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">{{ __('Anterior') }}</span>
                                    </a>
                                </li>

                                <!-- First Page Link -->
                                <li class="page-item {{ $invherramientas->currentPage() == 1 ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $invherramientas->url(1) }}">1</a>
                                </li>

                                <!-- Second Page Link -->
                                @if ($invherramientas->lastPage() > 1)
                                    <li class="page-item {{ $invherramientas->currentPage() == 2 ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $invherramientas->url(2) }}">2</a>
                                    </li>
                                @endif

                                <!-- Ellipsis and Middle Pages -->
                                @if ($invherramientas->lastPage() > 3)
                                    @if ($invherramientas->currentPage() > 3)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if ($invherramientas->currentPage() > 2 && $invherramientas->currentPage() < $invherramientas->lastPage() - 1)
                                        <li class="page-item active">
                                            <a class="page-link"
                                                href="{{ $invherramientas->url($invherramientas->currentPage()) }}">{{ $invherramientas->currentPage() }}</a>
                                        </li>
                                    @endif

                                    @if ($invherramientas->currentPage() < $invherramientas->lastPage() - 2)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                <!-- Last Two Pages Links -->
                                @if ($invherramientas->lastPage() > 2)
                                    <li
                                        class="page-item {{ $invherramientas->currentPage() == $invherramientas->lastPage() - 1 ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $invherramientas->url($invherramientas->lastPage() - 1) }}">{{ $invherramientas->lastPage() - 1 }}</a>
                                    </li>
                                    <li
                                        class="page-item {{ $invherramientas->currentPage() == $invherramientas->lastPage() ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $invherramientas->url($invherramientas->lastPage()) }}">{{ $invherramientas->lastPage() }}</a>
                                    </li>
                                @endif

                                <!-- Next Page Link -->
                                <li class="page-item {{ $invherramientas->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $invherramientas->nextPageUrl() }}" aria-label="Next">
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
@stop



@include('invherramientas.modal.create')








@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/updateadvice.js') }}"></script>

    <script>
        @if (session('eliminar-producto') == 'Producto eliminado con éxito.')
            Swal.fire('Producto', 'eliminado exitosamente.', 'success');
        @elseif (session('crear-herramienta') == 'Herramienta creada con éxito.')
            Swal.fire('Herramienta', 'creada exitosamente.', 'success');
        @elseif (session('actualizar-producto') == 'Producto actulizado con éxito.')
            Swal.fire('Producto', 'actualizado existosamente.', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>
    <script>
        $('.eliminar-producto').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, continuar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>







    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }


        });
    </script>
    <script>
        $(document).ready(function() {
            //alert();


            //Search product
            $('#searchp').on('keyup', function(e) {
                e.preventDefault();
                let search_string = $(this).val();
                $.ajax({
                    url: "{{ route('search.product') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {

                        $('#products-table tbody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }

                });

            });





        });
    </script>
@stop
