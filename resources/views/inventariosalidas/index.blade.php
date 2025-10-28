@extends('admin.layout')

@section('content')
    <div class="container">
        <br>



        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('REQUERIMIENTOS REGISTRADOS') }}

                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-sm btn-special" href="#" data-toggle="modal" data-target="#ModalCreate">
                                {{ __('CREAR REQUERIMIENTO') }}
                            </a>
                        </div>

                    </div>
                    <div class="card-body table-responsive">
                        <table class="table  table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('FECHA DE CREACIÓN DEL REQUERIMIENTO') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('CREADOR DEL REQUERIMIENTO') }}
                                    </th>

                                    <th scope="col" class="text-center">
                                        {{ __('PRODUCTO') }}
                                    </th>

                                    <th scope="col" class="text-center">
                                        {{ __('PRIORIDAD') }}
                                    </th>




                                    <th scope="col">
                                        {{ __('ACCIÓN') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody style="font-size: 13px">
                                @if (count($inventariosalidas) > 0)
                                    @foreach ($inventariosalidas as $inventariosalida)
                                        <tr>
                                            <td scope="row">
                                                {{ $inventariosalida->id }}
                                            </td>
                                            <td scope="row">
                                                {{ $inventariosalida->created_at }}
                                            </td>
                                            <td scope="row">
                                                {{ $inventariosalida->usuario_requerimiento }}
                                            </td>
                                            <td scope="row" class="text-center">
                                                @if (count($inventariosalida->productos) > 0)
                                                    {{ $inventariosalida->productos[0]->nombre_producto }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td scope="row">
                                                {{ $inventariosalida->documento->prioridad }}
                                            </td>



                                            <td>
                                                <div class="btn-group align-items-center">


                                                    <div>
                                                        <a class="btn btn-secondary btn-sm"
                                                            href="{{ route('inventariosalidas.show', [$inventariosalida->id]) }}"
                                                            data-toggle="modal"
                                                            data-target="#ModalShow{{ $inventariosalida->id }}">
                                                            {{ __('VER') }}
                                                        </a>

                                                    </div>



                                                    <div class="ml-1" style="margin-top: -10px">
                                                        <a href="{{ route('inventariosalidas.printdoc', $inventariosalida->id) }}"
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
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item {{ $inventariosalidas->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $inventariosalidas->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $inventariosalidas->lastPage(); $i++)
                                    <li class="page-item {{ $inventariosalidas->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $inventariosalidas->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $inventariosalidas->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $inventariosalidas->nextPageUrl() }}">
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
    @include('inventariosalidas.modal.create')



    @foreach ($inventariosalidas as $inventariosalida)
        @include('inventariosalidas.modal.show', ['id' => $inventariosalida->id])
        @if ($inventariosalida->estado == 'PENDIENTE')
            @include('inventariosalidas.modal.entregar', ['id' => $inventariosalida->id])
        @endif
    @endforeach

@stop
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/updateadvice.js') }}"></script>
    <script type="text/javascript" src="js/jquery.printPage.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.btnprn').printPage();

        });
    </script>
    <script>
        @if (session('entregar-requerimiento') == 'Requerimiento entregado con éxito.')
            Swal.fire('Salida del almacen', 'de los productos realizada con éxito.', 'success');
        @elseif (session('crear-inventariosalida') == 'Requerimiento creado con éxito.')
            Swal.fire('Requerimiento', 'creado exitosamente.', 'success');
        @elseif (session('cancelar-inventariosalida') == 'inventariosalida pagado con éxito.')
            Swal.fire('orden de compra', 'pagada con exito.', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>
    <script>
        $('.eliminar-inventariosalida').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar inventariosalida?',
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
@endpush
