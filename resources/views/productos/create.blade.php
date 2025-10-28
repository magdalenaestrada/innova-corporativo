@extends('admin.layout')

@section('content')
    <div class="container mt-2">
<br>

    <div class="card">
          
                <div class="row card-header d-flex justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA CREAR PRODUCTOS') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-danger btn-sm" href="{{ route('productos.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            <div class="card-body">
                <form class="crear-accion" action="{{ route('productos.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 g-3">
                            <label for="nombre_accion" class="text-sm">
                                {{ __('NOMBRE DEL PRODUCTO') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="text" name="nombre_producto" id="nombre_producto" class="form-control form-control-sm @error('nombre_producto') is-invalid @enderror" value="{{ old('nombre_producto') }}" placeholder="Ingrese un nombre para este producto">
                            @error('nombre_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                      
                        <div class="form-group col-md-2 g-3">
                            <label for="precio" class="text-sm">
                                {{ __('VALOR DEL PRODUCTO') }}
                            </label>
                            <input type="text" name="precio" id="precio" class="form-control form-control-sm @error('precio') is-invalid @enderror" placeholder="Valor...">
                            @error('precio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4  g-3">
                            <label for="unidad_id" class="text-sm">
                                {{ __('UNIDADES') }}
                            </label>
                            <select name="unidad_id" id="unidad_id" class="form-control form-control-sm @error('accion_id') is-invalid @enderror" aria-label="">
                                <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                @foreach ($unidades as $unidad)
                                    <option value="{{ $unidad->id }}" {{ old('unidad_id') == $unidad->id ? 'selected' : '' }}>
                                        {{ $unidad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unidad_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        
                        <div class="form-group col-md-12 g-3">
                            <label for="descripcion_producto" class="text-sm">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            <input type="text" name="descripcion_producto" id="descripcion_producto" class="form-control form-control-sm @error('descripcion_producto') is-invalid @enderror" placeholder="De ser el caso, agregue una descripción...">
                            @error('descripcion_producto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="observacion" class="text-sm">
                                {{ __('OBSERVACIÓN') }}
                            </label>
                            <input type="text" name="observacion" id="observacion" class="form-control form-control-sm @error('observacion') is-invalid @enderror" placeholder="De ser el caso, agregue una observación...">
                            @error('observacion')
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

@stop
@section('js')

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
 @stop