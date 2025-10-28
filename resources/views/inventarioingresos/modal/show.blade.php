<div class="modal fade text-left" id="ModalShow{{ $inventarioingreso->id }}" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered custom-modal-width" role="document">
        <div class="modal-content">


            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('ORDEN DE COMPRA') }}
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

                <div class="form-group">

                    <div class="row">
                        <div class="form-group col-md-4 g-3">
                            <label for="fecha" class="text-sm">
                                {{ __('FECHA DE CREACIÓN') }}
                            </label>
                            <input class="form-control form-control-sm" value="{{ $inventarioingreso->created_at }}"
                                disabled>
                        </div>

                        <div class="form-group col-md-4 g-3">
                            <label for="estado" class="text-sm"class="text-sm">
                                {{ __('ESTADO DE LA ORDEN') }}
                            </label>
                            <input class="form-control form-control-sm" value="{{ $inventarioingreso->estado }}"
                                disabled>
                        </div>

                        <div class="form-group col-md-4 g-3">
                            <label for="creador" class="text-sm">
                                {{ __('CREADOR DE LA ORDEN') }}
                            </label>
                            <input class="form-control form-control-sm"
                                value="{{ $inventarioingreso->usuario_ordencompra }}" disabled>
                        </div>

                        <div class="form-group col-md-4 g-3">
                            <label for="inventarioingreso_fin" class="text-sm">
                                {{ __('ORDEN PAGADA POR') }}
                            </label>
                            <input class="form-control form-control-sm"
                                value="{{ $inventarioingreso->usuario_cancelacion }}" disabled>
                        </div>

                        <div class="form-group col-md-4 g-3">
                            <label for="inventarioingreso_fin" class="text-sm">
                                {{ __('ORDEN RECEPCIONADA POR') }}
                            </label>
                            <input class="form-control form-control-sm"
                                value="{{ $inventarioingreso->usuario_recepcionista }}" disabled>
                        </div>
                         <div class="form-group col-md-4 g-3">
                            <label for="cotizacion" class="text-sm">
                                {{ __('CODIGO COTIZACION') }}
                            </label>
                            <input class="form-control form-control-sm"
                                value="{{ $inventarioingreso->cotizacion }}" disabled>
                        </div>
                    </div>

                    @if ($inventarioingreso->proveedor)
                        <div class="row mb-3">

                            <div class="form-group col-md-4 g-3">
                                <label for="documento_proveedor" class="text-sm">
                                    {{ __('RUC PROVEEDOR') }}
                                </label>
                                <div class="input-group">
                                    <input class="form-control form-control-sm"
                                        value="{{ $inventarioingreso->proveedor->ruc }}" disabled>

                                </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                <label for="datos_proveedor" class="text-sm">
                                    {{ __('RAZÓN SOCIAL PROVEEDOR') }}
                                </label>
                                <input class="form-control form-control-sm"
                                    value="{{ $inventarioingreso->proveedor->razon_social }}" disabled>
                            </div>


                            <div class="form-group col-md-12 g-3" >
                                <label for="descripcion" class="text-sm">
                                    {{ __('OBSERVACIÓN') }}
                                </label>
                                <textarea class="form-control form-control-sm" disabled>{{ $inventarioingreso->descripcion ? $inventarioingreso->descripcion : 'No hay observación' }}</textarea>
                            </div>
                            

                        </div>
                    @endif



                    



                    <div class="mt-2 table-responsive">
                        @if (count($inventarioingreso->productos) > 0)
                            <table class="table  table-striped table-hover">
                                <thead>
                                    <tr class="text-center" style="font-size: 14px">

                                        <th scope="col">
                                            {{ __('PRODUCTO DEL REQUERIMIENTO') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('CANTIDAD') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('UNIDAD') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('PRECIO UNITARIO') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('SUBTOTAL') }}
                                        </th>


                                        <th scope="col">
                                            {{ __('GUIA DE INGRESO AL ALMACEN') }}
                                        </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventarioingreso->productos as $producto)
                                        <tr class="text-center" style="font-size: 12.5px">
                                            <td scope="row">
                                                {{ $producto->nombre_producto }}
                                            </td>
                                            <td scope="row">
                                                {{ $producto->pivot->cantidad }}
                                            </td>

                                            <td>
                                                @if ($producto->unidad)
                                                    {{ $producto->unidad->nombre }}
                                                @endif
                                            </td>
                                            <td scope="row">
                                                {{ $producto->pivot->precio }}
                                            </td>
                                            <td scope="row" class="text-right">
                                                {{ $producto->pivot->subtotal }}
                                            </td>


                                            <td scope="row">
                                                {{ $producto->pivot->guiaingresoalmacen }}
                                            </td>

                                        </tr>
                                    @endforeach


                                    <tr class="table-warning">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>SUMA: </td>

                                        <td class="text-end">
                                            <div class="text-right">
                                                {{ $inventarioingreso->suma>0 ? number_format($inventarioingreso->suma, 2) : number_format($inventarioingreso->subtotal, 2)  }}</div>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>



                            </table>
                        @endif
                    </div>

                    <p class="text-center h6 mb-3"> DESCUENTO: {{ number_format($inventarioingreso->descuento, 2) }}
                        </p>

                    <p class="text-center h6 mb-3"> SUBTOTAL: {{ number_format($inventarioingreso->subtotal, 2) }}
                       </p>
                    <p class="text-center h4 mb-3"> COSTO TOTAL: {{ number_format($inventarioingreso->total, 2) }}
                        {{ $inventarioingreso->tipomoneda }}</p>


                    <div class="row">





                        <div class="form-group col-md-4 g-3">
                            <label for="tipocomprobante" class="text-sm">
                                {{ __('COMPROBANTE') }}
                            </label>
                            <input class="form-control form-control-sm"
                                value="{{ $inventarioingreso->tipocomprobante }}" disabled>
                        </div>

                        <div class="form-group col-md-4 g-3">
                            <label for="comprobante_correlativo" class="text-sm">
                                {{ __('CORRELATIVO') }}
                            </label>
                            <input class="form-control form-control-sm" type="text"
                                value="{{ $inventarioingreso->comprobante_correlativo }}" disabled>
                        </div>



                        <div class="form-group col-md-4 g-3">
                            <label for="fecha_emision_comprobante" class="text-sm">
                                {{ __('FECHA EMISIÓN') }}
                            </label>
                            <input class="form-control form-control-sm" type="text"
                                value="{{ $inventarioingreso->fecha_emision_comprobante }}" disabled>
                        </div>





                        <div class="form-group col-md-3 g-3">
                            <label for="estado_pago" class="text-sm">
                                {{ __('ESTADO PAGO') }}
                            </label>
                            <input class="form-control form-control-sm" type="text"
                                value="{{ $inventarioingreso->estado_pago }}" disabled>
                        </div>


                        <div class="form-group col-md-3 g-3">
                            <label for="fecha_cancelacion" class="text-sm">
                                {{ __('FECHA DE CANCELACIÓN') }}
                            </label>
                            <input class="form-control form-control-sm"
                                value="{{ $inventarioingreso->fecha_cancelacion }}" disabled>
                        </div>

                        <div class="form-group col-md-3 g-3">
                            <label for="tipopago" class="text-sm">
                                {{ __('TIPO PAGO') }}
                            </label>
                            <input class="form-control form-control-sm" type="text"
                                value="{{ $inventarioingreso->tipopago }}" disabled>
                        </div>


                        @if ($inventarioingreso->tipomoneda == 'DOLARES')
                            <div class="form-group col-md-3 g-3">
                                <label for="cambio_dia" class="text-sm">
                                    {{ __('CAMBIO DEL DÍA') }}
                                </label>
                                <input class="form-control form-control-sm" type="text"
                                    value="{{ number_format($inventarioingreso->cambio_dolar_precio_venta, 2) }}"
                                    disabled>
                            </div>
                        @endif



                        <div class="mt-2 table-responsive">
                            @if (count($inventarioingreso->pagosacuenta) > 0)
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">
                                                {{ __('FECHA DE PAGO O ADELANTO A CUENTA') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('MONTO') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('COMPROBANTE CORRELATIVO') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventarioingreso->pagosacuenta as $pago)
                                            <tr class="text-center">
                                                <td scope="row">
                                                    {{ $pago->fecha_pago }}
                                                </td>
                                                <td scope="row">
                                                    {{ $pago->monto }}
                                                </td>
                                                <td scope="row">
                                                    {{ $pago->comprobante_correlativo }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
