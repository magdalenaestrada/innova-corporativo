@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Consulta -->
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CONSULTA') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('home') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- form -->
            <div class="card-body">
                <form method="GET" action="{{ route('data.query') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 g-3">
                            <label for="documento_cliente" class="text-muted">
                                {{ __('DOCUMENTO DEL CLIENTE') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="text" name="documento_cliente" id="documento_cliente" class="form-control"
                                placeholder="Ingrese el documento del cliente">
                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="accion_id" class="text-muted">
                                {{ __('ACCIÓN') }}
                            </label>
                            <select name="accion_id" id="accion_id" placeholder="Acción" class="form-control">
                                <option value="">Seleccionar Acción</option>
                                @foreach ($accions as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="start_date" class="text-muted">
                                {{ __('FECHA INICIAL') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="datetime-local" name="start_date" placeholder="Ingrese la fecha Inicial"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="end_date" class="text-muted">
                                {{ __('FECHA FINAL') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="datetime-local" name="end_date" placeholder="Ingrese la fecha Final"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="motivo_id" class="text-muted">
                                {{ __('MOTIVO') }}
                            </label>
                            <select name="motivo_id" placeholder="Motivo" class="form-control">
                                <option value="">Seleccionar Motivo</option>
                                @foreach ($motivos as $id => $nombre)
                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 text-end g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('CONSULTAR') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <br>
        <br>
        <!-- Resultado -->
        <div class="card">

            <!-- Mostrar los registros -->
            @if (isset($filteredData))

                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('TODAS LAS OPERACIONES REGISTRADAS') }}
                    <a class="btn btn-sm btn-secondary" href="{{ route('registros.create') }}">
                        {{ __('CREAR PROGRAMACIÓN') }}
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        @if (count($filteredData) > 0)
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Operación') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Fecha y hora de registro') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Tipo de Vehículo') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Placa') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Documento cliente') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Nombre o Razón Social Cliente') }}
                                    </th>
                                    <th>
                                        {{ __('Acción') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredData as $registro)
                                    <tr>
                                        <td scope="row">
                                            {{ $registro->id }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->accion->nombre_accion }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->created_at->format('d/m/Y - H:i:s') }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->tipoVehiculo->nombre_vehiculo }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->placa }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->documento_cliente }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->datos_cliente }}
                                        </td>
                                        <td>
                                            <a href="{{ route('registros.show', $registro->id) }}"
                                                class="btn btn-info text-white btn-sm">
                                                {{ __('VER') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    {{ __('No hay datos disponibles') }}
                                </td>
                            </tr>
                        @endif
                    </table>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item {{ $filteredData->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $filteredData->previousPageUrl() }}">
                                    {{ __('Anterior') }}
                                </a>
                            </li>
                            @for ($i = 1; $i <= $filteredData->lastPage(); $i++)
                                <li class="page-item {{ $filteredData->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $filteredData->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ $filteredData->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $filteredData->nextPageUrl() }}">
                                    {{ __('Siguiente') }}
                                </a>
                            </li>
                        </ul>
                    </nav>
                    @if ($sumTons !== null)
                        <h4 class="text-end p-3">Total Toneladas: <span class="d-inline p-1 bg-dark text-white">{{ $sumTons }}</span></h4>
                    @endif
                </div>
            @endif



            <!-- Mostrar los registros -->






        </div>
    </div>



<br><br><br>

@endsection
