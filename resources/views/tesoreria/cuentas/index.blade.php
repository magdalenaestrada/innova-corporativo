@extends('admin.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/areas.css') }}">
@endpush

@section('content')
    <div class="container">

        <br>


        @foreach ($chats as $chat)
            @php
                // Determine the correct recipient name
                $recipient = $chat->user_id === auth()->id() ? $chat->recipient : $chat->user;
                $lastMessage = $chat->messages->first(); // Get the last message (already fetched in the query)

                // Determine if the last message is from the logged-in user or the recipient
                $lastMessageSender = $lastMessage && $lastMessage->user_id === auth()->id() ? 'Tú' : $recipient->name;
            @endphp

            @if ($lastMessage && $lastMessage->is_read == false && $lastMessageSender != 'Tú')
                <div class="alert alert-success alert-dismissible fade show align-items-center" role="alert"
                    style="margin-top: -10px; 
            background-color: #D1E7DD;
            border: 1px solid #A3CFBB;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            font-size:12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: -10px;
            position: relative;
            font-family: sans-serif;
            
            ">
                    <a style="display: block; font-size: 13px; color: black; text-decoration: none;"
                        href="{{ route('chats.show', $chat) }}">
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
        <div class="row d-flex justify-content-between align-items-center">
            <div class="loader">
                {{ __('CUENTAS REGISTRADAS') }}

            </div>

            @can('edit cuenta')
                <div class="text-right col-md-6">
                    <a class="" href="#" data-toggle="modal" data-target="#ModalCreate">
                        <button class="button-create">
                            {{ __('CREAR CUENTA') }}
                        </button>

                    </a>
                </div>
            @endcan

        </div>

        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="posiciones-table" class="table table-striped  ">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('NOMBRE') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('BANCO') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('ENCARGADO') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('BALANCE') }}
                                        </th>

                                        <th scope="col">
                                        </th>

                                    </tr>
                                </thead>

                                <tbody style="font-size: 13px" class="text-center">
                                    @if (count($cuentas) > 0)
                                        @foreach ($cuentas as $cuenta)
                                            <tr>
                                                <td scope="row">
                                                    {{ $cuenta->id }}
                                                </td>

                                                <td scope="row">
                                                    {{ strtoupper($cuenta->nombre) }}
                                                </td>

                                                <td scope="row">
                                                    @if ($cuenta->banco)
                                                        {{ strtoupper($cuenta->banco->nombre) }}
                                                    @endif
                                                </td>

                                                <td scope="row">
                                                    @if ($cuenta->encargado)
                                                        {{ strtoupper($cuenta->encargado->nombre) }}
                                                    @endif
                                                </td>

                                                <td scope="row">

                                                    <div class="d-flex justify-content-between align-items-center ">
                                                        @php
                                                            $coin_simbol =
                                                                $cuenta->tipomoneda->nombre == 'DOLARES' ? '$' : 'S/.';
                                                            $ingresosTotal = $cuenta->ingresos->sum('monto');
                                                            $salidasTotal = $cuenta->salidas->sum('monto');
                                                            $difference = $ingresosTotal - $salidasTotal;
                                                        @endphp
                                                        <p class="mr-1">{{ $coin_simbol }}</p>
                                                        <p>
                                                            @if ($cuenta)
                                                                {{ number_format($difference, 2) }}
                                                            @else
                                                                0
                                                            @endif
                                                        </p>
                                                    </div>
                                                </td>

                                                <td class="text-center btn-group align-items-center">





                                                    <a href="{{ route('tscuentasreportesdiarios.show', [$cuenta->id]) }}">
                                                        <button class="readmore-btn">
                                                            <span class="book-wrapper">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    fill="rgb(86, 69, 117)" viewBox="0 0 126 75"
                                                                    class="book">
                                                                    <rect stroke-width="3" stroke="#fff" rx="7.5"
                                                                        height="70" width="121" y="2.5" x="2.5">
                                                                    </rect>
                                                                    <line stroke-width="3" stroke="#fff" y2="75"
                                                                        x2="63.5" x1="63.5"></line>
                                                                    <path stroke-linecap="round" stroke-width="4"
                                                                        stroke="#fff" d="M25 20H50"></path>
                                                                    <path stroke-linecap="round" stroke-width="4"
                                                                        stroke="#fff" d="M101 20H76"></path>
                                                                    <path stroke-linecap="round" stroke-width="4"
                                                                        stroke="#fff" d="M16 30L50 30"></path>
                                                                    <path stroke-linecap="round" stroke-width="4"
                                                                        stroke="#fff" d="M110 30L76 30"></path>
                                                                </svg>

                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 65 75" class="book-page">
                                                                    <path stroke-linecap="round" stroke-width="4"
                                                                        stroke="#fff" d="M40 20H15"></path>
                                                                    <path stroke-linecap="round" stroke-width="4"
                                                                        stroke="#fff" d="M49 30L15 30"></path>
                                                                    <path stroke-width="3" stroke="#fff"
                                                                        d="M2.5 2.5H55C59.1421 2.5 62.5 5.85786 62.5 10V65C62.5 69.1421 59.1421 72.5 55 72.5H2.5V2.5Z">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                            <span class="text"> Ver Reporte </span>
                                                        </button>
                                                    </a>



                                                    @can('edit cuenta')
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#ModalEdit{{ $cuenta->id }}" class="ml-1">

                                                            <button class="editBtn" style="margin-left: 5px; margin-top:-3px">
                                                                <svg height="1em" viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </a>
                                                    @endcan

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">
                                                {{ __('No hay datos disponibles') }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>




                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between">
                            <div>
                                {{ $cuentas->links('pagination::bootstrap-4') }}
                            </div>
                            <div>
                                Mostrando del {{ $cuentas->firstItem() }} al {{ $cuentas->lastItem() }} de
                                {{ $cuentas->total() }} registros
                            </div>
                        </div>






                    </div>




                </div>
                <div id="radarchartcontainerAdelantosDolares" style="margin: 40px auto; width: 1000px; height: 400px;">
                </div>
                <div id="radarchartcontainerAdelantosSoles" style="margin: 40px auto; width: 1000px; height: 400px; "></div>
            </div>
        </div>
    </div>

    @include('tesoreria.cuentas.modal.create')


    @foreach ($cuentas as $cuenta)
        @include('tesoreria.cuentas.modal.edit')
    @endforeach

@stop

@section('js')



    <script>
        @if (session('status'))
            Swal.fire('Éxito', '{{ session('status') }}', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>


    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.1/dist/echarts.min.js"></script>



    <script>
        // Data from Laravel for Dolares
        const sociedadesDolares = @json($sociedadesDolares);
        const maxValueDolares = Math.max(...sociedadesDolares.map(s => s.total));

        // Prepare radar chart indicators and values for Dolares
        const indicatorsDolares = sociedadesDolares.map(s => ({
            name: s.name,
            max: maxValueDolares
        }));
        const valuesDolares = sociedadesDolares.map(s => s.total);

        // Initialize the radar chart for Dolares
        const chartDomDolares = document.getElementById('radarchartcontainerAdelantosDolares');
        const chartDolares = echarts.init(chartDomDolares);

        const optionDolares = {
            title: {
                text: 'Top Sociedades/Adelantos'
            },
            legend: {
                data: ['DOLARES']
            },
            radar: {
                indicator: indicatorsDolares
            },
            series: [{
                name: 'Adelantos',
                type: 'radar',
                areaStyle: { color: 'rgba(8, 100, 100, 1)' }, // Fill area with semi-transparent green
            lineStyle: { color: 'rgba(8, 100, 100, 1)' }, // Line color
            itemStyle: { color: 'rgba(8, 100, 100, 1)' }, // Point color
                data: [{
                    value: valuesDolares,
                    name: 'DOLARES'
                }]
            }]
        };

        chartDolares.setOption(optionDolares);
    </script>

    <script>
        // Data from Laravel for Soles
        const sociedadesSoles = @json($sociedadesSoles);
        const maxValueSoles = Math.max(...sociedadesSoles.map(s => s.total));

        // Prepare radar chart indicators and values for Soles
        const indicatorsSoles = sociedadesSoles.map(s => ({
            name: s.name,
            max: maxValueSoles
        }));
        const valuesSoles = sociedadesSoles.map(s => s.total);

        // Initialize the radar chart for Soles
        const chartDomSoles = document.getElementById('radarchartcontainerAdelantosSoles');
        const chartSoles = echarts.init(chartDomSoles);

        const optionSoles = {
            title: {
                text: 'Top Sociedades/Adelantos'
            },
            legend: {
                data: ['SOLES']
            },
            radar: {
                indicator: indicatorsSoles
            },
            series: [{
            name: 'Adelantos',
            type: 'radar',
            areaStyle: { color: 'rgba(0, 128, 0, 0.5)' }, // Fill area with semi-transparent green
            lineStyle: { color: 'green' }, // Line color
            itemStyle: { color: 'green' }, // Point color
            data: [{
                value: valuesSoles,
                name: 'SOLES'
            }]
            }]
        };

        chartSoles.setOption(optionSoles);
    </script>




@stop
