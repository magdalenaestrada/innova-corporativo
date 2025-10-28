<div class="modal fade text-left" id="ModalEdit{{ $adelanto->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="card-header row justify-content-between">
                <div class="col-md-6">
                    <h6 class="mt-2">
                        {{ __('EDITAR ADELANTO') }}
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
                <form class="editar-adelanto" action="{{ route('lqadelantos.update', $adelanto->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">



                        <div class="row">




                            <div class="form-group col-md-12 g-3">
                                <label for="sociedad" class="text-sm">
                                    {{ __('SOCIEDAD') }}
                                </label>
                                <br>
                                <select id="sociedad-edit_id" name="sociedad_id" class="form-control buscador form-control-sm">
                                    <!-- Default selected option -->
                                    <option  selected value="{{ $adelanto->sociedad->id }}">
                                        {{ $adelanto->sociedad->id }}.   {{ $adelanto->sociedad->nombre }}
                                    </option>

                                    <!-- Loop through $cuentas, excluding the selected account -->
                                    
                                    @foreach ($sociedades as $sociedad)
                                        @if ($sociedad->id != $adelanto->sociedad->id)
                                            
                                            <option value="{{ $sociedad->id }}">
                                                {{ $sociedad->id }}.     {{ $sociedad->nombre }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            




                            <div class="form mb-1 col-md-4">
                                <input disabled name="documento" class="form-control form-control-sm"
                                    placeholder="DOCUMENTO DEL REPRESENTANTE..." type="text"
                                    value="{{ $adelanto->representante_cliente_documento }}">
                                <span class="input-border"></span>
                            </div>

                            <div class="form col-md-8 mb-2">
                                <input disabled name="nombre" class="form-control form-control-sm"
                                    placeholder="NOMBRE DEL REPRESENTANTE DEL CLIENTE..." type="text"
                                    value="{{ $adelanto->representante_cliente_nombre }}">
                                <span class="input-border"></span>
                            </div>



                            <div class="form-group col-md-4 g-3">
                                <label for="tipo_comprobante" class="text-sm">
                                    {{ __('TIPO DE COMPROBANTE') }}
                                </label>
                                <br>
                                <input disabled name="tipocomprobante" class="form-control form-control-sm"
                                    placeholder="TIPO DE COMPROBANTE..." type="text"
                                    value="{{ $adelanto->salidacuenta->tipocomprobante ? $adelanto->salidacuenta->tipocomprobante->nombre : '' }}">
                            </div>


                            <div class="form col-md-4  mb-3">
                                <label for="comprobante_correlativo" class="text-sm">
                                    {{ __('NRO COMPROBANTE') }}
                                </label>
                                <input disabled name="comprobante_correlativo" class="form-control form-control-sm"
                                    placeholder="INGRESE EL CORRELATIVO DEL COMPROBANTE" type="text"
                                    value="{{ $adelanto->salidacuenta ? $adelanto->salidacuenta->comprobante_correlativo : '' }}">
                                <span class="input-border"></span>
                            </div>



                            <div class="form-group col-md-4 g-3">
                                <label for="cliente" class="text-sm">
                                    {{ __('RAZON SOCIAL FACTURA') }}
                                </label>
                                <br>
                                <input disabled name="comprobante_correlativo" class="form-control form-control-sm"
                                    placeholder="RAZON SOCIAL" type="text"
                                    value="{{ $adelanto->cliente ? $adelanto->cliente->nombre : '' }}">

                            </div>




                            <div class="form-group col-md-12 g-3">
                                <label for="cuenta" class="text-sm">
                                    {{ __('CUENTA') }}
                                </label>
                                <br>
                                <select id="cuenta-edit" name="cuenta_id" class="form-control form-control-sm">
                                    <!-- Default selected option -->
                                    <option  selected value="{{ $adelanto->salidacuenta->cuenta->id }}">
                                        {{ $adelanto->salidacuenta->cuenta->nombre }}
                                    </option>

                                    <!-- Loop through $cuentas, excluding the selected account -->
                                    
                                    @foreach ($cuentas as $cuenta)
                                        @if ($cuenta->id != $adelanto->salidacuenta->cuenta->id)
                                        @if ($cuenta->tipomoneda->id == $adelanto->salidacuenta->cuenta->tipomoneda->id )
                                            
                                            <option value="{{ $cuenta->id }}">
                                                {{ $cuenta->nombre }}
                                            </option>
                                        @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-9 g-3">
                                <label for="motivo" class="text-sm">
                                    {{ __('MOTIVO') }}
                                </label>
                                <br>
                                <input disabled name="comprobante_correlativo" class="form-control form-control-sm"
                                    placeholder="RAZON SOCIAL" type="text"
                                    value="{{ $adelanto->salidacuenta->motivo ? $adelanto->salidacuenta->motivo->nombre : '' }}">

                            </div>
                            <div class="form col-md-3 mb-3">
                                <label for="fecha" class="text-sm">
                                    {{ __('FECHA') }}
                                </label>
                                <input type="date"  name="fecha" class="form-control form-control-sm"
                                    placeholder="INGRESE LA FECHA" value="{{ $adelanto->fecha ? \Carbon\Carbon::parse($adelanto->fecha)->format('Y-m-d') : '' }}">
                                <span class="input-border"></span>
                            </div>



                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion" class="text-sm">
                                    {{ __('DESCRIPCIÓN') }}
                                </label>
                                <input name="descripcion"
                                    class="form-control form-control-sm @error('descripcion') is-invalid @enderror"
                                    placeholder="DESCRIPCIÓN..." value="{{ $adelanto->salidacuenta->descripcion }}">
                                @error('descripcion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="form col-md-6 mb-3">
                                <label for="SOLES" class="text-sm">
                                    {{ __('TOTAL') }}
                                </label>
                                <input name="monto" class="form-control form-control-sm"
                                    placeholder="TOTAL EN SOLES" required type="text"
                                    value="{{ $adelanto->salidacuenta ? $adelanto->salidacuenta->monto : '' }}">
                                <span class="input-border"></span>
                            </div>




                            <div class="form col-md-6 mb-3">
                                <label for="tipo_cambio" class="text-sm">
                                    {{ __('TIPO DE CAMBIO') }}
                                </label>
                                <input name="tipo_cambio" class="form-control form-control-sm"
                                    placeholder="INGRESE EL TIPO DE CAMBIO" required type="text"
                                    value="{{ $adelanto->tipo_cambio }}">
                                <span class="input-border"></span>
                            </div>
                        </div>








                        <div class="col-md-12 text-right g-3 mt-2">
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

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
         $(document).ready(function() {
            $('.buscador').select2({
                theme: "classic"
            });
           
        });
    </script>
@endpush
