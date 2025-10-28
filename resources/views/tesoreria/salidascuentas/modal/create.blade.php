<div class="modal fade text-left" id="ModalCreate" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REGISTRAR SALIDA DE LA CUENTA') }}
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
                <form class="crear-salidacuenta" action="{{ route('tssalidascuentas.store') }}" method="POST">
                    @csrf
                    <div class="row">






                        <div class="form input-group mb-1 col-md-4">
                            <input name="documento" id="documento" class="form-control form-control-sm"
                                placeholder="Documento del beneficiario..." type="text">
                            <span class="input-border"></span>

                            <button class="btn btn-sm btn-success" type="button" style="width:30.5px; height:30.5px"
                                id="buscar_beneficiario_btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                    viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                    <path
                                        d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <div class="form col-md-8 mb-2">
                            <input name="nombre" id="nombre" class="form-control form-control-sm"
                                placeholder="Valide el nombre del beneficiario..." type="text">
                            <span class="input-border"></span>
                        </div>




                        <div class="form-group col-md-5 g-3">
                            <label for="tipo_comprobante" class="text-sm">
                                {{ __('TIPO DE COMPROBANTE') }}
                            </label>
                            <br>
                            <select name="tipo_comprobante_id"  id="tipo_comprobanteC"
                                class="form-control form-control-sm buscador @error('tipo_comprobante') is-invalid @enderror"
                                aria-label="" style="width: 100%">
                                <option selected value="">
                                    Seleccione el tipo de comprobante
                                </option>
                                @foreach ($tiposcomprobantes as $tipocomprobante)
                                    <option value="{{ $tipocomprobante->id }}"
                                        {{ old('banco') == $tipocomprobante->id ? 'selected' : '' }}>
                                        {{ $tipocomprobante->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipocomprobante')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form col-md-4" style="margin-top: 28px">
                            <input name="comprobante_correlativo" id="comprobante_correlativo"
                                class="form-control form-control-sm"
                                placeholder="Correlativo del comprobante..." type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="form col-md-3 ">
                            <label for="monto" class="text-sm">
                                {{ __('NRO OPERACIÓN') }}
                            </label>
                            <input name="nro_operacion" style="margin-top:-3px" id="monto" class="form-control form-control-sm"
                                placeholder="Nro operación..."  type="text">
                            <span class="input-border"></span>
                        </div>




                        <div style="margin-top: -2px" class="form-group col-md-12 g-3">
                            <label for="cuenta" class="text-sm">
                                {{ __('CUENTA') }}
                            </label>
                            <br>
                            <select name="cuenta_id" id="cuentaC"
                                class="form-control form-control-sm buscador @error('cuenta') is-invalid @enderror"
                                aria-label="" style="width: 100%" required="">
                                <option selected value="">
                                    Seleccione la cuenta
                                </option>
                                @foreach ($cuentas as $cuenta)
                                    <option value="{{ $cuenta->id }}"
                                        {{ old('cuenta') == $cuenta->id ? 'selected' : '' }}>
                                        {{ $cuenta->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cuenta')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group col-md-12 g-3">
                            <label for="motivo" class="text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <select name="motivo_id" id="motivoC"
                                class=" form-control form-control-sm buscador @error('cuenta') is-invalid @enderror"
                                aria-label="" style="width: 100%" required>
                                <option selected value="">
                                    Seleccione el motivo
                                </option>
                                @foreach ($motivos as $motivo)
                                    <option value="{{ $motivo->id }}"
                                        {{ old('motivo') == $motivo->id ? 'selected' : '' }}>
                                        {{ $motivo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('motivo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form col-md-12 mb-3">
                            <label for="descripcion" class="text-sm">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            <input name="descripcion" id="descripcion" class="form-control form-control-sm"
                                placeholder="Ingrese una descripción" type="text">
                            <span class="input-border"></span>
                        </div>


                        <div class="form col-md-6 mb-3">
                            <label for="fecha" class="text-sm">
                                {{ __('FECHA') }}
                            </label>
                            <input name="fecha" id="fecha" class="form-control form-control-sm"
                                placeholder="Ingrese la fecha" value="{{ date('Y-m-d') }}" type="date">
                            <span class="input-border"></span>
                        </div>



                        <div class="form col-md-6 mb-3">
                            <label for="monto" class="text-sm">
                                {{ __('MONTO') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input name="monto" id="monto" class="form-control form-control-sm"
                                placeholder="Ingrese el monto" required="" type="text">
                            <span class="input-border"></span>
                        </div>









                        <div class="col-md-12 text-right g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('GUARDAR') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
