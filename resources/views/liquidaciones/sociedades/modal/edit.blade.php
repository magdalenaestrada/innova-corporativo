<div class="modal fade text-left" id="ModalEdit{{ $sociedad->id }}"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="card-header row justify-content-between">
                <div class="col-md-6">
                    <h6 class="mt-2">
                        {{ __('EDITAR SOCIEDAD') }}
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
                <form class="editar-cuenta" action="{{ route('lqsociedades.update', $sociedad->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="form mb-1 col-md-6">
                            <label for="codigo" class="text-sm">{{ __('CODIGO') }}</label>
                            <input name="codigo" value="{{ $sociedad->codigo ? $sociedad->codigo : '' }}" id="nombre"
                                class=" form-control form-control-sm" placeholder="Documento del beneficiario..."
                                type="text" disabled>
                        </div>

                        <!-- For Documento Beneficiario -->
                        <div class="form mb-1 col-md-6">
                            <label for="nombre" class="text-sm">{{ __('NOMBRE') }}</label>
                            <input name="nombre" value="{{ $sociedad->nombre ? $sociedad->nombre : '' }}" id="nombre"
                                class=" form-control form-control-sm" placeholder="Documento del beneficiario..."
                                type="text">
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
