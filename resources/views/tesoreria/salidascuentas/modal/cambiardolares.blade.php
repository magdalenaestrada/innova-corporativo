<div class="modal fade text-left" id="ModalCambiarDolares"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CAMBIAR DOLARES A SOLES') }}
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
                <form class="crear-cuenta" action="{{ route('tssalidascuentas.depositar') }}" method="POST">
                    @csrf
                    <div class="row">
                        
                     



                        
                        <div class="form-group col-md-6 g-3">
                            <label for="cuenta" class="text-sm">
                                {{ __('CUENTA DE ORIGEN') }}
                            </label>
                            <br>
                            <select name="cuenta_id" id="cuenta2" class="form-control form-control-sm buscador @error('cuenta1') is-invalid @enderror" aria-label="" style="width: 100%" required="">
                                <option selected value="">
                                    Seleccione la cuenta en dolares
                                </option>
                                @foreach ($cuentas as $cuenta)
                                    @if($cuenta->tipomoneda->nombre == 'DOLARES')
                                    <option value="{{ $cuenta->id }}" {{ old('cuenta1') == $cuenta->id ? 'selected' : '' }}>
                                        {{ $cuenta->nombre }}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('cuenta1')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="cuenta_beneficiaria_id" class="text-sm">
                                {{ __('CUENTA BENEFICIARIA') }}
                            </label>
                            <br>
                            <select name="cuenta_beneficiaria_id" id="cuenta_beneficiaria1" class="form-control form-control-sm buscador @error('cuenta_beneficiaria1') is-invalid @enderror" aria-label="" style="width: 100%" required="">
                                <option selected value="">
                                    Seleccione la cuenta en soles
                                </option>
                                @foreach ($cuentas as $cuenta)
                                    @if($cuenta->tipomoneda->nombre == 'SOLES')
                                    <option value="{{ $cuenta->id }}" {{ old('cuenta_beneficiaria1') == $cuenta->id ? 'selected' : '' }}>
                                        {{ $cuenta->nombre }}
                                    </option>
                                    @endif

                                @endforeach
                            </select>
                            @error('cuenta_beneficiaria1')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        

                        <div class="form-group col-md-6 g-3">
                            <label for="motivo" class="text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <select name="motivo_id" id="motivo1" class="form-control form-control-sm buscador @error('cuenta') is-invalid @enderror" aria-label="" style="width: 100%" required>
                                <option selected value="">
                                    Seleccione el motivo
                                </option>
                                @foreach ($motivos as $motivo)
                                    <option value="{{ $motivo->id }}" {{ old('cuenta') == $motivo->id ? 'selected' : '' }}>
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

                        <div class="form col-md-6 mb-3">
                            <label for="fecha" class="text-sm">
                                {{ __('FECHA') }}
                            </label>
                            <input name="fecha" id="fecha" class="form-control form-control-sm" placeholder="Ingrese la fecha" type="date">
                            <span class="input-border"></span>
                        </div> 
                        



                        <div class="form col-md-12 mb-3">
                            <label for="descripcion" class="text-sm">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            <input name="descripcion" id="descripcion" class="form-control form-control-sm" placeholder="Ingrese la descripción" required="" type="text">
                            <span class="input-border"></span>
                        </div> 


                        <div class="form col-md-4 mb-3">
                            <label for="monto" class="text-sm">
                                {{ __('MONTO') }}
                            </label>
                            <input name="monto" id="monto1" class="form-control form-control-sm" placeholder="Ingrese el monto" required="" type="text">
                            <span class="input-border"></span>
                        </div>   


                        <div class="form col-md-4 mb-3">
                            <label for="tipo_cambio" class="text-sm">
                                {{ __('TIPO DE CAMBIO') }}
                            </label>
                            <input name="tipo_cambio" id="tipocambio" class="form-control form-control-sm" placeholder="Ingrese el tipo de cambio" required="" type="text">
                            <span class="input-border"></span>
                        </div>   

                        <div class="form col-md-4 mb-3">

                            <label for="total" class="text-sm">
                                {{ __('TOTAL') }}
                            </label>
                            <input name="total" id="total" class="form-control form-control-sm" placeholder="TOTAL" required="" type="text">
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


