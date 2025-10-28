<div class="modal fade text-left" id="ModalCancelarACuenta{{ $inventarioingreso->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('CANCELAR ORDEN DE COMPRA A CUENTA') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                                    <img style="width: 15px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                      
                            <div class="row" style="margin-top: -8px">
                                <div class="form-group col-md-4">
                                    <label for="inventarioingreso_fin" class="text-sm">
                                        {{ __('FECHA DE CREACIÓN') }}
                                    </label>
                                    <input class="form-control form-control-sm" value="{{ $inventarioingreso->created_at }}" disabled>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inventarioingreso_fin" class="text-sm">
                                        {{ __('CREADOR DE LA ORDEN') }}
                                    </label>
                                    <input class="form-control form-control-sm" value="{{ $inventarioingreso->usuario_ordencompra }}" disabled>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inventarioingreso_fin" class="text-sm">
                                        {{ __('ESTADO DE LA ORDEN') }}
                                    </label>
                                    <input class="form-control form-control-sm" value="{{ $inventarioingreso->estado }}" disabled>
                                </div>
                                @if($inventarioingreso->proveedor)
                                <div class="form-group col-md-4 g-3" >
                                        <label for="documento_proveedor" class="text-sm">
                                            {{ __('RUC PROVEEDOR') }}
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" value="{{ $inventarioingreso->proveedor->ruc }}"
                                                disabled>
                                            
                                        </div>
                                </div>
                                <div class="form-group col-md-8 g-3">
                                        <label for="datos_proveedor" class="text-sm">
                                            {{ __('RAZÓN SOCIAL PROVEEDOR') }}
                                        </label>
                                        <input class="form-control form-control-sm" value="{{ $inventarioingreso->proveedor->razon_social }}" disabled>
                                </div>
                                @endif
                            </div>
                            
                            
                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion" class="text-sm">
                                    {{ __('OBSERVACIÓN') }}
                                </label>
                                <textarea class="form-control form-control-sm" disabled>{{ $inventarioingreso->descripcion ? $inventarioingreso->descripcion : 'No hay observación' }}</textarea>
                            </div>
                        
                            <div class="mt-2 col-md-12 table-responsive">
                                @if (count($inventarioingreso->productos) > 0)
                                    <table class="table table-striped  table-hover">
                                        <thead>
                                            <tr class="text-center">

                                                <th scope="col">
                                                    {{ __('PRODUCTO DEL REQUERIMIENTO') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('CANTIDAD') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('PRECIO') }}
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
                                            @foreach ($inventarioingreso->productos as $producto)
                                                <tr class="text-center">
                                                    <td scope="row">
                                                        {{ $producto->nombre_producto }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->cantidad }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->precio }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->subtotal }}
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

                            <p class="text-center h6 col-md-12"> SUBTOTAL: {{ $inventarioingreso->subtotal }} {{ $inventarioingreso->tipomoneda }}</p>
                            <p class="text-center h5 col-md-12  "> COSTO TOTAL: {{ $inventarioingreso->total }} {{ $inventarioingreso->tipomoneda }}</p>
                                                        
                            <form action="{{ route('inventarioingresos.updatecancelaracuenta', $inventarioingreso->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                

                                
                                
                                <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                                <th>
                                                    {{ __('FECHA DE PAGO O ADELANTO') }}
                                                </th>

                                                <th>
                                                    {{ __('MONTO PAGADO') }}
                                                </th>

                                                <th>
                                                    {{ __('COMPROBANTE CORRELATIVO') }}
                                                </th>

                                                <th>
                                                    <button class="btn btn-sm btn-outline-dark pull-right"  type="button" onclick="create_tr('table_body2')" id="add"><img  style="width: 10px" src="{{ asset('images/icon/mas.png') }}" alt="imprimir"></button>

                                                </th>
                                        </tr>                                        
                                        </thead>


                                        <tbody id="table_body2">
                                            <tr>
                                                
                                                <td>
                                                    <input name="fechas_pagos[]" type="date" class="form-control form-control-sm pago-fecha" 
                                                    value="" required />
                                                </td>
                                                <td>
                                                    <input name="montos[]" type="number" step="0.01"  placeholder="0"
                                                    class="form-control form-control-sm pago-monto" required  >
                                                </td>
                                                <td>
                                                    <input name="comprobantes[]" type="text"   placeholder="0"
                                                    class="form-control form-control-sm pago-comprobante" style="max-width: 150px" required>
                                                </td>
                                                
                                                <td>
                                                    <button class="btn btn-sm btn-danger" onclick="remove_tr(this)" type="button">Quitar</button>

                                                </td>
                                            </tr>
                                        </tbody>




                                        
                                </table>
                                
                                

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
    
        
                                <div class="col-md-12 text-right g-3 ">
                                    <button type="submit" class="btn btn-sm btn-info ">
                                        {{ __('CANCELAR ORDEN DE COMPRA A CUENTA') }}
                                    </button>
                                </div>

                            </form>

                        
                    </div>
            </div>
    </div>
</div>

<script src="{{ asset('js/interactive.js') }}"></script>
    
<script src="{{ asset('js/packages/jquery.min.js') }}"></script>


