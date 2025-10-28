
<div class="modal fade text-left" id="ModalCreate"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header">
                <div class="row card-header d-flex justify-content-between">
                        <div class="col-md-6">
                            <h6 class="mt-2">
                                {{ __('MÓDULO PARA CREAR HERRAMIENTAS') }}
                            </h6>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                                <img style="width: 15px" src="{{asset('images/icon/close.png')}}" alt="cerrar">
                            </button>
                        </div>
                </div>
            </div>
            <div class="card-body">
                <form class="crear-accion" action="{{ route('invherramientas.store') }}" method="POST">
                        @csrf
                    <div class="row">
                            <div class="form-group col-md-12 g-3">
                                <label for="nombre" class="text-muted">
                                    {{ __('NOMBRE DE LA HERRAMIENTA') }}
                                </label>
                                <span class="text-danger">(*)</span>
                                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ingrese un nombre para esta herramienta">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12 g-3">
                                <label for="codigo" class="text-muted">
                                    {{ __('CÓDIGO DE LA HERRAMIENTA') }}
                                </label>
                                <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror" placeholder="Ingrese el código de la herramienta">
                                @error('codigo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion" class="text-muted">
                                    {{ __('DESCRIPCIÓN') }}
                                </label>
                                <input type="text" name="decripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" placeholder="De ser el caso, agregue una descripción...">
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 g-3">
                                <label for="observacion" class="text-muted">
                                    {{ __('OBSERVACIÓN') }}
                                </label>
                                <input type="text" name="observacion" id="observacion" class="form-control @error('observacion') is-invalid @enderror" placeholder="De ser el caso, agregue una observación...">
                                @error('observacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 g-3">
                                <label for="stock" class="text-muted">
                                    {{ __('STOCK') }}
                                </label>
                                <input type="text" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="Agregue el stock...">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           




                            
                            <div class="col-md-12 text-right mt-3 g-3">
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    {{ __('GUARDAR PRODUCTO') }}
                                </button>   
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@push('js')

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
@endpush