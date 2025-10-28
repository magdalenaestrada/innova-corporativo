<div class="modal fade text-left" id="ModalCancelarCredito{{ $inventarioingreso->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
               

                <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('CANCELAR AL CRÉDITO') }}
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
                        
                        <div class="row" style="margin-top: -7px">
                        
                            <div class="form-group col-md-4 g-3">
                                <label  class="text-sm">
                                    {{ __('FECHA DE CREACIÓN') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventarioingreso->created_at }}" disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label class="text-sm">
                                    {{ __('CREADOR DE LA ORDEN') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventarioingreso->usuario_ordencompra }}" disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label class="text-sm">
                                    {{ __('ESTADO DE LA ORDEN') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventarioingreso->estado }}" disabled>
                            </div>



                            
                            @if($inventarioingreso->proveedor)
                            <div class="form-group col-md-4 g-3">
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
                        
                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion" class="text-sm">
                                    {{ __('DESCRIPCIÓN') }}
                                </label>
                                <textarea class="form-control form-control-sm" disabled>{{ $inventarioingreso->descripcion ? $inventarioingreso->descripcion : 'No hay observación' }}</textarea>
                            </div>



                            <div class="form-group col-md-12  table-responsive">
                                @if (count($inventarioingreso->productos) > 0)
                                    <table class="table  table-striped table-hover">
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

                            <p class="text-center col-md-12 h6" style="margin-top: -12px"> SUBTOTAL: {{ $inventarioingreso->subtotal }} {{ $inventarioingreso->tipomoneda }}</p>
                            <p class="text-center col-md-12 h5"> COSTO TOTAL: {{ $inventarioingreso->total }} {{ $inventarioingreso->tipomoneda }}</p>

                            


                            <form class="form-group col-md-12 g-3" action="{{ route('inventarioingresos.updatecancelaralcredito', $inventarioingreso->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group col-md-5 g-3">
                                        <label for="fecha_pago_al_credito" class="text-sm">
                                            {{ __('FECHA DE CANCELACIÓN AL CRÉDITO') }}
                                        </label>
                                        <input class="form-control form-control-sm" type="datetime-local" name="fecha_pago_al_credito">
                                </div>



                                <div class="col-md-12 text-right g-3 ">
                                    <button type="submit" class="btn btn-sm btn-info  ">
                                        {{ __('CANCELAR ORDEN DE COMPRA AL CRÉDITO') }}
                                    </button>
                                </div>

                            </form>

                        </div>
               </div>

                
        </div>
    </div>
</div>
