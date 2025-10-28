@extends('admin.layout')

@section('content')
    <div class="container">


        <br>


        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('TODOS LOS PRÉSTAMOS REGISTRADOS') }}

                        </div>
                        <div class="col-md-6 text-right">
                            @can('crear registro')
                                <a class="btn btn-sm btn-special" href="#" data-toggle="modal" data-target="#ModalCreate">
                                    {{ __('CREAR NUEVO PRÉSTAMO') }}
                                </a>
                            @endcan
                        </div>


                    </div>
                    <div class="card-body table-responsive">
                        <div class="">
                            <table class="table table-striped table-hover">
                                @if (count($prestamosalidas) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                {{ __('ID') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('DESTINO') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('FECHA Y HORA DE CREACIÓN') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('CONDICIÓN') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('PRODUCTO') }}
                                            </th>

                                            <th scope="col">
                                                {{ __('DOCUMENTO RESPONSABLE') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('NOMBRE RESPONSABLE') }}
                                            </th>

                                            <th>
                                                {{ __('Acción') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px">
                                        @foreach ($prestamosalidas as $prestamosalida)
                                            <tr>
                                                <td scope="row">
                                                    {{ $prestamosalida->id }}
                                                </td>
                                                <td scope="row">
                                                    {{ $prestamosalida->destino }}
                                                </td>
                                                <td scope="row">
                                                    {{ $prestamosalida->created_at->format('d/m/Y - H:i:s') }}
                                                </td>
                                                <td scope="row">
                                                    {{ $prestamosalida->condicion }}
                                                </td>

                                                <td scope="row">
                                                    @if (count($prestamosalida->productos) > 0)
                                                        {{ $prestamosalida->productos[0]->nombre_producto }}
                                                    @endif
                                                </td>

                                                <td scope="row">
                                                    {{ $prestamosalida->documento_responsable }}
                                                </td>
                                                <td scope="row">
                                                    {{ $prestamosalida->nombre_responsable }}
                                                </td>

                                                <td class="btn-group align-items-center">
                                                    <div>
                                                        <a href="{{ route('inventarioprestamosalida.show', [$prestamosalida->id]) }}"
                                                            class="btn btn-secondary btn-sm mr-1" data-toggle="modal"
                                                            data-target="#ModalShow{{ $prestamosalida->id }}">
                                                            {{ __('VER') }}
                                                        </a>
                                                    </div>

                                                    <div>
                                                        @if ($prestamosalida->condicion == 'CON DEVOLUCIÓN' && $prestamosalida->estado != 'PRESTAMO DEVUELTO')
                                                            <a href="{{ route('inventarioprestamosalida.edit', [$prestamosalida->id]) }}"
                                                                data-toggle="modal"
                                                                data-target="#ModalRecepcionar{{ $prestamosalida->id }}"
                                                                class="btn btn-outline-dark btn-sm mr-1 ">
                                                                {{ __('RECEPCIONAR DEVOLUCIÓN') }}
                                                            </a>
                                                        @endif
                                                    </div>


                                                    <a href="{{ route('inventarioprestamosalida.printdoc', $prestamosalida->id) }}"
                                                        class="btnprn">

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

                        <div class="d-flex justify-content-between">
                            <div>
                                {{ $prestamosalidas->links('pagination::bootstrap-4') }}
                            </div>
                            <div>
                                Mostrando del {{ $prestamosalidas->firstItem() }} al {{ $prestamosalidas->lastItem() }} de
                                {{ $prestamosalidas->total() }} registros
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@include('inventarioprsalidas.modal.create')

@foreach ($prestamosalidas as $prestamosalida)
    @include('inventarioprsalidas.modal.show', ['id' => $prestamosalida->id])
    @include('inventarioprsalidas.modal.recepcionar', ['id' => $prestamosalida->id])
@endforeach


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
        @if (session('crear-prestamo-salida') == 'Salida como préstamo creada con éxito.')
            Swal.fire('Salida como préstamo', 'creada exitosamente.', 'success')
        @elseif (session('actualizar-retorno') == 'Retorno de productos prestados realizado con éxito.')
            Swal.fire('Recepción exitosa', 'Confirmamos que se nos devolvieron los producto con éxito.', 'success')
        @elseif (session('editar-registro') == 'Registro actualizado con éxito.')
            Swal.fire('Registro', 'actualizado exitosamente.', 'success')
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
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
@stop
