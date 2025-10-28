@extends('admin.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
<br>
<div class="text-right mb-2">
    <a class="btn btn-light"  href="{{ url()->previous() }}">VOLVER</a>
</div>

    <div id="main" style="width:100%; height:400px;"></div> <!-- Ensure the chart has proper dimensions -->

@stop
@section('js')

    <!-- Using CDN for ECharts and Vintage theme -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.1/dist/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.1/theme/vintage.js"></script>
    <script>
        var chartDom = document.getElementById('main');
        var myChart = echarts.init(chartDom, 'vintage');
    
        // Data passed from Laravel (PHP to JavaScript)
        const dailyData = @json($dailyData);
        const productName = @json($producto->nombre_producto); // Add this line
    
        // Separate date and values
        const dateList = Object.keys(dailyData);
        const valueList = Object.values(dailyData);
    
        // Function to get the day of the week in Spanish
        function getDayOfWeek(dateString) {
            const daysOfWeek = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
            const date = new Date(dateString); // Parse the date string
            return daysOfWeek[date.getUTCDay()]; // Get the day of the week
        }
    
        var option = {
            title: {
                left: 'center',
                text: 'ROTACIÓN DIARIA ' + productName // Use product name in the title
            },
            tooltip: {
                trigger: 'axis',
                formatter: function (params) {
                    // Get the date from params[0] (assuming it's a single series chart)
                    let date = params[0].axisValue;
                    let dayOfWeek = getDayOfWeek(date); // Get day of the week
                    let value = params[0].data; // Get the value for that date
    
                    return `${dayOfWeek}, ${date}<br/>Rotación: ${value}`;
                }
            },
            xAxis: {
                type: 'category',
                data: dateList // Use dateList for X axis
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: valueList, // Use valueList for Y axis data
                type: 'line',
                smooth: true,
                showSymbol: false, // Remove the circles (data points)
                lineStyle: {
                    width: 3,
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1, // Gradient from top to bottom
                        [
                            { offset: 0, color: '#FD665F' }, // Red at the top
                            { offset: 1, color: '#FFCE34' }  // Yellow at the bottom
                        ]
                    )
                },
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            { offset: 0, color: '#FD665F' }, // Red at the top
                            { offset: 1, color: '#FFCE34' }  // Yellow at the bottom
                        ]
                    )
                }
            }]
        };
    
        option && myChart.setOption(option);
    
        // Make chart responsive
        window.addEventListener('resize', () => {
            myChart.resize();
        });
    </script>
    
    
    



@stop
