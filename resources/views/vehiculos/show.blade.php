@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('VER TIPO DE VEHÍCULO') }}
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
                        <div class="row">
                            <div class="form-group col-md-12 g-3">
                                <label for="nombre_vehiculo">
                                    {{ __('NOMBRE DEL TIPO DE VEHÍCULO') }}
                                </label>
                                <input name="nombre_vehiculo" id="nombre_vehiculo" class="form-control" value="{{ $vehiculo->nombre_vehiculo }}" disabled>
                            </div>
                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion_vehiculo">
                                    {{ __('DESCRIPCIÓN DEL VEHÍCULO') }}
                                </label>
                                @if($vehiculo->descripcion_vehiculo)
                                    <input name="descripcion_vehiculo" id="descripcion_vehiculo" class="form-control" value="{{ $vehiculo->descripcion_vehiculo }}" disabled>
                                    @else
                                    <input name="descripcion_vehiculo" id="descripcion_vehiculo" class="form-control" placeholder="no hay descripción disponible" disabled>
                                @endif
                            </div>
                            <span class="mt-3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection