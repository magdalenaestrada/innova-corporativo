<div class="modal fade text-left" id="ModalEditar{{ $producto->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
           

            <div class="card-header row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <h6 class="mt-2">
                                {{ __('MÓDULO PARA EDITAR PRODUCTOS') }}
                            </h6>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                                <img style="width: 15px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
                            </button>
                        </div>
            </div>
        
            <div class="card-body">
                    <form class="editar-producto" action="{{ route('productos.update', ['producto' => $producto->id, 'page' => request()->page]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="form-group col-md-12 g-3">
                                <label for="nombre_producto" class="text-sm">
                                    {{ __('NOMBRE DEL PRODUCTO') }}
                                </label>
                                <input type="text" value="{{$producto->nombre_producto}}" name="nombre_producto" id="nombre_producto" class="form-control form-control-sm @error('nombre_producto') is-invalid @enderror" value="{{ old('nombre_producto') }}" placeholder="Ingrese un nombre para este producto">
                                @error('nombre_producto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 g-3">
                                    <label for="productosfamilia_id" class="text-sm">
                                        <b>
                                            {{ __('FAMILIA') }}
                                        </b>
                                    </label>
                                    <select name="productosfamilia_id" id="productosfamilia_id"
                                        class="form-control form-control-sm @error('productosfamilia_id') is-invalid @enderror" aria-label="Productos Familia">
                                        <option selected disabled>{{ __('-- Seleccione una opción') }}</option>

                                        @foreach ($productosfamilias as $familia)
                                            <option value="{{ $familia->id }}"
                                                {{ old('productosfamilia_id', isset($producto) ? $producto->productosfamilia_id : '') == $familia->id ? 'selected' : '' }}>
                                                {{ $familia->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="form-group mt-4 g-3">
                                        <label for="unidad_id" class="text-muted">
                                            {{ __('UNIDADES') }}
                                        </label>
                                        <select name="unidad_id" id="unidad_id" class="form-control form-control-sm @error('unidad_id') is-invalid @enderror" aria-label="Unidad">
                                            @if (old('unidad_id'))
                                                <!-- If there's an old value (after validation error), pre-select the old value -->
                                                @foreach ($unidades as $unidad)
                                                    <option value="{{ $unidad->id }}" {{ old('unidad_id') == $unidad->id ? 'selected' : '' }}>
                                                        {{ $unidad->nombre }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <!-- Pre-select product's unidad if editing -->
                                                @if(!empty($producto->unidad_id))
                                                    <option selected value="{{ $producto->unidad_id }}">
                                                        {{ $producto->unidad_nombre }}
                                                    </option>
                                                @else
                                                    <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                                @endif
                                        
                                                <!-- Other unidades for selection -->
                                                @foreach ($unidades as $unidad)
                                                    <option value="{{ $unidad->id }}">
                                                        {{ $unidad->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        
                                    </div>
                                    
                                        @error('unidad_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    @if($producto->precio==0)
                                    <div class="form-group col-md-12 g-3">
                                        <label for="valor_promedio" class="text-muted">
                                            {{ __('VALOR PROMEDIO') }}
                                        </label>
                                        <input type="text" name="valor_promedio" id="valor_promedio" class="form-control @error('valor_promedio') is-invalid @enderror" value="{{ old('valor_promedio') }}" placeholder="Ingrese  el valor promedio de este producto">
                                        @error('valor_promedio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @endif


                                    @error('estado_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    
                            </div>


                            <div class="col-md-12 text-right mt-2 g-3">
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    {{ __('ACTUALIZAR PRODUCTO') }}
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
          
            
    
        </div>
    </div>
</div>
