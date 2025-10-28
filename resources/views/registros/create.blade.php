@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA REGISTRAR OPERACIONES') }}
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
                <form class="crear-registro" action="{{ route('registros.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3 g-3">
                            <label for="accion_id" class="text-muted">
                                {{ __('ACCIÓN') }}
                            </label>
                            <select name="accion_id" id="accion_id" class="form-select @error('accion_id') is-invalid @enderror" aria-label="">
                                <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                @foreach ($acciones as $accion)
                                    <option value="{{ $accion->id }}" {{ old('accion_id') == $accion->id ? 'selected' : '' }}>
                                        {{ $accion->nombre_accion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('accion_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 g-3">
                            <label for="tipo_vehiculo_id" class="text-muted">
                                {{ __('TIPO DE VEHÍCULO') }}
                            </label>
                            <select name="tipo_vehiculo_id" id="tipo_vehiculo_id" class="form-select @error('tipo_vehiculo_id') is-invalid @enderror" aria-label="">
                                <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                @foreach ($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->id }}" {{ old('tipo_vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
                                        {{ $vehiculo->nombre_vehiculo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_vehiculo_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 g-3">
                            <label for="placa" class="text-muted">
                                {{ __('PLACA') }}
                            </label>
                            <input type="text" name="placa" id="placa" class="form-control @error('placa') is-invalid @enderror" value="{{ old('placa') }}" placeholder="ABC-123">
                            @error('placa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-3 g-3">
                            <label for="motivo" class="text-muted">
                                {{ __('MOTIVO') }}
                            </label>
                            <select name="motivo" id="motivo" class="form-select @error('motivo') is-invalid @enderror" aria-label="">
                                <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                @foreach ($motivos as $motivo)
                                    <option value="{{ $motivo->id }}" {{ old('motivo') == $motivo->id ? 'selected' : '' }}>
                                        {{ $motivo->nombre_motivo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('motivo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 g-3">
                            <label for="documento_cliente" class="text-success">
                                {{ __('DNI / RUC CLIENTE') }}
                            </label>
                            <div class="input-group">
                                <input type="text" name="documento_cliente" id="documento_cliente" class="form-control @error('documento_cliente') is-invalid @enderror" value="{{ old('documento_cliente') }}" placeholder="ingrese DNI ó RUC">
                                <button class="btn btn-primary" type="button" id="buscar_cliente_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path></svg>
                                </button>
                            </div>
                            @error('documento_cliente')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-8 g-3">
                            <label for="datos_cliente" class="text-muted">
                                {{ __('NOMBRE Ó RAZÓN SOCIAL CLIENTE') }}
                            </label>
                            <input type="text" name="datos_cliente" id="datos_cliente" class="form-control @error('datos_cliente') is-invalid @enderror" value="{{ old('datos_cliente') }}" placeholder="Datos obtenidos automáticamente...">
                            @error('datos_cliente')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 g-3">
                            <label for="documento_conductor" class="text-success">
                                {{ __('DNI / RUC CONDUCTOR') }}
                            </label>
                            <div class="input-group">
                                <input type="text" name="documento_conductor" id="documento_conductor" class="form-control " value="{{ old('documento_conductor') }}" placeholder="ingrese DNI ó RUC">
                                <button class="btn btn-primary" type="button" id="buscar_conductor_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path></svg>
                                </button>
                            </div>
                            @error('documento_conductor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-8 g-3">
                            <label for="datos_conductor" class="text-muted">
                                {{ __('NOMBRE Ó RAZÓN SOCIAL DEL CONDUCTOR') }}
                            </label>
                            <input type="text" name="datos_conductor" id="datos_conductor" class="form-control  }}" placeholder="Datos obtenidos automáticamente...">
                            
                        </div>
                        <div class="form-group col-md-4 g-3">
                            <label for="documento_balanza" class="text-success">
                                {{ __('DNI / RUC BALANZA') }}
                            </label>
                            <div class="input-group">
                                <input type="text" name="documento_balanza" id="documento_balanza" class="form-control @error('documento_balanza') is-invalid @enderror" value="{{ old('documento_balanza') }}" placeholder="ingrese DNI ó RUC">
                                <button class="btn btn-primary" type="button" id="buscar_balanza_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path></svg>
                                </button>
                            </div>
                            @error('documento_balanza')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-8 g-3">
                            <label for="datos_balanza" class="text-muted">
                                {{ __('NOMBRE Ó RAZÓN SOCIAL BALANZA') }}
                            </label>
                            <input type="text" name="datos_balanza" id="datos_balanza" class="form-control @error('datos_balanza') is-invalid @enderror" value="{{ old('datos_balanza') }}" placeholder="Datos obtenidos automáticamente...">
                            @error('datos_balanza')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 g-3">
                            <label for="guia_remision" class="text-muted">
                                {{ __('GUÍA DE REMISIÓN') }}
                            </label>
                            <input type="text" name="guia_remision" id="guia_remision" class="form-control @error('guia_remision') is-invalid @enderror" value="{{ old('guia_remision') }}" placeholder="000-0000000">
                            @error('guia_remision')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 g-3">
                            <label for="guia_transportista" class="text-muted">
                                {{ __('GUÍA DE TRANSPORTISTA') }}
                            </label>
                            <input type="text" name="guia_transportista" id="guia_transportista" class="form-control @error('guia_transportista') is-invalid @enderror" value="{{ old('guia_transportista') }}" placeholder="000-00000000">
                            @error('guia_transportista')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 g-3">
                            <label for="referencia_uno" class="text-success">
                                <b>
                                    {{ __('REFERENCIA 1') }}
                                </b>
                            </label>
                            <input type="text" name="referencia_uno" id="referencia_uno" class="form-control @error('referencia_uno') is-invalid @enderror" value="{{ old('referencia_uno') }}" placeholder="SOCIO UNO">
                        </div>
                        <div class="form-group col-md-4 g-3">
                            <label for="referencia_dos" class="text-success">
                                <b>
                                    {{ __('REFERENCIA 2') }}
                                </b>
                            </label>
                            <input type="text" name="referencia_dos" id="referencia_dos" class="form-control @error('referencia_dos') is-invalid @enderror" value="{{ old('referencia_dos') }}" placeholder="SOCIO DOS">
                        </div>
                        <div class="form-group col-md-4 g-3">
                            <label for="referencia_tres" class="text-success">
                                <b>
                                    {{ __('TICKET') }}
                                </b>
                            </label>
                            <input type="text" name="referencia_tres" id="referencia_tres" class="form-control @error('referencia_tres') is-valid @enderror" value="{{ old('referencia_tres') }}" placeholder="TICKET">
                        </div>
                        <div class="form-group col-md-6 g-3">
                            <label for="toneladas" class="text-success">
                                <b>
                                    {{ __('TONELADAS') }}
                                </b>
                            </label>
                            <input type="text" name="toneladas" id="toneladas" class="form-control @error('toneladas') is-invalid @enderror" value="{{ old('toneladas') }}" placeholder="50">
                        </div>
                        <div class="form-group col-md-6 g-3">
                            <label for="estado_id" class="text-success">
                                <b>
                                    {{ __('ESTADO') }}
                                </b>
                            </label>
                            <select name="estado_id" id="estado_id" class="form-select @error('estado_id') is-invalid @enderror" aria-label="">
                                <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}" {{ old('estado_id') == $estado->id ? 'selected' : '' }}>
                                        {{ $estado->nombre_estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 g-3">
                            <label for="observacion" class="text-muted">
                                {{ __('OBSERVACIÓN') }}
                            </label>
                            <textarea name="observacion" id="observacion" class="form-control @error('observacion') is-invalid @enderror" placeholder="De ser el caso, ingrese una descripción o comentario...">{{ old('observacion') }}</textarea>
                            @error('observacion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
            $('.crear-registro').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Crear registro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        this.submit();
                    }
                })
            });
        </script>
        @if($errors->has('guia_remision') || $errors->has('guia_transportista'))
            <script>
                let errorMessage = '';
        
                @if($errors->has('guia_remision'))
                    errorMessage += '<p>{{ $errors->first('guia_remision') }}</p>';
                @endif
        
                @if($errors->has('guia_transportista'))
                    errorMessage += '<p>{{ $errors->first('guia_transportista') }}</p>';
                @endif
        
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    html: errorMessage,
                });
            </script>
        @endif
    @endpush
@endsection