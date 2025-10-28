@extends('admin.layout')
@section('content')
    <div class="modal-dialog modal-lg" role="document">
        <br>
        <div class="modal-content">


            <div class="card-header row justify-content-between">
                <div class="col-md-6">
                    <h6 class="mt-2">
                        {{ __('EDITAR SALIDA DE LA CUENTA') }}
                    </h6>
                </div>
                <div class="col-md-6 text-right">
                    <a type="button" class="btn btn-sm btn-danger" href="{{ route('tssalidascuentas.index') }}">
                        VOLVER
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form class="editar-salidacuenta" action="{{ route('tssalidascuentas.update', $salidacuenta->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">



                        <!-- For Documento Beneficiario -->
                        <div class="form mb-1 col-md-4">
                            <label for="documento_beneficiario" class="text-sm">{{ __('DOCUMENTO BENEFICIARIO') }}</label>
                            <input disabled name="documento_beneficiario"
                                value="{{ $salidacuenta->beneficiario ? $salidacuenta->beneficiario->documento : '' }}"
                                id="documento_beneficiario11" class=" form-control form-control-sm buscador"
                                placeholder="Documento del beneficiario..." type="text">
                        </div>

                        <!-- For Nombre Beneficiario -->
                        <div class="form col-md-8 mb-2">
                            <label for="nombre_beneficiario" class="text-sm">{{ __('NOMBRE BENEFICIARIO') }}</label>
                            <input disabled name="nombre_beneficiario"
                                value="{{ $salidacuenta->beneficiario ? $salidacuenta->beneficiario->nombre : '' }}"
                                id="nombre_beneficiario" class="budcador form-control form-control-sm"
                                placeholder="Nombre del beneficiario..." type="text">
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="tipo_comprobante" class="text-sm">
                                {{ __('TIPO DE COMPROBANTE') }}
                            </label>
                            <br>
                            <input disabled name="tipo_comprobante"
                                value="{{ $salidacuenta->tipocomprobante ? $salidacuenta->tipocomprobante->nombre : '' }}"
                                id="tipo_comprobante" class=" form-control form-control-sm"
                                placeholder="Tipo de comprobante..." type="text">

                        </div>



                        <div class="form-group col-md-6 g-3">
                            <label for="nro_comprobante" class="text-sm">
                                {{ __('CORRELATIVO COMPROBANTE') }}
                            </label>
                            <br>
                            <input name="comprobante_correlativo"
                                value="{{ $salidacuenta->comprobante_correlativo ? $salidacuenta->comprobante_correlativo : '' }}"
                                id="comprobante_correlativo" class=" form-control form-control-sm"
                                placeholder="Comprobante correlativo..." type="text">

                        </div>




                        <div class="form-group col-md-6 g-3">
                            <label for="cuenta" class=" text-sm">
                                {{ __('CUENTA') }}
                            </label>
                            <br>
                            <input disabled name="cuenta"
                                value="{{ $salidacuenta->cuenta ? $salidacuenta->cuenta->nombre : '' }}"
                                id="tipo_comprobante" class=" form-control form-control-sm" placeholder="Cuenta..."
                                type="text">

                        </div>


                        <div class="form-group col-md-6 g-3">
                            <label for="motivo" class=" text-sm">
                                {{ __('MONEDA') }}
                            </label>
                            <br>
                            <input disabled name="motivo"
                                value="{{ $salidacuenta->cuenta->tipomoneda ? $salidacuenta->cuenta->tipomoneda->nombre : '' }}"
                                id="moneda" class=" form-control form-control-sm" placeholder="Moneda..." type="text">

                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="motivo" class=" text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <input disabled name="motivo"
                                value="{{ $salidacuenta->motivo ? $salidacuenta->motivo->nombre : '' }}" id="motivo"
                                class=" form-control form-control-sm" placeholder="Moneda..." type="text">

                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="descripcion" class=" text-sm">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            <br>
                            <input name="descripcion"
                                value="{{ $salidacuenta->descripcion ? $salidacuenta->descripcion : '' }}" id="descripcion"
                                class=" form-control form-control-sm" placeholder="Descripcion" type="text">

                        </div>


                        <div class="form-group  col-md-12 g-3">
                            <label for="monto" class="text-sm">
                                {{ __('MONTO') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="text" value="{{ $salidacuenta->monto }}" name="monto" id="monto"
                                class="form-control form-control-sm" value="{{ old('nombre_salidacuenta') }}"
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
@stop
