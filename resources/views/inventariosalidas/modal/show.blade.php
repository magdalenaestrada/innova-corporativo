<div class="modal fade text-left" id="ModalShow{{ $inventariosalida->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
                <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('REQUERIMIENTO') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                                    <img style="width: 15px" src="{{asset('images/icon/close.png')}}" alt="cerrar">
                                    
                                </button>
                            </div>
                        </div>
                </div>
                <div class="card-body">
                        
                        <div class="row">
                            



                            <div class="form-group col-md-4 g-3">
                                <label for="fecha" class="text-sm">
                                    {{ __('FECHA DE CREACIÓN') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventariosalida->created_at }}" disabled>
                            </div>




                            <div class="form-group col-md-4 g-3">
                                <label for="estado" class="text-sm">
                                    {{ __('ESTADO DEL REQUERIMIENTO') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventariosalida->estado }}" disabled>
                            </div>


                            <div class="form-group col-md-4 g-3">
                                <label for="creador" class="text-sm" >
                                    {{ __('CREADOR') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventariosalida->usuario_requerimiento }}"
                                    disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="documento_solicitante" class="text-sm">
                                    {{ __('DOCUMENTO SOLICITANTE') }}
                                </label>
                                <div class="input-group">
                                    <input class="form-control form-control-sm"
                                        value="{{ $inventariosalida->documento->documento_solicitante }}" disabled>
                                    
                                </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                <label for="nombre_solicitante" class="text-sm">
                                    {{ __('NOMBRE SOLICITANTE') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventariosalida->documento->nombre_solicitante }}"
                                    disabled>
                            </div>




                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion" class="text-sm">
                                    {{ __('DESCRIPCIÓN') }}
                                </label>
                                <textarea class="form-control form-control-sm" disabled>{{ $inventariosalida->descripcion ? $inventariosalida->descripcion : 'No hay observación' }}</textarea>
                            </div>

                            <div class="mt-2 col-md-12">
                                @if (count($inventariosalida->productos) > 0)
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
                                                    {{ __('FECHA DE CREACIÓN') }}
                                                </th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventariosalida->productos as $producto)
                                                <tr class="text-center">
                                                    <td scope="row">
                                                        {{ $producto->nombre_producto }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->cantidad }}
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

                            <div class="form-group col-md-4 g-3">
                                <label for="codigo" class="text-sm">
                                    {{ __('CÓDIGO DE REQUERIMIENTO') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventariosalida->documento->codigo }}" disabled>
                            </div>


                            <div class="form-group col-md-4 g-3">
                                <label for="area" class="text-sm">
                                    {{ __('AREA SOLICITANTE') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventariosalida->documento->area_solicitante }}"
                                    disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="prioridad" class="text-sm">
                                    {{ __('PRIORIDAD') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $inventariosalida->documento->prioridad }}" disabled>
                            </div>



                         



                        </div>
                </div>
        </div>
    </div>
</div>

  


