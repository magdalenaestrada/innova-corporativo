@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-light">{{ __('GRÁFICO ESTADÍSTICO DE OPERACIONES') }}</div>
                <div class="card-body">
                    <a href="{{ route('data.query') }}" class="btn btn-info btn-sm">{{ __('CONSULTAR') }}</a>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($data['labels']), // Convierte el array PHP a JSON
                datasets: @json($data['datasets']), // Convierte el array PHP a JSON
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'MOVIMIENTOS REGISTRADOS'
                    }
                },
                scales: {
                    x: {
                        type: 'category',
                        labels: @json($data['labels']), // Convierte el array PHP a JSON
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad',
                        },
                    },
                },
                elements: {
                    line: {
                        tension: 0.3,
                    }
                },
            },
        });
    </script>
@endpush
@endsection
