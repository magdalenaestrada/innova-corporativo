<div class="modal fade text-left" id="ModalEditar{{ $ingresocuenta->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
         

            <div class="card-header row justify-content-between">
                        <div class="col-md-6">
                            <h6 class="mt-2">
                                {{ __('EDITAR INGRESO A LA CUENTA') }}
                            </h6>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                                <img style="width: 15px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
                            </button>
                        </div>
            </div>
        
            <div class="card-body">
                    <form class="editar-ingresocuenta" action="{{ route('tsingresoscuentas.update', $ingresocuenta->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            

                            <!-- For Documento Beneficiario -->
                            <div class="form mb-1 col-md-4">
                                <label for="documento_cliente" class="text-sm">{{ __('DOCUMENTO DE QUIEN ENTREGA') }}</label>
                                <input disabled name="documento_beneficiario" value="{{$ingresocuenta->cliente ? $ingresocuenta->cliente->documento : '' }}" id="documento_beneficiario" class=" form-control form-control-sm" placeholder="Documento del beneficiario..." type="text">
                            </div>   

                            <!-- For Nombre Beneficiario -->
                            <div class="form col-md-8 mb-2">
                                <label for="nombre_beneficiario" class="text-sm">{{ __('NOMBRE DE QUIEN ENTREGA') }}</label>
                                <input disabled name="nombre_beneficiario" value="{{$ingresocuenta->cliente ? $ingresocuenta->cliente->nombre : '' }}" id="nombre_beneficiario" class=" form-control form-control-sm" placeholder="Nombre del beneficiario..." type="text">
                            </div>

                            <div class="form-group col-md-6 g-3">
                                <label for="tipo_comprobante" class="text-sm">
                                    {{ __('TIPO DE COMPROBANTE') }}
                                </label>
                                <br>
                                <input disabled name="tipo_comprobante" value="{{$ingresocuenta->tipocomprobante ? $ingresocuenta->tipocomprobante->nombre : '' }}" id="tipo_comprobante" class=" form-control form-control-sm" placeholder="Tipo de comprobante..." type="text">
                                
                            </div>


                            
                            <div class="form-group col-md-6 g-3">
                                <label for="nro_comprobante" class="text-sm">
                                    {{ __('CORRELATIVO COMPROBANTE') }}
                                </label>
                                <br>
                                <input disabled name="tipo_comprobante" value="{{$ingresocuenta->comprobante_correlativo ? $ingresocuenta->comprobante_correlativo : '' }}" id="comprobante_correlativo" class=" form-control form-control-sm" placeholder="Comprobante correlativo..." type="text">
                                
                            </div>




                        <div class="form-group col-md-6 g-3">
                            <label for="cuenta" class=" text-sm">
                                {{ __('CUENTA') }}
                            </label>
                            <br>
                            <input disabled name="cuenta" value="{{$ingresocuenta->cuenta ? $ingresocuenta->cuenta->nombre : '' }}" id="tipo_comprobante" class=" form-control form-control-sm" placeholder="Cuenta..." type="text">

                        </div>


                        <div class="form-group col-md-6 g-3">
                            <label for="motivo" class=" text-sm">
                                {{ __('MONEDA') }}
                            </label>
                            <br>
                            <input disabled name="motivo" value="{{$ingresocuenta->cuenta->tipomoneda ? $ingresocuenta->cuenta->tipomoneda->nombre : '' }}" id="moneda" class=" form-control form-control-sm" placeholder="Moneda..." type="text">

                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="motivo" class=" text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <input disabled name="motivo" value="{{$ingresocuenta->motivo ? $ingresocuenta->motivo->nombre : '' }}" id="motivo" class=" form-control form-control-sm" placeholder="Moneda..." type="text">

                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="descripcion" class=" text-sm">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            <br>
                            <input name="descripcion" value="{{$ingresocuenta->descripcion ? $ingresocuenta->descripcion : '' }}"  id="descripcion" class=" form-control form-control-sm" placeholder="Descripcion"  type="text">

                        </div>



                        
                        <div class="form col-md-6 mb-3">
                            <label for="fecha" class="text-sm">
                                {{ __('FECHA') }}
                            </label>
                            <input name="fecha" id="fecha" class="form-control form-control-sm"
                                placeholder="Ingrese la fecha" value="{{ $ingresocuenta->fecha ? \Carbon\Carbon::parse($ingresocuenta->fecha)->format('Y-m-d') : '' }}" type="date">
                            <span class="input-border"></span>
                        </div>

                        

                        <div class="form-group  col-md-6 g-3">
                            <label for="monto" class="text-sm">
                                {{ __('MONTO') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="text" value="{{$ingresocuenta->monto}}" name="monto" id="monto" class="form-control form-control-sm" value="{{ old('nombre_ingresocuenta') }}" placeholder="Monto...">
                          
                        </div>
    
                            





                            <div class="col-md-12 text-right g-3">
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
           
            
    
        </div>
    </div>
</div>





