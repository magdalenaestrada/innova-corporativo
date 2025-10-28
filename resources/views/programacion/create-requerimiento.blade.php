@extends('layouts.app')

@section('content')
@if ($programacion->estado != 'finalizada')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __(' AÑADA REQUERIMIENTO ') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('programacion.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="crear-requerimiento" action="{{ route('programacion.storerequerimiento', $programacion->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3 g-3">
                            <label for="producto_id" class="text-muted">
                                {{ __('producto') }}
                            </label>
                            <select name="producto_id" id="producto_id" class="form-select @error('producto_id') is-invalid @enderror" aria-label="">
                                <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre_producto }}
                                    </option>
                                @endforeach
                            </select>
                            @error('accion_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 g-3">
                            <label for="cantidad" class="text-success">
                                <b>
                                    {{ __('CANTIDAD GRAMOS') }}
                                </b>
                            </label>
                            <input type="text" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad') }}" placeholder="50">
                        </div>
                        <div class="col-md-12 text-end g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('AÑADIR REQUERIMIENTO') }}
                            </button>
                        </div>
                    </div>
                </form>
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
@else
    <?php abort(404); ?>
@endif
@endsection