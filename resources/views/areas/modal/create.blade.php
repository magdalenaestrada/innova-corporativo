<form method="POST" action="{{ route('areas.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header-container align-items-center w-100">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('CREAR ÁREA') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                                    <img style="width: 15px" src="{{asset('images/icon/close.png')}}" alt="cerrar">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <input name="nombre" class="input form-control" placeholder="Ingrese el nombre del área" required="" type="text">
                        <span class="input-border"></span>
                    </div>                  
                 
                    <div class="mb-3 text-right mt-3">
                        <button type="submit" class="btn btn-sm btn-secondary"> GUARDAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>