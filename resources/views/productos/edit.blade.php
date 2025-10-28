@extends('admin.layout')

@section('content')
    <div class="container">
        <br>
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA EDITAR PRODUCTOS') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-danger btn-sm" href="{{ route('productos.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                    <form class="editar-producto" action="{{ route('productos.update', $producto->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="form-group col-md-12 g-3">
                                <label for="nombre_producto" class="text-muted">
                                    {{ __('NOMBRE DEL PRODUCTO') }}
                                </label>
                                <span class="text-danger">(*)</span>
                                <input type="text" value="{{$producto->nombre_producto}}" name="nombre_producto" id="nombre_producto" class="form-control @error('nombre_producto') is-invalid @enderror" value="{{ old('nombre_producto') }}" placeholder="Ingrese un nombre para este producto">
                                @error('nombre_producto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 g-3">
                                    <label for="productosfamilia_id" class="text-success">
                                        <b>
                                            {{ __('FAMILIA PADRE') }}
                                        </b>
                                    </label>
                                    <select name="productosfamilia_id" id="productosfamilia_id"
                                        class="form-control @error('productosfamilia_id') is-invalid @enderror" aria-label="">
                                        <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                        @foreach ($productosfamilias as $familia)
                                                <option value="{{ $familia->id }}"
                                                    {{ old('productosfamilia_id') == $familia->id ? 'selected' : '' }}>
                                                    {{ $familia->nombre }}
                                                </option>
                                        @endforeach
                                    </select>

                                    <div class="form-group mt-4 g-3">
                                        <label for="unidad_id" class="text-muted">
                                            {{ __('UNIDADES') }}
                                        </label>
                                        <select name="unidad_id" id="unidad_id" class="form-control @error('unidad_id') is-invalid @enderror" aria-label="Unidad">
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
@endsection