<div class="modal fade text-left" id="ModalShow{{ $nota->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered custom-modal-width" role="document">
        <div class="modal-content">

            {{-- CABECERA --}}
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('NOTAS DE PEDIDO') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" style="font-size: 30px" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <img style="width: 15px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
                        </button>
                    </div>
                </div>
            </div>

            {{-- CUERPO --}}
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="form-group col-md-2 g-3">
                            <label class="text-sm">{{ __('CÓDIGO') }}</label>
                            <input class="form-control form-control-sm" value="{{ $nota->codigo }}" disabled>
                        </div>

                        <div class="form-group col-md-2 g-3">
                            <label class="text-sm">{{ __('FECHA DE CREACIÓN') }}</label>
                            <input class="form-control form-control-sm" value="{{ $nota->fecha_creacion }}" disabled>
                        </div>

                        <div class="form-group col-md-3 g-3">
                            <label class="text-sm">{{ __('DNI') }}</label>
                            <input class="form-control form-control-sm" value="{{ $nota->dni }}" disabled>
                        </div>

                        <div class="form-group col-md-5 g-3">
                            <label class="text-sm">{{ __('CONDUCTOR') }}</label>
                            <input class="form-control form-control-sm" value="{{ $nota->conductor }}"
                                disabled>
                        </div>

                    </div>
                    {{-- COSTOS --}}
                    <div class="row">
                        <div class="form-group col-md-2 g-3">
                            <label class="text-sm">{{ __('TELEFONO') }}</label>
                            <input class="form-control form-control-sm" value="{{ $nota->telefono }}" disabled>
                        </div>

                        <div class="form-group col-md-2 g-3">
                            <label class="text-sm">{{ __('PLACA') }}</label>
                            <input class="form-control form-control-sm" value="{{ $nota->placa_vehiculo }}" disabled>
                        </div>

                        <div class="form-group col-md-2 g-3">
                            <label class="text-sm">{{ __('KILOMETRAJE') }}</label>
                            <input class="form-control form-control-sm" value="{{ $nota->kilometraje }}" disabled>
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label class="text-sm">{{ __('ENCARGADO') }}</label>
                            <input class="form-control form-control-sm" value="{{ $nota->encargado->nombre }}"
                                disabled>
                        </div>

                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="form-group col-md-12 g-3">
                        <label class="text-sm">{{ __('DESCRIPCIÓN / OBSERVACIÓN') }}</label>
                        <textarea class="form-control form-control-sm" rows="3" disabled>{{ $nota->descripcion ?? 'Sin descripción registrada' }}</textarea>
                    </div>

                    {{-- TABLA DE SERVICIOS --}}
                    <div class="mt-3 table-responsive">
                        @if ($nota->detalles && $nota->detalles->count() > 0)
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr class="text-center" style="font-size: 14px">
                                        <th>{{ __('PRODUCTO') }}</th>
                                        <th>{{ __('CANTIDAD') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nota->detalles as $detalle)
                                        <tr class="text-center" style="font-size: 13px">
                                            <td>{{ $detalle->producto->nombre_producto }}</td>
                                            <td>{{ $detalle->cantidad }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center mt-3">No hay detalles de servicio registrados.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
