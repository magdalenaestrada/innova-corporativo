@extends('admin.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/areas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
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
            <div class="loader col-md-6">
                {{ __('ADELANTOS REGISTRADOS') }}
            </div>


            <div class="text-right col-md-6">


                @can('edit cuenta')
                    <a class="" href="#" data-toggle="modal" data-target="#ModalCreate">
                        <button class="button-create">
                            {{ __('REGISTRAR ADELANTO') }}
                        </button>
                    </a>
                @endcan

            </div>



        </div>

        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="row">

                        <div class="col-md-6">
                            <input type="text" name="searcha" id="searcha" class="input-search form-control"
                                placeholder="Buscar Aquí...">
                        </div>

                        <div class="col-md-6 d-flex justify-content-end">
                            <a href="{{ route('lqadelantos.export-excel') }}" id="exportExcelLink"
                                class="button_export-excel">
                                <span class="button__text">
                                    <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 50 50">
                                        <path
                                            d="M28.8125 .03125L.8125 5.34375C.339844
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

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="adelantos-table" class="table table-striped text-center">
                                <thead>
                                    <tr style="font-size: 13px">

                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>

                                        <th>
                                            {{ __('SALIDA CUENTA ID') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('FECHA') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('TIPO') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('TIPO COMPROB.') }}
                                        </th>

                                        <th>
                                            {{ __('COMPROB. NRO') }}
                                        </th>


                                        <th scope="col">
                                            {{ __('CUENTA') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('CÓDIGO CLIENTE') }}
                                        </th>




                                        <th scope="col">
                                            {{ __('MOTIVO') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('DESCRIPCIÓN') }}
                                        </th>


                                        <th scope="col">
                                            {{ __('NOMBRE CLIENTE') }}
                                        </th>



                                        <th scope="col">
                                            {{ __('RESPONSABLE') }}
                                        </th>

                                        <th scope="col" style="min-width: 100px">
                                            {{ __('SIN DETRACCIÓN') }}
                                        </th>

                                        <th scope="col" style="min-width: 100px">
                                            {{ __('ESTADO') }}
                                        </th>
                                        <th scope="col" style="min-width: 100px">
                                            {{ __('MONTO') }}
                                        </th>

                                       
                                        @can('edit cuenta')
                                            <th scope="col">
                                                {{ __('ACCIÓN') }}
                                            </th>
                                        @endcan

                                    </tr>
                                </thead>

                                <tbody style="font-size: 13px">
                                    @if (count($adelantos) > 0)
                                        @foreach ($adelantos as $adelanto)
                                            @if ($adelanto->cerrado)
                                            <tr class="bg-info ">

                                            @else
                                            <tr>

                                            @endif

                                            <td>{{ $adelanto->id }}</td>
                                            <td>{{ $adelanto->salidacuenta ? $adelanto->salidacuenta->id : '' }}</td>
                                            <td scope="row">
                                                @if ($adelanto->fecha)
                                                    {{ strtoupper($adelanto->fecha->format('d/m/Y')) }}
                                                @endif
                                            </td>

                                            <td scope="row">
                                                <span class="badge bg-danger">EGRESO</span>
                                                <span class="badge bg-light">{{ strtoupper('adelanto') }}</span>
                                            </td>

                                            <td scope="row">
                                                @if ($adelanto->salidacuenta->tipocomprobante)
                                                    {{ strtoupper($adelanto->salidacuenta->tipocomprobante->nombre) }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td scope="row">
                                                @if ($adelanto->salidacuenta->comprobante_correlativo)
                                                    {{ strtoupper($adelanto->salidacuenta->comprobante_correlativo) }}
                                                @else
                                                    001-IN-{{ $adelanto->id }}
                                                @endif
                                            </td>


                                            <td scope="row">
                                                @if ($adelanto->salidacuenta->cuenta)
                                                    {{ strtoupper($adelanto->salidacuenta->cuenta->nombre) }}
                                                @endif
                                            </td>


                                            <td scope="row">
                                                @if ($adelanto->sociedad)
                                                    {{ strtoupper($adelanto->sociedad->codigo) }}
                                                @else
                                                    -
                                                @endif

                                            </td>

                                            <td scope="row">
                                                @if ($adelanto->salidacuenta->motivo)
                                                    {{ strtoupper($adelanto->salidacuenta->motivo->nombre) }}
                                                @else
                                                    -
                                                @endif

                                            </td>


                                            <td scope="row" style="min-width: 150px">
                                                @if ($adelanto->salidacuenta->descripcion)
                                                    {{ strtoupper($adelanto->salidacuenta->descripcion) }}
                                                @else
                                                    -
                                                @endif

                                            </td>

                                            <td scope="row">
                                                @if ($adelanto->sociedad)
                                                    {{ strtoupper($adelanto->sociedad->nombre) }}
                                                @else
                                                    -
                                                @endif

                                            </td>

                                            <td>
                                                {{ strtoupper($adelanto->creador->name) }}
                                            </td>


                                            <td>
                                                @php
                                                    if (
                                                        strtoupper(
                                                            $adelanto->salidacuenta->cuenta->tipomoneda->nombre,
                                                        ) == 'DOLARES'
                                                    ) {
                                                        $coin_simbol = '$';
                                                    } else {
                                                        $coin_simbol = 'S/.';
                                                    }

                                                @endphp
                                                @if ($adelanto->total_sin_detraccion)
                                                    <div class="d-flex justify-content-between">
                                                        <p>{{ $coin_simbol }}</p>
                                                        <p> {{ number_format($adelanto->total_sin_detraccion, 2) }}</p>
                                                    </div>
                                                @else
                                                    -
                                                @endif


                                            </td>

                                            <td scope="row" >
                                            @if ($adelanto->cerrado)
                                            CERRADO

                                            @else
                                           
                                            PENDIENTE
                                            @endif
                                            </td>

                                            <td scope="row" style="min-width: 100px">




                                                <div class="d-flex justify-content-between">
                                                    <p>{{ $coin_simbol }}</p>
                                                    <p> {{ number_format($adelanto->salidacuenta->monto, 2) }}</p>
                                                </div>

                                            </td>

                                            @can('edit cuenta')
                                                <td class="btn-group align-items-center">
                                                    @if ($adelanto->cerrado == 0)
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#ModalEdit{{ $adelanto->id }}" class="">

                                                            <button class="editBtn" style="margin-left: 5px; margin-top:-3px">
                                                                <svg height="1em" viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </a>
                                                    @endif




                                                    <a href="{{ route('lqadelantos.printdoc', $adelanto->id) }}" class="btnprn"
                                                        style="margin-left: 5px;">

                                                        <div class="printer">
                                                            <div class="paper">

                                                                <svg viewBox="0 0 8 8" class="svg">
                                                                    <path fill="#0077FF"
                                                                        d="M6.28951 1.3867C6.91292 0.809799 7.00842 0 7.00842 0C7.00842 0 6.45246 0.602112 5.54326 0.602112C4.82505 0.602112 4.27655 0.596787 4.07703 0.595012L3.99644 0.594302C1.94904 0.594302 0.290039 2.25224 0.290039 4.29715C0.290039 6.34206 1.94975 8 3.99644 8C6.04312 8 7.70284 6.34206 7.70284 4.29715C7.70347 3.73662 7.57647 3.18331 7.33147 2.67916C7.08647 2.17502 6.7299 1.73327 6.2888 1.38741L6.28951 1.3867ZM3.99679 6.532C2.76133 6.532 1.75875 5.53084 1.75875 4.29609C1.75875 3.06133 2.76097 2.06018 3.99679 2.06018C4.06423 2.06014 4.13163 2.06311 4.1988 2.06905L4.2414 2.07367C4.25028 2.07438 4.26057 2.0758 4.27406 2.07651C4.81533 2.1436 5.31342 2.40616 5.67465 2.81479C6.03589 3.22342 6.23536 3.74997 6.23554 4.29538C6.23554 5.53084 5.23439 6.532 3.9975 6.532H3.99679Z">
                                                                    </path>
                                                                    <path fill="#0055BB"
                                                                        d="M6.756 1.82386C6.19293 2.09 5.58359 2.24445 4.96173 2.27864C4.74513 2.17453 4.51296 2.10653 4.27441 2.07734C4.4718 2.09225 5.16906 2.07947 5.90892 1.66374C6.04642 1.58672 6.1743 1.49364 6.28986 1.38647C6.45751 1.51849 6.61346 1.6647 6.756 1.8235V1.82386Z">
                                                                    </path>
                                                                </svg>

                                                            </div>
                                                            <div class="dot"></div>
                                                            <div class="output">
                                                                <div class="paper-out"></div>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    @if ($adelanto->cerrado == 0)
                                                        <div class="">
                                                            <form class="eliminar-registro"
                                                                action="{{ route('lqadelantos.destroy', $adelanto->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="bin-button ml-1 btn anular eliminar-registro">
                                                                    <!-- SVG Icon -->
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 39 7" class="bin-top">
                                                                        <line stroke-width="4" stroke="white" y2="5"
                                                                            x2="39" y1="5">
                                                                        </line>
                                                                        <line stroke-width="3" stroke="white" y2="1.5"
                                                                            x2="26.0357" y1="1.5" x1="12">
                                                                        </line>
                                                                    </svg>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 33 39" class="bin-bottom">
                                                                        <mask fill="white" id="path-1-inside-1_8_19">
                                                                            <path
                                                                                d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z">
                                                                            </path>
                                                                        </mask>
                                                                        <path mask="url(#path-1-inside-1_8_19)" fill="white"
                                                                            d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z">
                                                                        </path>
                                                                        <path stroke-width="4" stroke="white" d="M12 6L12 29">
                                                                        </path>
                                                                        <path stroke-width="4" stroke="white" d="M21 6V29">
                                                                        </path>
                                                                    </svg>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 89 80" class="garbage">
                                                                        <path fill="white"
                                                                            d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z">
                                                                        </path>
                                                                    </svg>
                                                                </button>
                                                            </form>

                                                        </div>



                                                        
                                                    @endif
                                                </td>
                                            @endcan



                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="15" class="text-center text-muted">
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
                                {{ $adelantos->links('pagination::bootstrap-4') }}
                            </div>
                            <div>
                                Mostrando del {{ $adelantos->firstItem() }} al {{ $adelantos->lastItem() }} de
                                {{ $adelantos->total() }} registros
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    @include('tesoreria.adelantos.modal.create')

    @foreach ($adelantos as $adelanto)
        @include('tesoreria.adelantos.modal.edit')
    @endforeach




@stop

@section('js')

    <script type="text/javascript" src="{{ asset('js/jquery.printPage.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.buscador').select2({
                theme: "classic"
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.btnprn').printPage();

        });
    </script>

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
            $('#searcha').on('input', function(e) {
                e.preventDefault();
                let search_string = $(this).val();
                $.ajax({
                    url: "{{ route('searcha.lqadelantos') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {

                        $('#adelantos-table tbody').html(response);
                    },
                    error: function(xhr, status, error) {}

                });

            });

        });
    </script>

    <script>
        //FINDING DOCUMENTO REPRESENTANTE ADELLANTO FUNCTIONALITY
        $('#nombre').on('input', function(e) {
            e.preventDefault();
            let search_string = $(this).val();
            if (search_string.length >= 10) {
                $.ajax({
                    url: "{{ route('autocomp.representadelanto') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {
                        console.log(1)

                        $('#documento').val(response.documento);

                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }
        });






        $('.eliminar-registro').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar adelanto?',
                text: 'Esta seguro que quiere eliminar este adelanto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#0d0',
                confirmButtonText: '¡Sí, continuar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>

    <script>
        document.getElementById('exportExcelLink').addEventListener('click', function(event) {
            event.preventDefault(); // Prevents the link from navigating immediately

            // Get the values from the date inputs
            const string = document.getElementById('searcha').value;

            // Construct the URL with query parameters for desde and hasta
            const exportUrl =
                `{{ route('lqadelantos.export-excel') }}?string=${encodeURIComponent(string)}`;

            // Update the href attribute with the constructed URL
            this.setAttribute('href', exportUrl);

            // Redirect to the new URL
            window.location.href = exportUrl;
        });
    </script>
@stop
