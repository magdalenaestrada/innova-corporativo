@extends('admin.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
    <div class="container">


        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('PRODUCTOS REGISTRADOS') }}

                        </div>
                        <div class="text-right col-md-6">
                            <a class="btn btn-sm btn-special" href="{{ route('productos.create') }}">
                                {{ __('CREAR PRODUCTO') }}
                            </a>
                        </div>

                    </div>
                    <div class="row align-items-center justify-content-between p-3">

                        <div class="col-md-6 input-container">
                            <input type="text" name="searchp" id="searchp" class="input-search form-control"
                                placeholder="Buscar Aquí...">

                        </div>

                        <a href="{{ route('productos.export-excel') }}" class="button_export-excel"
                            type="button_export-excel">
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
                                        20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z"></path>
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

                    <div class="card-body  ">
                        <a href="{{ route('productosfamilias.index') }}" class="btn btn-primary mx-2">Familias de
                            Productos</a>

                        <div class="table-responsive">
                            <table id="products-table" class="table table-striped  table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('NOMBRE') }}
                                        </th>
    
    
    
                                        <th scope="col">
                                            {{ __('STOCK') }}
                                        </th>
    
                                        <th scope="col" class="text-center">
                                            {{ __('V.U.') }}
                                        </th>
    
    
    
                                     
    
                                        <th scope="col">
                                            {{ __('UNIDAD') }}
                                        </th>
    
    
    
                                        <th scope="col">
                                            {{ __('ACCIÓN') }}
                                        </th>
                                    </tr>
                                </thead>
    
                                <tbody style="font-size: 13px">
                                    @if (count($productos) > 0)
                                        @foreach ($productos as $producto)
                                            <tr class="text-center">
                                                <td scope="row">
                                                    {{ $producto->id }}
                                                </td>
    
                                                <td scope="row">
                                                    {{ $producto->nombre_producto }}
                                                    @if ($producto->stock == 0)
                                                        <span class="text-danger"
                                                            style="font-style: Monospace;font-weight:600; font-size: 16px"> (SIN
                                                            STOCK)</span>
                                                    @endif
                                                </td>
    
    
    
    
                                                <td scope="row">
                                                    @if ($producto->stock)
                                                        {{ $producto->stock }}
                                                    @else
                                                        {{ __('-') }}
                                                    @endif
                                                </td>
    
                                                <td scope="row" class="text-center">
                                                    @if ($producto->precio)
                                                        s/{{ $producto->precio }}
                                                    @else
                                                        {{ __('-') }}
                                                    @endif
                                                </td>
    
    
                                                <td scope="row">
                                                    @if ($producto->unidad_nombre)
                                                        {{ $producto->unidad_nombre }}
                                                    @else
                                                        {{ __('-') }}
                                                    @endif
                                                </td>
    
    
    
                                                <td style="min-width: 150px">
                                                    <div class="btn-group">
                                                        <div class="">
                                                            <a class="btn btn-secondary btn-sm"
                                                                href="{{ route('productos.show', ['producto' => $producto->id, 'page' => request()->page]) }}">
                                                                {{ __('VER') }}
                                                            </a>
    
                                                        </div>
    
                                                        <div class="">
                                                            <a class="btn btn-outline-info btn-sm ml-1"
                                                                href="{{ route('productos.edit', [$producto->id]) }}"
                                                                data-toggle="modal"
                                                                data-target="#ModalEditar{{ $producto->id }}">
                                                                {{ __('EDITAR') }}
                                                            </a>
    
                                                        </div>
    
                                                        <div class="">
                                                            <form class="eliminar-producto"
                                                                action="{{ route('productos.destroy', $producto->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="bin-button btn anular anular-producto"
                                                                    style="margin-left: 5px;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 39 7" class="bin-top">
    
                                                                        <line stroke-width="4" stroke="white" y2="5"
                                                                            x2="39" y1="5"></line>
                                                                        <line stroke-width="3" stroke="white" y2="1.5"
                                                                            x2="26.0357" y1="1.5" x1="12"></line>
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
    
    
                                                        <div>
                                                            <a class="Btn-rotacion" href="{{route('product.dailyrotation', $producto->id)}}">
                                                                <div class="svgWrapper">
                                                                  <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none"
                                                                    viewBox="0 0 42 42"
                                                                    class="svgIcon"
                                                                  >
                                                                    <path
                                                                      stroke-width="5"
                                                                      stroke="#fff"
                                                                      d="M9.14073 2.5H32.8593C33.3608 2.5 33.8291 2.75065 34.1073 3.16795L39.0801 10.6271C39.3539 11.0378 39.5 11.5203 39.5 12.0139V21V37C39.5 38.3807 38.3807 39.5 37 39.5H5C3.61929 39.5 2.5 38.3807 2.5 37V21V12.0139C2.5 11.5203 2.6461 11.0378 2.91987 10.6271L7.89266 3.16795C8.17086 2.75065 8.63921 2.5 9.14073 2.5Z"
                                                                    ></path>
                                                                    <rect
                                                                      stroke-width="3"
                                                                      stroke="#fff"
                                                                      rx="2"
                                                                      height="4"
                                                                      width="11"
                                                                      y="18.5"
                                                                      x="15.5"
                                                                    ></rect>
                                                                    <path stroke-width="5" stroke="#fff" d="M1 12L41 12"></path>
                                                                  </svg>
                                                                  <div class="text">Rotación</div>
                                                                </div>
                                                            </a>
                                                        </div>
    
                                                    </div>
    
    
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
                  



                    </div>


                    <!--pagination-->
                    <div class="d-flex justify-content-between">
                        <div>
                            {{ $productos->links('pagination::bootstrap-4') }}
                        </div>
                        <div>
                            Mostrando del {{ $productos->firstItem() }} al {{ $productos->lastItem() }} de
                            {{ $productos->total() }} registros
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop


@foreach ($productos as $producto)
    @include('productos.modal.edit', ['id' => $producto->id])
@endforeach





@section('js')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/updateadvice.js') }}"></script>


    <script>
        @if (session('eliminar-producto') == 'Producto eliminado con éxito.')
            Swal.fire('Producto', 'eliminado exitosamente.', 'success');
        @elseif (session('crear-producto') == 'Producto creado con éxito.')
            Swal.fire('Producto', 'creado exitosamente.', 'success');
        @elseif (session('actualizar-producto') == 'Producto actualizado con éxito.')
            Swal.fire('Producto', 'actualizado existosamente.', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }


        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            //alert();


            //Search product
            $('#searchp').on('input', function(e) {
                e.preventDefault();
                let search_string = $(this).val();
                $.ajax({
                    url: "{{ route('search.product') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {

                        $('#products-table tbody').html(response);
                        bindModalEvents();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }

                });




                function bindModalEvents() {
                    $('[data-toggle="modal"]').on('click', function() {
                        let targetModal = $(this).data('target');
                        $(targetModal).modal('ModalEditar');
                    });
                }


            });





        });
    </script>
@stop
