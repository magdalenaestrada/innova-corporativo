@extends('admin.layout')

@section('content')
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('TODOS LOS TICKETS DEL COMEDOR REGISTRADOS') }}

                        </div>
                        <div class="col-md-6 text-right">

                            @can('create comedor')
                                <a class="btn btn-sm btn-special" href="{{ route('ranchos.create') }}">
                                    {{ __('CREAR NUEVO TICKET PARA EL COMEDOR') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <table class="table table-striped table-hover" style="font-size: 13px; margin-bottom:10px">
                            @if (count($ranchos) > 0)
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('DOCUMENTO CLIENTE') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('DATOS CLIENTE') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('DOCUMENTO COMENSAL') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('DATOS COMENSAL') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('ESTADO') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('CANTIDAD') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('LOTE') }}
                                        </th>


                                        <th>
                                            {{ __('ACCIÓN') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 13px">
                                    @foreach ($ranchos as $rancho)
                                        <tr>
                                            <td scope="row">
                                                {{ $rancho->id }}
                                            </td>
                                            <td scope="row">
                                                {{ $rancho->documento_cliente }}
                                            </td>
                                            <td scope="row">
                                                {{ $rancho->datos_cliente }}
                                            </td>

                                            <td scope="row">
                                                {{ $rancho->documento_trabajador }}
                                            </td>
                                            <td scope="row">
                                                {{ $rancho->datos_trabajador }}
                                            </td>


                                            <td scope="row">
                                                {{ $rancho->estado }}
                                            </td>

                                            <td scope="row">
                                                {{ $rancho->cantidad }}
                                            </td>

                                            <td scope="row">
                                                {{ $rancho->lote }}
                                            </td>

                                            <td>
                                                <div class="btn-group align-items-center">

                                                    <a href="{{ route('ranchos.show', $rancho->id) }}"
                                                        class="btn btn-secondary btn-sm mr-1" style="height: 33px">
                                                        {{ __('VER') }}
                                                    </a>

                                                    @if ($rancho->estado == 'abierto')
                                                        <a href="{{ route('ticket.prnpriview', $rancho->id) }}"
                                                            class="btnprn btn btn-info btn-sm mr-1"
                                                            style="height:33px">IMPRIMIR</a>
                                                    @endif

                                                    @if ($rancho->estado == 'impreso')
                                                        @can('print always')
                                                            <a href="{{ route('ticket.prnpriview', $rancho->id) }}"
                                                                class="btnprn btn btn-info btn-sm mr-1"
                                                                style="height:33px">IMPRIMIR</a>
                                                        @endcan
                                                    @endif

                                                    @can('delete ticket')
                                                        <form class="eliminar-ticket"
                                                            action="{{ route('ranchos.destroy', $rancho->id) }}" method="POST"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm mr-1">
                                                                {{ __('ELIMINAR') }}
                                                            </button>
                                                        </form>
                                                    @endcan

                                                </div>

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


                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end flex-wrap">
                                <!-- Previous Page Link -->
                                <li class="page-item {{ $ranchos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(['page' => $ranchos->currentPage() - 1]) }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">{{ __('Anterior') }}</span>
                                    </a>
                                </li>

                                <!-- First 7 Pages -->
                                @for ($i = 1; $i <= 7 && $i <= $ranchos->lastPage(); $i++)
                                    <li class="page-item {{ $ranchos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Ellipsis if needed before middle pages -->
                                @if ($ranchos->currentPage() > 10)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <!-- Middle Pages (2 before and 2 after current page) -->
                                @for ($i = max(8, $ranchos->currentPage() - 2); $i <= min($ranchos->lastPage() - 7, $ranchos->currentPage() + 2); $i++)
                                    @if ($i > 7 && $i < $ranchos->lastPage() - 6)
                                        <li class="page-item {{ $ranchos->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor

                                <!-- Ellipsis if needed before last 7 pages -->
                                @if ($ranchos->currentPage() < $ranchos->lastPage() - 10)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <!-- Last 7 Pages -->
                                @for ($i = max($ranchos->lastPage() - 6, 8); $i <= $ranchos->lastPage(); $i++)
                                    <li class="page-item {{ $ranchos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Page Link -->
                                <li class="page-item {{ $ranchos->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(['page' => $ranchos->currentPage() + 1]) }}"
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
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/updateadvice.js') }}"></script>

    <script type="text/javascript" src="js/jquery.printPage.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.btnprn').printPage();

        });
    </script>
    <script>
        @if (session('eliminar-ticket') == 'Ticket eliminado con éxito')
            Swal.fire('Ticket', 'eliminado exitosamente.', 'success')
        @endif
        @if (session('crear-registro') == 'Registro creado con éxito.')
            Swal.fire('Registro', 'creado exitosamente.', 'success')
        @endif
        @if (session('editar-registro') == 'Registro actualizado con éxito.')
            Swal.fire('Registro', 'actualizado exitosamente.', 'success')
        @endif
    </script>
    <script>
        $('.eliminar-registro').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar registro?',
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
    <script type="text/javascript">
        $('.eliminar-ticket').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Está seguro que quiere eliminar este ticket?',
                text: 'Estos cambios no son reversibles',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, continuar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>



@endsection
