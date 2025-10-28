<div class="modal fade text-left" id="ModalEdit{{ $cuenta->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="card-header row justify-content-between">
                <div class="col-md-6">
                    <h6 class="mt-2">
                        {{ __('EDITAR CUENTA') }}
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
                <form class="editar-cuenta" action="{{ route('tscuentas.update', $cuenta->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">



                        <!-- For Documento Beneficiario -->
                        <div class="form mb-1 col-md-6">
                            <label for="nombre" class="text-sm">{{ __('NOMBRE') }}</label>
                            <input name="nombre" value="{{ $cuenta->nombre ? $cuenta->nombre : '' }}" id="nombre"
                                class=" form-control form-control-sm" placeholder="Documento del beneficiario..."
                                type="text">
                        </div>


                        <div class="form  col-md-6">
                            <label for="banco" class="text-sm">{{ __('BANCO') }}</label>
                            <input disabled name="banco" value="{{ $cuenta->banco ? $cuenta->banco->nombre : '' }}"
                                id="nombre" class=" form-control form-control-sm" placeholder="Banco..."
                                type="text">
                        </div>


                        <div class="form  col-md-6">
                            <label for="encargado" class="text-sm">{{ __('ENCARGADO') }}</label>
                            <input disabled name="encargado"
                                value="{{ $cuenta->encargado ? strtoupper($cuenta->encargado->nombre) : '' }}"
                                id="nombre" class=" form-control form-control-sm" placeholder="Banco..."
                                type="text">
                        </div>

                        <div class="form  col-md-6">

                            @php
                                $coin_simbol = $cuenta->tipomoneda->nombre == 'DOLARES' ? '$' : 'S/.';
                                $ingresosTotal = $cuenta->ingresos->sum('monto');
                                $salidasTotal = $cuenta->salidas->sum('monto');
                                $difference = $ingresosTotal - $salidasTotal;
                            @endphp
                            <label for="balance" class="text-sm">{{ __('BALANCE') }}</label>
                            <input disabled name="encargado"
                                value="{{ $coin_simbol }}  {{ number_format($difference, 2) }}" id="nombre"
                                class=" form-control form-control-sm" placeholder="Banco..." type="text">
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
