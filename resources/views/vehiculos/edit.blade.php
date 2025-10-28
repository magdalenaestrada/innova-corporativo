@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA EDITAR TIPO DE VEHÍCULOS') }}
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
                <form class="editar-vehiculo" action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-12 g-3">
                            <label for="nombre_vehiculo">
                                {{ __('NOMBRE DEL TIPO DE VEHÍCULO') }}
                            </label>
                            <input type="text" name="nombre_vehiculo" id="nombre_vehiculo" class="form-control @error('nombre_vehiculo') is-invalid @enderror" value="{{ old('nombre_vehiculo', $vehiculo->nombre_vehiculo) }}">
                            @error('nombre_vehiculo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 g-3">
                            <label for="descripcion_vehiculo">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            @if ($vehiculo->descripcion_vehiculo)
                                <input type="text" name="descripcion_vehiculo" id="descripcion_vehiculo" class="form-control @error('descripcion_vehiculo') is-invalid @enderror" value="{{ old('descripcion_vehiculo', $motivo->descripcion_vehiculo) }}">
                            @else
                                <input type="text" name="descripcion_vehiculo" id="descripcion_vehiculo" class="form-control @error('descripcion_vehiculo') is-invalid @enderror" placeholder="De ser el caso, agregue un comentario...">
                            @endif
                            @error('descripcion_vehiculo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 text-end g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('ACTUALIZAR REGISTRO') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection