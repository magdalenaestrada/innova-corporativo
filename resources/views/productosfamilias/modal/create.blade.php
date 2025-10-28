<div class="modal fade text-left" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="card">
            <div class="modal-content">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="col-md-8">
                            <h6 class="mt-2">
                                {{ __('MÓDULO PARA CREAR FAMILIAS PARA LOS PRODUCTOS') }}
                            </h6>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                                <img style="width: 15px" src="{{asset('images/icon/close.png')}}" alt="cerrar">    
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="crear-familia" action="{{ route('productosfamilias.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12 g-3">
                                <label for="nombre_familia" class="text-muted">
                                    {{ __('NOMBRE DE LA FAMILIA') }}
                                </label>
                                <span class="text-danger">(*)</span>
                                <input type="text" name="nombre_familia" id="nombre_familia" class="form-control @error('nombre_familia') is-invalid @enderror" value="{{ old('nombre_familia') }}" placeholder="Ingrese un nombre para esta familia">
                                @error('nombre_familia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion_familia" class="text-muted">
                                    {{ __('DESCRIPCIÓN') }}
                                </label>
                                <input type="text" name="descripcion_familia" id="descripcion_familia" class="form-control @error('descripcion_familia') is-invalid @enderror" placeholder="De ser el caso, agregue una descripción...">
                                @error('descripcion_familia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            
                        
                            <div class="col-md-12 text-right g-3">
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    {{ __('GUARDAR FAMILIA') }}
                                </button>   
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
   
<script>
            $('.crear-producto').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Crear producto?',
                    icon: 'warning',
                    ShowCancelButton: true,
                    ConfirmButtonColor: '#3085d6',
                    CancelButtonColor: '#d33',
                    ConfirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        this.submit();
                    }
                })
            });
</script>
@if($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    html: '@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach',
                });
            </script>
@endif
