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
                                    {{ __('VER REGISTRO') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-danger btn-sm" href="{{ route('registros.index') }}">
                                    {{ __('VOLVER') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>
                                        {{ __('Estás viendo el ID') }}
                                    </strong>
                                    <span class="badge text-bg-secondary">{{ $registro->id }}</span>
                                    <strong>
                                        {{ __('y esta operación fue registrada el ') }}
                                    </strong>
                                        {{ $registro->created_at->format('d-m-Y') }}
                                    <strong>
                                        {{ __('a la(s) ') }}
                                    </strong>
                                        {{ $registro->created_at->format('H:i:s') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @if ($registro->updated_at != $registro->created_at)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Estás viendo el ID') }}
                                        </strong>
                                        <span class="badge text-bg-secondary">
                                            {{ $registro->id }}
                                        </span>
                                        <strong>
                                            {{ __('y esta operación fue actualizada el ') }}
                                        </strong>
                                            {{ $registro->updated_at->format('d-m-Y') }}
                                        <strong>
                                            {{ __('a la(s) ') }}
                                        </strong>
                                            {{ $registro->updated_at->format('H:i:s') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @else
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>
                                            {{ __('Este registro aún no ha sido actualizado') }}
                                        </strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-md-3 g-3">
                                <label for="accion_id">
                                    {{ __('ACCIÓN') }}
                                </label>
                                <select class="form-select" aria-label="" disabled>
                                    <option value="{{ $registro->accion->id }}" selected>
                                        {{ $registro->accion->nombre_accion }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 g-3">
                                <label for="tipo_vehiculo_id">
                                    {{ __('TIPO DE VEHÍCULO') }}
                                </label>
                                <select class="form-select" aria-label="" disabled>
                                    <option value="{{ $registro->tipoVehiculo->id }}" selected>
                                        {{ $registro->tipoVehiculo->nombre_vehiculo }}
                                    </option> 
                                </select>
                            </div>
                            <div class="form-group col-md-3 g-3">
                                <label for="placa">
                                    {{ __('PLACA') }}
                                </label>
                                <input class="form-control" value="{{ $registro->placa }}" disabled>
                            </div>
                            <div class="form-group col-md-3 g-3">
                                <label for="motivo">
                                    {{ __('MOTIVO') }}
                                </label>
                                <select class="form-select" aria-label="" disabled>
                                    <option value="{{ $registro->motivo->id }}" selected>
                                        {{ $registro->motivo->nombre_motivo }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 g-3">
                                <label for="documento_cliente">
                                    {{ __('DNI / RUC CLIENTE') }}
                                </label>
                                <div class="input-group">
                                    <input class="form-control" value="{{ $registro->documento_cliente }}" disabled>
                                    <button class="btn btn-secondary" type="button" id="buscar_cliente_btn" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                <label for="datos_cliente">
                                    {{ __('NOMBRE Ó RAZÓN SOCIAL CLIENTE') }}
                                </label>
                                <input class="form-control" value="{{ $registro->datos_cliente }}" disabled>
                            </div>
                            <div class="form-group col-md-4 g-3">
                                <label for="documento_conductor">
                                    {{ __('DNI / RUC CONDUCTOR') }}
                                </label>
                                <div class="input-group">
                                    <input class="form-control" value="{{ $registro->documento_conductor }}" disabled>
                                    <button class="btn btn-secondary" type="button" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                <label for="datos_conductor">
                                    {{ __('NOMBRE Ó RAZÓN SOCIAL DEL CONDUCTOR') }}
                                </label>
                                <input class="form-control" value="{{ $registro->datos_conductor }}" disabled>
                            </div>
                            <div class="form-group col-md-4 g-3">
                                <label for="documento_balanza">
                                    {{ __('DNI / RUC BALANZA') }}
                                </label>
                                <div class="input-group">
                                    @if ($registro->documento_balanza)
                                        <input class="form-control" value="{{ $registro->documento_balanza }}" disabled>
                                    @else
                                        <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                    @endif
                                    <button class="btn btn-secondary" type="button" id="buscar_balanza_btn" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-8 g-3">
                                <label for="datos_balanza">
                                    {{ __('NOMBRE Ó RAZÓN SOCIAL BALANZA') }}
                                </label>
                                @if ($registro->datos_balanza)
                                    <input class="form-control" value="{{ $registro->datos_balanza }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-6 g-3">
                                <label for="guia_remision">
                                    {{ __('GUÍA DE REMISIÓN') }}
                                </label>
                                @if ($registro->guia_remision)
                                    <input class="form-control" value="{{ $registro->guia_remision }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-6 g-3">
                                <label for="guia_transportista">
                                    {{ __('GUÍA DE TRANSPORTISTA') }}
                                </label>
                                @if ($registro->guia_transportista)
                                    <input class="form-control" value="{{ $registro->guia_transportista }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-4 g-3">
                                <label for="referencia_uno">
                                    {{ __('REFERENCIA 1') }}
                                </label>
                                @if ($registro->referencia_uno)
                                    <input class="form-control" value="{{ $registro->referencia->referencia_uno }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-4 g-3">
                                <label for="referencia_dos">
                                    {{ __('REFERENCIA 2') }}
                                </label>
                                @if ($registro->referencia_dos)
                                    <input class="form-control" value="{{ $registro->referencia->referencia_dos }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-4 g-3">
                                <label for="referencia_tres">
                                    {{ __('TICKET') }}
                                </label>
                                @if ($registro->referencia_tres)
                                    <input class="form-control" value="{{ $registro->referencia->referencia_tres }}" disabled>
                                @else
                                    <input class="form-control" value="{{ __('No hay datos disponibles') }}" disabled>
                                @endif
                            </div>
                            <div class="form-group col-md-12 g-3">
                                <label for="observacion">
                                    {{ __('OBSERVACIÓN') }}
                                </label>
                                <textarea class="form-control" disabled>{{ $registro->observacion ? $registro->observacion : 'No hay descripción disponible' }}</textarea>
                            </div>
                            <div class="form-group col-md-6 g-3">
                                <label for="toneladas" class="text-success">
                                    {{ __('TONELADAS') }}
                                </label>
                                <input class="form-control" value="{{ $registro->toneladas ?? 0 }}" disabled>
                            </div>
                            <div class="form-group col-md-6 g-3">
                                <label for="estado_id">
                                    {{ __('ESTADO') }}
                                </label>
                                <select class="form-select" aria-label="" disabled>
                                    <option value="{{ $registro->estado->id }}" selected>
                                        {{ $registro->estado->nombre_estado }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection