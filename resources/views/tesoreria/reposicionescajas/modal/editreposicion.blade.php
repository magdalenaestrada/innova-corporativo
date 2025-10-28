<div class="modal fade text-left" id="ModalEditar{{ $reposicioncaja->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="card-header row justify-content-between">
                <div class="col-md-6">
                    <h6 class="mt-2">
                        {{ __('EDITAR SALIDA DE LA CUENTA') }}
                    </h6>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" style="font-size: 30px" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <img style="width: 15px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
                    </button>
                </div>
            </div>

            <div class="card-body">
                <form class="editar-salidacuenta" action="{{ route('tsreposicionescajas.update', $reposicioncaja->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">



                        <!-- For Documento Beneficiario -->
                        <div class="form mb-1 col-md-4">
                            <label for="caja" class="text-sm">{{ __('CAJA') }}</label>
                            <input disabled name="caja"
                                value="{{ $reposicioncaja->caja ? $reposicioncaja->caja->nombre : '' }}"
                                id="documento_beneficiario" class=" form-control form-control-sm"
                                placeholder="Documento del beneficiario..." type="text">
                        </div>

                        <!-- For Nombre Beneficiario -->
                        <div class="form col-md-8 mb-2">
                            <label for="cuenta_procedencia" class="text-sm">{{ __('CUENTA DE PROCEDENCIA') }}</label>
                            <input disabled name="cuenta_procedencia"
                                value="{{ $reposicioncaja->salidacuenta ? $reposicioncaja->salidacuenta->cuenta->nombre : '' }}"
                                id="cuenta_procedencia" class=" form-control form-control-sm"
                                placeholder="Nombre del beneficiario..." type="text">
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="tipo_comprobante" class="text-sm">
                                {{ __('TIPO DE COMPROBANTE') }}
                            </label>
                            <br>
                            <input disabled name="tipo_comprobante"
                                value="{{ $reposicioncaja->salidacuenta->tipocomprobante ? $reposicioncaja->salidacuenta->tipocomprobante->nombre : '' }}"
                                id="tipo_comprobante" class=" form-control form-control-sm"
                                placeholder="Tipo de comprobante..." type="text">

                        </div>



                        <div class="form-group col-md-6 g-3">
                            <label for="nro_comprobante" class="text-sm">
                                {{ __('NRO COMPROBANTE') }}
                            </label>
                            <br>
                            <input disabled name="tipo_comprobante"
                                value="{{ $reposicioncaja->salidacuenta ? $reposicioncaja->salidacuenta->comprobante_correlativo : '' }}"
                                id="comprobante_correlativo" class=" form-control form-control-sm"
                                placeholder="Comprobante correlativo..." type="text">

                        </div>


                



                        <div class="form-group col-md-12 g-3">
                            <label for="motivo" class=" text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <input disabled name="motivo"
                                value="{{ $reposicioncaja->motivo ? $reposicioncaja->motivo->nombre : '' }}" id="motivo"
                                class=" form-control form-control-sm" placeholder="Moneda..." type="text">

                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="descripcion" class=" text-sm">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            <br>
                            <input name="descripcion"
                                value="{{ $reposicioncaja->descripcion ? $reposicioncaja->descripcion : '' }}" id="descripcion"
                                class=" form-control form-control-sm" placeholder="Descripcion" type="text">

                        </div>


                        <div class="form col-md-6 mb-3">
                            <label for="fecha" class="text-sm">
                                {{ __('FECHA') }}
                            </label>
                            <input name="fecha" id="fecha" class="form-control form-control-sm"
                                placeholder="Ingrese la fecha" value="{{ $reposicioncaja->salidacuenta->fecha ? \Carbon\Carbon::parse($reposicioncaja->salidacuenta->fecha)->format('Y-m-d') : '' }}" type="date">
                            <span class="input-border"></span>
                        </div>


                        <div class="form-group  col-md-6 g-3">
                            <label for="monto" class="text-sm">
                                {{ __('MONTO') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="text" value="{{ $reposicioncaja->monto }}" name="monto" id="monto"
                                class="form-control form-control-sm" value="{{ old('monto') }}"
                                placeholder="Monto...">

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
