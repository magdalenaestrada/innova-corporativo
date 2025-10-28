<div class="modal fade text-left" id="ModalEditar{{ $salidacuenta->id }}" tabindex="-1" role="dialog" aria-hidden="true">

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
                <form class="editar-salidacuenta" action="{{ route('tssalidascuentas.update', $salidacuenta->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">



                        <!-- For Documento Beneficiario -->
                        <div class="form mb-1 col-md-4">
                            <label for="documento_beneficiario"
                                class="text-sm">{{ __('DOCUMENTO BENEFICIARIO') }}</label>
                            <input disabled name="documento_beneficiario"
                                value="{{ $salidacuenta->beneficiario ? $salidacuenta->beneficiario->documento : '' }}"
                                id="documento_beneficiario" class=" form-control form-control-sm"
                                placeholder="Documento del beneficiario..." type="text">
                        </div>

                        <!-- For Nombre Beneficiario -->
                        <div class="form col-md-8 mb-2">
                            <label for="nombre_beneficiario" class="text-sm">{{ __('NOMBRE BENEFICIARIO') }}</label>
                            <input disabled name="nombre_beneficiario"
                                value="{{ $salidacuenta->beneficiario ? $salidacuenta->beneficiario->nombre : '' }}"
                                id="nombre_beneficiario" class=" form-control form-control-sm"
                                placeholder="Nombre del beneficiario..." type="text">
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="tipo_comprobante" class="text-sm">
                                {{ __('TIPO DE COMPROBANTE') }}
                            </label>
                            <select name="tipocomprobante_id" class="buscador form-control form-control-sm" id="tipocomprobante"
                                style="width: 100%">
                                @if ($salidacuenta->tipocomprobante)
                                    <option selected value="{{ $salidacuenta->tipocomprobante->id }}">
                                        {{ $salidacuenta->tipocomprobante->nombre }}</option>
                                @else
                                    <option value="">Seleccione un comprobante...</option>
                                @endif



                                @foreach ($tiposcomprobantes as $tipocomprobante)
                                    @if ($salidacuenta->tipocomprobante)
                                        @if ($salidacuenta->tipocomprobante->id !== $tipocomprobante->id)
                                            <option value="{{ $tipocomprobante->id }}">{{ $tipocomprobante->nombre }}
                                            </option>
                                        @endif
                                    @else
                                        <option value="{{ $tipocomprobante->id }}">{{ $tipocomprobante->nombre }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

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
                            <select name="cuenta_id" class="buscador form-control form-control-sm" id="cuenta"
                                style="width: 100%">
                                <option selected value="{{ $salidacuenta->cuenta->id }}">
                                    {{ $salidacuenta->cuenta->nombre }}</option>
                                @foreach ($cuentas as $cuenta)
                                    @if ($salidacuenta->cuenta->id !== $cuenta->id)
                                        <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>

                        </div>




                        <div class="form-group col-md-6 g-3">
                            <label for="motivo" class=" text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>


                            <select name="motivo_id" class="buscador form-control form-control-sm" id="motivoo"
                                style="width: 100%">
                                <option selected value="{{ $salidacuenta->motivo->id }}">
                                    {{ $salidacuenta->motivo->nombre }}</option>
                                @foreach ($motivos as $motivo)
                                    @if ($salidacuenta->motivo->id !== $motivo->id)
                                        <option value="{{ $motivo->id }}">{{ $motivo->nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="descripcion" class=" text-sm">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            <br>
                            <input name="descripcion"
                                value="{{ $salidacuenta->descripcion ? $salidacuenta->descripcion : '' }}"
                                id="descripcion" class=" form-control form-control-sm" placeholder="Descripcion"
                                type="text">

                        </div>

                        <div class="form col-md-6 mb-3">
                            <label for="fecha" class="text-sm">
                                {{ __('FECHA') }}
                            </label>
                            <input name="fecha" id="fecha" class="form-control form-control-sm"
                                placeholder="Ingrese la fecha"
                                value="{{ $salidacuenta->fecha ? \Carbon\Carbon::parse($salidacuenta->fecha)->format('Y-m-d') : '' }}"
                                type="date">
                            <span class="input-border"></span>
                        </div>


                        <div class="form-group  col-md-6 g-3">
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
</div>
