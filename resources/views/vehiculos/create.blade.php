@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA CREAR TIPO DE VEHÍCULOS') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('vehiculos.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="crear-vehiculo" action="{{ route('vehiculos.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 g-3">
                            <label for="nombre_vehiculo">
                                {{ __('TIPO DE VEHÍCULO') }}
                            </label>
                            <input type="text" name="nombre_vehiculo" id="nombre_vehiculo" class="form-control @error('nombre_vehiculo') is-invalid @enderror" value="{{ old('nombre_vehiculo') }}" placeholder="Ingrese un nombre para el tipo de vehículo">
                            @error('nombre_vehiculo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 g-3">
                            <label for="descripcion_vehiculo">
                                {{ __('DESCRIPCIÓN VEHÍCULO') }}
                            </label>
                            <input type="text" name="descripcion_vehiculo" id="descripcion_vehiculo" class="form-control @error('descripcion_vehiculo') is-invalid @enderror" placeholder="De ser el caso, agregue un comentario...">
                            @error('descripcion_vehiculo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 text-end g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('GUARDAR REGISTRO') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $('.crear-vehiculo').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Crear vehículo?',
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
@endsection