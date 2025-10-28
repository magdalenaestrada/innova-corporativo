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
                            {{ __('NOTAS DE PEDIDO REGISTRADAS') }}
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-sm btn-special" href="{{ route('nota-pedido.formulario') }}">
                                {{ __('CREAR NOTA DE PEDIDO') }}
                            </a>
                        </div>
                    </div>

                    <div class="row align-items-center justify-content-between p-3">
                        <div class="col-md-6 input-container">
                            <input type="text" name="search" id="search" class="input-search form-control"
                                placeholder="Buscar aquí...">
                        </div>
                        <a href="{{ route('nota-pedido.reportes') }}" class="button_export-excel">
                            <span class="button__text">Descargar Excel</span>
                        </a>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-hover text-center" id="ordenservicio-table">
                            <thead>
                                <tr>
                                    <th>{{ __('CODIGO') }}</th>
                                    <th>{{ __('FECHA DE CREACIÓN') }}</th>
                                    <th>{{ __('DNI') }}</th>
                                    <th>{{ __('CONDUCTOR') }}</th>
                                    <th>{{ __('PLACA') }}</th>
                                    <th>{{ __('KILOMETRAJE') }}</th>
                                    <th>{{ __('ENCARGADO') }}</th>
                                    <th>{{ __('ACCIÓN') }}</th>
                                </tr>
                            </thead>

                            <tbody style="font-size:13px">
                                @forelse ($notas as $nota)
                                    <tr>
                                        <td>{{ $nota->codigo }}</td>
                                        <td>{{ $nota->fecha_creacion }}</td>
                                        <td>{{ $nota->dni }}</td>
                                        <td>{{ $nota->conductor }}</td>
                                        <td>{{ $nota->placa_vehiculo }}</td>
                                        <td>{{ $nota->kilometraje }}</td>
                                        <td>{{ $nota->encargado->nombre ?? '-' }}</td>

                                        <td class="d-flex justify-content-center">
                                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                                data-target="#ModalShow{{ $nota->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>


                                            <a href="{{ route('nota-pedido.edit', $nota->id) }}"
                                                class="btn btn-outline-warning btn-sm mx-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="ml-1" style="margin-top: -10px">
                                                <a href="{{ route('nota-pedido.print', $nota->id) }}" class="btnprn"
                                                    style="margin-left: 5px;">
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

                                            <a href="{{ route('nota-pedido.anular', $nota->id) }}"
                                                class="btn btn-danger btn-sm mx-1 anular-nota-pedido"
                                                data-id="{{ $nota->id }}">
                                                X
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            {{ __('No hay órdenes registradas') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <nav>
                            <ul class="pagination justify-content-end">
                                {{ $notas->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 AQUI VAN LOS MODALES (fuera del foreach) --}}
    @foreach ($notas as $nota)
        @include('notas.modal.show', ['ordenServicio' => $nota])
    @endforeach
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/updateadvice.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.printPage.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.btnprn').printPage();

        });
    </script>

    <script>
        // Confirmación de anulación
        $(document).on('click', '.anular-nota-pedido', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: '¿Anular esta orden de servicio?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, anular',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/nota-pedido/${id}/anular`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            Swal.fire('Éxito', 'La orden ha sido anulada.', 'success')
                                .then(() => location.reload());
                        },
                        error: function() {
                            Swal.fire('Error', 'Ocurrió un error al anular la orden.', 'error');
                        }
                    });
                }
            });
        });

        // Buscador en vivo
        $('#search').on('input', function() {
            const value = $(this).val();
            $.ajax({
                url: "{{ route('search.ordenservicio') }}",
                method: 'GET',
                data: {
                    search: value
                },
                success: function(response) {
                    $('#ordenservicio-table tbody').html(response);
                },
                error: function(err) {
                    console.error(err);
                }
            });
        });

        // Notificaciones
        @if (session('success'))
            Swal.fire('Éxito', '{{ session('success') }}', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>
@stop
