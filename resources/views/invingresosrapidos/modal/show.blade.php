<div class="modal fade text-left" id="ModalShow{{ $invingresosrapido->id }}" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('INGRESO RÁPIDO') }}
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
            <div class="card-body">

                <div class="row">

                    <div class="form-group col-md-6 g-3">
                        <label for="inventariosalida_fin" class="text-sm">
                            {{ __('FECHA DE CREACIÓN') }}
                        </label>
                        <input class="form-control form-control-sm" value="{{ $invingresosrapido->created_at }}"
                            disabled>
                    </div>

                    <div class="form-group col-md-6 g-3">
                        <label for="inventariosalida_fin" class="text-sm">
                            {{ __('CREADOR') }}
                        </label>
                        <input class="form-control form-control-sm" value="{{ $invingresosrapido->usuario_creador }}"
                            disabled>
                    </div>

                    <div class="mt-2 col-md-12 table-responsive">
                        @if (count($invingresosrapido->productos) > 0)
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr class="text-center">

                                        <th scope="col">
                                            {{ __('PRODUCTO DEL REQUERIMIENTO') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('CANTIDAD') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('VALOR UNITARIO') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('SUBTOTAL') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('FECHA DE CREACIÓN') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invingresosrapido->productos as $producto)
                                        <tr class="text-center">
                                            <td scope="row">
                                                {{ $producto->nombre_producto }}
                                            </td>
                                            <td scope="row">
                                                {{ $producto->pivot->cantidad }}
                                            </td>

                                            <td scope="row">
                                                s/{{ $producto->pivot->precio }}
                                            </td>

                                            <td scope="row">
                                                s/{{ $producto->pivot->subtotal }}
                                            </td>

                                            <td scope="row">
                                                {{ $producto->pivot->created_at }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        @endif
                    </div>

                    <div class="col-md-12 m-2">
                        @if ($invingresosrapido->subtotal)
                            <p class="text-center h6"> SUBTOTAL: S/.
                                {{ number_format($invingresosrapido->subtotal, 2) }}</p>
                        @endif

                        <p class="text-center h5"> IMPORTE TOTAL: S/. {{ number_format($invingresosrapido->total, 2) }}
                        </p>

                    </div>

                    <div class="form-group col-md-6 g-3">
                        <label for="inventariosalida_fin" class="text-sm">
                            {{ __('TIPO COMPROBANTE') }}
                        </label>
                        <input class="form-control form-control-sm" value="{{ $invingresosrapido->tipo_comprobante }}"
                            disabled>
                    </div>

                    <div class="form-group col-md-6 g-3">
                        <label for="inventariosalida_fin" class="text-sm">
                            {{ __('COMPROBANTE CORRELATIVO') }}
                        </label>
                        <input class="form-control form-control-sm"
                            value="{{ $invingresosrapido->comprobante_correlativo }}" disabled>
                    </div>

                    @if ($invingresosrapido->proveedor)
                        <div class="form-group col-md-4 g-3">
                            <label for="documento_proveedor" class="text-sm">
                                {{ __('DOCUMENTO PROVEEDOR') }}
                            </label>
                            <div class="input-group">
                                <input class="form-control form-control-sm"
                                    value="{{ $invingresosrapido->proveedor->ruc }}" disabled>

                            </div>
                        </div>
                        <div class="form-group col-md-8 g-3">
                            <label for="nombre_proveedor" class="text-sm">
                                {{ __('NOMBRE PROVEEDOR') }}
                            </label>
                            <input class="form-control form-control-sm"
                                value="{{ $invingresosrapido->proveedor->razon_social }}" disabled>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
