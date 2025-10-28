@extends('admin.layout')

@section('content')
<br>
    <div class="container mt-4">
        <div class="card shadow-sm p-4">
            <h5>Reporte de consumo de combustible</h5>
            <form action="{{ route('nota-pedido.exportCombustible') }}" method="GET" class="row g-3 mt-3">
                <div class="col-md-4">
                    <label for="placa" class="form-label">Placa del vehículo</label>
                    <input type="text" name="placa" id="placa" class="form-control"
                        placeholder="(Dejar vacío para todas)">

                </div>
                @php
                    use Carbon\Carbon;
                    $hoy = Carbon::now("America/Lima")->format("Y-m-d")
                @endphp
                <div class="col-md-3">
                    <label for="desde" class="form-label">Desde</label>
                    <input type="date" name="desde" id="desde" class="form-control" max= {{ $hoy }} required>
                </div>
                <div class="col-md-3">
                    <label for="hasta" class="form-label">Hasta</label>
                    <input type="date" name="hasta" id="hasta" class="form-control" max= {{ $hoy }} value="{{ $hoy }}" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-file-excel"></i> Exportar Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
