@extends('adminlte::page')

@section('title', 'DASHBOARD')


@section('content_header')


    @foreach ($chats as $chat)
        @php
            // Determine the correct recipient name
            $recipient = $chat->user_id === auth()->id() ? $chat->recipient : $chat->user;
            $lastMessage = $chat->messages->first(); // Get the last message (already fetched in the query)

            // Determine if the last message is from the logged-in user or the recipient
            $lastMessageSender = $lastMessage && $lastMessage->user_id === auth()->id() ? 'Tú' : $recipient->name;
        @endphp

        @if ($lastMessage && $lastMessage->is_read == false && $lastMessageSender != 'Tú')
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: -10px;">
            <a style="display: block; font-size: 12px; color: black; text-decoration: none;" href="{{ route('chats.show', $chat) }}">
                <strong>NUEVO MENSAJE DE</strong>
                {{ $lastMessageSender }}: {{ $lastMessage->body }}
                <small style="color: #999;">{{ $lastMessage->created_at->format('d M Y, H:i') }}</small>
            </a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    @endforeach









    <div class="fl text-center">
        <div class="truck-loader">
    <div class="truck">
        <div class="cabin"></div>
        <div class="back"></div>
        <div class="wheel w1"></div>
        <div class="wheel w2"></div>
    </div>
    <div class="loader-road"></div>
</div>
        <h3>GRUPO INNOVA CORPORATIVO S.A.C.</h3>
          <div class="truck-loader">
    <div class="truck">
        <div class="cabin"></div>
        <div class="back"></div>
        <div class="wheel w1"></div>
        <div class="wheel w2"></div>
    </div>
    <div class="loader-road"></div>
</div>
    </div>





@stop


@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    @vite(['resources/sass/app.scss'])

@stop

@section('content')




    @can('ver producto')
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_productos }}</h3>
                        <p>Productos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('productos.index') }}" class="small-box-footer">Más información <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>

            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3>{{ $total_inventarioingresos }}</h3>
                        <p>Ordenes de compra</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <a href="{{ route('inventarioingresos.index') }}" class="small-box-footer">Más información <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>

            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $total_inventariosalidas }}</h3>
                        <p>Requerimientos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <a href="{{ route('inventariosalidas.index') }}" class="small-box-footer">Más información <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>

            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $total_proveedores }}</h3>
                        <p>Proveedores</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <a href="{{ route('proveedores.index') }}" class="small-box-footer">Más información <i
                            class="fas fa-arrow-circle-right"></i></a>

                </div>

            </div>
        @endcan




        @can('use cuenta')
            <div id="chart-container_ingresos_soles" class="col-md-6 mb-1" style="height: 300px; ">
            </div>


            <div id="chart-container_ingresos_dolares" class="col-md-6 mb-1" style="height: 300px;">
            </div>


            <div id="chart-container_salidas_soles" class="col-md-6 mb-1" style="height: 300px;">
            </div>


            <div id="chart-container_salidas_dolares" class="col-md-6"  style="height: 300px;">
            </div>
        @endcan






        @can('ver producto')
            <div id="container1" class="col-md-6 p-2" >
                <h5>GASTOS DIARIOS EN DOLARES ORDENES DE COMPRA</h5>
            </div>
            <div id="container2" class="col-md-6 p-2" >
                <h5>GASTOS DIARIOS EN SOLES ORDENES DE COMPRA</h5>
            </div>
        @endcan

    </div>



@stop



@section('js')


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/updateadvice.js') }}"></script>
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            function isRucOrDni(value) {
                return value.length === 8 || value.length === 11;
            }

            function buscarDocumento(url, inputId, datosId) {
                var inputValue = $(inputId).val();
                var tipoDocumento = inputValue.length === 8 ? 'dni' : 'ruc';

                // Realizar la solicitud AJAX al controlador
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        documento: inputValue,
                        tipo_documento: tipoDocumento
                    },
                    success: function(response) {
                        console.log('API Response:', response);
                        // Manejar la respuesta del controlador
                        if (tipoDocumento === 'dni') {
                            $(datosId).val(response.nombres + ' ' + response.apellidoPaterno + ' ' +
                                response.apellidoMaterno);
                        } else {
                            $(datosId).val(response.razonSocial);
                        }

                        $(datosId).removeClass('is-invalid').addClass('is-valid');
                    },
                    error: function(xhr, status, error) {
                        // Manejar el error de la solicitud
                        console.log(xhr.responseText);
                        $(datosId).val('');
                        $(datosId).removeClass('is-valid').addClass('is-invalid');
                    }
                });
            }

            $('#buscar_cliente_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_cliente', '#datos_cliente');
            });

            $('#buscar_conductor_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_conductor',
                    '#datos_conductor');
            });

            $('#buscar_balanza_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_balanza', '#datos_balanza');
            });

            $('#buscar_socio_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_socio', '#datos_socio');
            });
            $('#buscar_trabajador_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_trabajador',
                    '#datos_trabajador');
            });

            $('#buscar_proveedor_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_proveedor',
                    '#datos_proveedor');
            });


            $('#buscar_solicitante_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_solicitante',
                    '#nombre_solicitante');
            });

            $('#buscar_responsable_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_responsable',
                    '#nombre_responsable');
            });

            // Validar ruc o dni y cambiar el borde a verde al llenar los campos
            $('.documento-input').on('input', function() {
                var value = $(this).val();
                var isValid = isRucOrDni(value);

                $(this).toggleClass('is-valid', isValid);
                $(this).toggleClass('is-invalid', !isValid);
            });

            // Cambiar el borde a verde cuando se llenen los campos datos_cliente
            $('.datos-input').on('input', function() {
                var value = $(this).val();
                $(this).toggleClass('is-valid', value.trim().length > 0);
                $(this).toggleClass('is-invalid', value.trim().length === 0);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.1/dist/echarts.min.js"></script>

    <!-- Ingresos en soles chart -->
    <script>
        const ingresosData = @json($ingresos_cuentas_soles);

        let dateIngresosSoles = ingresosData.map(entry => entry.date);
        let dataIngresosSoles = ingresosData.map(entry => entry.total_monto);

        var chartDomIngresosSoles = document.getElementById('chart-container_ingresos_soles');
        var myChartIngresosSoles = echarts.init(chartDomIngresosSoles, 'dark');
        var optionIngresosSoles = {
            tooltip: {
                trigger: 'axis',
                position: function(pt) {
                    return [pt[0], '10%'];
                }
            },
            title: {
                left: 'center',
                text: 'INGRESOS EN SOLES POR DÍA'
            },
            toolbox: {
                feature: {
                    dataZoom: {
                        yAxisIndex: 'none'
                    },
                    restore: {},
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: dateIngresosSoles
            },
            yAxis: {
                type: 'value',
                boundaryGap: [0, '100%']
            },
            dataZoom: [{
                type: 'inside',
                start: 0,
                end: 10
            }, {
                start: 0,
                end: 10
            }],
            series: [{
                name: 'Monto',
                type: 'line',
                symbol: 'none',
                sampling: 'lttb',
                itemStyle: {
                    color: '#000'
                },
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgb(255, 158, 68)'
                        },
                        {
                            offset: 1,
                            color: 'rgb(255, 70, 131)'
                        }
                    ])
                },
                data: dataIngresosSoles
            }]
        };
        optionIngresosSoles && myChartIngresosSoles.setOption(optionIngresosSoles);
    </script>

    <!-- Ingresos en dólares chart -->
    <script>
        const ingresosDataDol = @json($ingresos_cuentas_dolares);

        let dateIngresosDol = ingresosDataDol.map(entry => entry.date);
        let dataIngresosDol = ingresosDataDol.map(entry => entry.total_monto);

        var chartDomIngresosDol = document.getElementById('chart-container_ingresos_dolares');
        var myChartIngresosDol = echarts.init(chartDomIngresosDol, 'dark');
        var optionIngresosDol = {
            tooltip: {
                trigger: 'axis',
                position: function(pt) {
                    return [pt[0], '10%'];
                }
            },
            title: {
                left: 'center',
                text: 'INGRESOS EN DÓLARES POR DÍA'
            },
            toolbox: {
                feature: {
                    dataZoom: {
                        yAxisIndex: 'none'
                    },
                    restore: {},
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: dateIngresosDol
            },
            yAxis: {
                type: 'value',
                boundaryGap: [0, '100%']
            },
            dataZoom: [{
                type: 'inside',
                start: 0,
                end: 10
            }, {
                start: 0,
                end: 10
            }],
            series: [{
                name: 'Monto',
                type: 'line',
                symbol: 'none',
                sampling: 'lttb',
                itemStyle: {
                    color: '#000'
                },
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgb(255, 158, 68)'
                        },
                        {
                            offset: 1,
                            color: 'rgb(255, 70, 131)'
                        }
                    ])
                },
                data: dataIngresosDol
            }]
        };
        optionIngresosDol && myChartIngresosDol.setOption(optionIngresosDol);
    </script>

    <!-- Salidas en soles chart -->
    <script>
        const salidasDataSol = @json($salidas_cuentas_soles);

        let dateSalidasSoles = salidasDataSol.map(entry => entry.date);
        let dataSalidasSoles = salidasDataSol.map(entry => entry.total_monto);

        var chartDomSalidasSoles = document.getElementById('chart-container_salidas_soles');
        var myChartSalidasSoles = echarts.init(chartDomSalidasSoles, 'dark');
        var optionSalidasSoles = {
            tooltip: {
                trigger: 'axis',
                position: function(pt) {
                    return [pt[0], '10%'];
                }
            },
            title: {
                left: 'center',
                text: 'SALIDAS EN SOLES POR DÍA'
            },
            toolbox: {
                feature: {
                    dataZoom: {
                        yAxisIndex: 'none'
                    },
                    restore: {},
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: dateSalidasSoles
            },
            yAxis: {
                type: 'value',
                boundaryGap: [0, '100%']
            },
            dataZoom: [{
                type: 'inside',
                start: 0,
                end: 10
            }, {
                start: 0,
                end: 10
            }],
            series: [{
                name: 'Monto',
                type: 'line',
                symbol: 'none',
                sampling: 'lttb',
                itemStyle: {
                    color: '#000'
                },
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgb(255, 70, 131)'
                        },
                        {
                            offset: 1,
                            color: 'rgb(255, 158, 68)'
                        }
                    ])
                },
                data: dataSalidasSoles
            }]
        };
        optionSalidasSoles && myChartSalidasSoles.setOption(optionSalidasSoles);
    </script>

    <!-- Salidas en dólares chart -->
    <script>
        const salidasDataDol = @json($salidas_cuentas_dolares);

        let dateSalidasDol = salidasDataDol.map(entry => entry.date);
        let dataSalidasDol = salidasDataDol.map(entry => entry.total_monto);

        var chartDomSalidasDol = document.getElementById('chart-container_salidas_dolares');
        var myChartSalidasDol = echarts.init(chartDomSalidasDol, 'dark');
        var optionSalidasDol = {
            tooltip: {
                trigger: 'axis',
                position: function(pt) {
                    return [pt[0], '10%'];
                }
            },
            title: {
                left: 'center',
                text: 'SALIDAS EN DÓLARES POR DÍA'
            },
            toolbox: {
                feature: {
                    dataZoom: {
                        yAxisIndex: 'none'
                    },
                    restore: {},
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: dateSalidasDol
            },
            yAxis: {
                type: 'value',
                boundaryGap: [0, '100%']
            },
            dataZoom: [{
                type: 'inside',
                start: 0,
                end: 10
            }, {
                start: 0,
                end: 10
            }],
            series: [{
                name: 'Monto',
                type: 'line',
                symbol: 'none',
                sampling: 'lttb',
                itemStyle: {
                    color: '#000'
                },
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgb(255, 70, 131)'
                        },
                        {
                            offset: 1,
                            color: 'rgb(255, 158, 68)'
                        }
                    ])
                },
                data: dataSalidasDol
            }]
        };
        optionSalidasDol && myChartSalidasDol.setOption(optionSalidasDol);
    </script>



























    <script>
        var chart = LightweightCharts.createChart(document.getElementById('container1'), {
            height: 300,
            rightPriceScale: {
                scaleMargins: {
                    top: 0.1,
                    bottom: 0.1,
                },
                mode: LightweightCharts.PriceScaleMode.Logarithmic,
            },
            crossHairMove: false, // Disable crosshair watermark
        });

        var lineSeries = chart.addLineSeries({
            color: 'rgb(85, 107, 47)',
            lineWidth: 3,
        });

        @php
            // Grouping salidas_cuentas by day and summing monto
            $groupedData = $inventarios_ingresos_soles
                ->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
                })
                ->map(function ($dayData) {
                    return $dayData->sum('total');
                });

            $data = $groupedData
                ->map(function ($sumMonto, $date) {
                    return [
                        'time' => $date,
                        'value' => $sumMonto,
                    ];
                })
                ->values()
                ->toArray(); // Ensure it’s an array
        @endphp

        var data = @json($data);
        console.log(data); // Debugging line to check data
        lineSeries.setData(data);
    </script>


    <script>
        var chart = LightweightCharts.createChart(document.getElementById('container2'), {
            height: 300,
            rightPriceScale: {
                scaleMargins: {
                    top: 0.1,
                    bottom: 0.1,
                },
                mode: LightweightCharts.PriceScaleMode.Logarithmic,
            },
            crossHairMove: false, // Disable crosshair watermark
        });

        var lineSeries = chart.addLineSeries({
            color: '#008B8B',
            lineWidth: 3,
        });

        var data = [];

        @php
            // Grouping salidas_cuentas by day and summing monto
            $groupedData = $inventarios_ingresos_dolares
                ->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
                })
                ->map(function ($dayData) {
                    return $dayData->sum('total');
                });
        @endphp

        @foreach ($groupedData as $date => $sumMonto)
            data.push({
                time: {{ \Carbon\Carbon::parse($date)->timestamp }},
                value: {{ $sumMonto }},
            });
        @endforeach

        // Set the summarized data to the lineSeries
        lineSeries.setData(data);
    </script>


@stop
