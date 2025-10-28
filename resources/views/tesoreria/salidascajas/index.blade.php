@extends('admin.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/areas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
    <div class="container">

        <br>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="loader">
                {{ __('SALIDAS DE LAS CAJAS REGISTRADAS') }}

            </div>
            <div class="text-right col-md-6">
                <a class="" href="#" data-toggle="modal" data-target="#ModalCreate">

                    {{--                 
                <button class="button-create">
                    {{ __('REGISTRAR SALIDA DE LA CAJA') }}
                </button> --}}

                </a>
            </div>
        </div>

        <br>

        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="row">


                        <div class="col-md-6">
                            <input type="text" name="searcht" id="searcht" class="input-search form-control"
                                placeholder="Buscar Aquí...">
                        </div>

                        <div class="col-md-6 d-flex justify-content-end">
                            <a href="#" class="button_export-excel" data-toggle="modal" data-target="#ModalExport">
                                <span class="button__text">
                                    <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 50 50">
                                        <path d="M28.8125 .03125L.8125 5.34375C.339844
                                                5.433594 0 5.863281 0 6.34375L0 43.65625C0
                                                44.136719 .339844 44.566406 .8125 44.65625L28.8125
                                                49.96875C28.875 49.980469 28.9375 50 29 50C29.230469
                                                50 29.445313 49.929688 29.625 49.78125C29.855469 49.589844
                                                30 49.296875 30 49L30 1C30 .703125 29.855469 .410156 29.625
                                                .21875C29.394531 .0273438 29.105469 -.0234375 28.8125 .03125ZM32
                                                6L32 13L34 13L34 15L32 15L32 20L34 20L34 22L32 22L32 27L34 27L34
                                                29L32 29L32 35L34 35L34 37L32 37L32 44L47 44C48.101563 44 49
                                                43.101563 49 42L49 8C49 6.898438 48.101563 6 47 6ZM36 13L44
                                                13L44 15L36 15ZM6.6875 15.6875L11.8125 15.6875L14.5 21.28125C14.710938
                                                21.722656 14.898438 22.265625 15.0625 22.875L15.09375 22.875C15.199219
                                                22.511719 15.402344 21.941406 15.6875 21.21875L18.65625 15.6875L23.34375
                                                15.6875L17.75 24.9375L23.5 34.375L18.53125 34.375L15.28125
                                                28.28125C15.160156 28.054688 15.035156 27.636719 14.90625
                                                27.03125L14.875 27.03125C14.8125 27.316406 14.664063 27.761719
                                                14.4375 28.34375L11.1875 34.375L6.1875 34.375L12.15625 25.03125ZM36
                                                20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z">
                                        </path>
                                    </svg>

                                    Descargar
                                </span>
                                <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35"
                                        id="bdd05811-e15d-428c-bb53-8661459f9307" data-name="Layer 2" class="svg">
                                        <path
                                            d="M17.5,22.131a1.249,1.249,0,0,1-1.25-1.25V2.187a1.25,1.25,0,0,1,2.5,0V20.881A1.25,1.25,0,0,1,17.5,22.131Z">
                                        </path>
                                        <path
                                            d="M17.5,22.693a3.189,3.189,0,0,1-2.262-.936L8.487,15.006a1.249,1.249,0,0,1,1.767-1.767l6.751,6.751a.7.7,0,0,0,.99,0l6.751-6.751a1.25,1.25,0,0,1,1.768,1.767l-6.752,6.751A3.191,3.191,0,0,1,17.5,22.693Z">
                                        </path>
                                        <path
                                            d="M31.436,34.063H3.564A3.318,3.318,0,0,1,.25,30.749V22.011a1.25,1.25,0,0,1,2.5,0v8.738a.815.815,0,0,0,.814.814H31.436a.815.815,0,0,0,.814-.814V22.011a1.25,1.25,0,1,1,2.5,0v8.738A3.318,3.318,0,0,1,31.436,34.063Z">
                                        </path>
                                    </svg></span>
                            </a>
                        </div>

                    </div>

                    <div class="card-body ">

                        <table id="salidascajas-table" class="table table-striped  ">
                            <thead>
                                <tr>

                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('FECHA') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('CAJA') }}
                                    </th>


                                    <th>
                                        {{ __('TIPO COMPR.') }}
                                    </th>

                                    <th>
                                        {{ __('NRO COMPR.') }}
                                    </th>

                                    <th>
                                        {{ __('FECHA COMPR.') }}
                                    </th>


                                    <th scope="col">
                                        {{ __('MOTIVO') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('REPOSICIÓN') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('BENEFICIARIO') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('DESCRIPCION') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('MONTO') }}
                                    </th>

                                </tr>
                            </thead>

                            <tbody style="font-size: 13px">
                                @if (count($salidascajas) > 0)
                                    @foreach ($salidascajas as $salidacaja)
                                        <tr>

                                            <td>{{$salidacaja->id}}</td>

                                            <td scope="row">
                                                {{ \Carbon\Carbon::parse($salidacaja->created_at)->format('d/m/Y H:i') }}
                                            </td>






                                            <td scope="row">
                                                @if ($salidacaja->caja)
                                                    {{ strtoupper($salidacaja->caja->nombre) }}
                                                @endif
                                            </td>

                                            <td scope="row">
                                                @if ($salidacaja->tipocomprobante)
                                                    {{ strtoupper($salidacaja->tipocomprobante->nombre) }}
                                                @endif
                                            </td>

                                            <td scope="row">
                                                @if ($salidacaja->comprobante_correlativo)
                                                    {{ strtoupper($salidacaja->comprobante_correlativo) }}
                                                @else
                                                    IN-{{ $salidacaja->id }}
                                                @endif


                                            </td>

                                            <td scope="row">
                                                @if ($salidacaja->fecha_comprobante)
                                                    {{ \Carbon\Carbon::parse($salidacaja->fecha_comprobante)->format('d/m/Y') }}
                                                @endif
                                            </td>



                                            <td scope="row">
                                                @if ($salidacaja->motivo)
                                                    {{ strtoupper($salidacaja->motivo->nombre) }}
                                                @endif


                                            </td>


                                            <td scope="row">
                                                @if ($salidacaja->motivo)
                                                    {{ strtoupper($salidacaja->reposicion_id) }}
                                                @endif


                                            </td>



                                            <td scope="row">
                                                @if ($salidacaja->beneficiario)
                                                    {{ strtoupper($salidacaja->beneficiario->nombre) }}
                                                @endif


                                            </td>


                                            <td scope="row">
                                                {{ $salidacaja->descripcion }}

                                            </td>
                                            <td scope="row" style="min-width: 100px">

                                                <div class="d-flex justify-content-between">
                                                    <p>S/.</p>
                                                    <p> -{{ number_format($salidacaja->monto, 2) }}</p>
                                                </div>

                                            </td>



                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="13" class="text-center text-muted">
                                            {{ __('No hay datos disponibles') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between">
                            <div>
                                {{ $salidascajas->links('pagination::bootstrap-4') }}
                            </div>
                            <div>
                                Mostrando del {{ $salidascajas->firstItem() }} al {{ $salidascajas->lastItem() }} de
                                {{ $salidascajas->total() }} registros
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('tesoreria.salidascajas.modal.create')
    @include('tesoreria.salidascajas.modal.export')

@stop

@section('js')

    <script>
        @if (session('status'))
            Swal.fire('Éxito', '{{ session('status') }}', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            //alert();

            //Search product
            $('#searcht').on('input', function(e) {
                e.preventDefault();
                let search_string = $(this).val();
                $.ajax({
                    url: "{{ route('search.tssalidascajas') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {

                        $('#salidascajas-table tbody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }

                });

            });

        });
    </script>
@stop
