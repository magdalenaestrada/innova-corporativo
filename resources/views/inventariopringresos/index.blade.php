@extends('admin.layout')

@section('content')
    <div class="container">


        <br>


        <div class="row justify-content-center">   
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                        {{ __('TODOS LOS PRÉSTAMOS COMO INGRESOS REGISTRADOS') }}

                        </div>
                        <div class="col-md-6 text-right">
                            @can('crear registro')

                                <a class="btn btn-sm btn-special" href="#" data-toggle="modal" data-target="#ModalCreate">
                                    {{ __('CREAR NUEVO PRÉSTAMO') }}
                                </a>
                            @endcan
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                @if (count($prestamoingresos) > 0)
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                {{ __('ID') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('ORIGEN') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('FECHA Y HORA DE CREACIÓN') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('CONDICIÓN') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('PRODUCTO') }}
                                            </th>
    
                                            <th scope="col">
                                                {{ __('DOCUMENTO RESPONSABLE') }}
                                            </th>
                                            <th scope="col">
                                                {{ __('NOMBRE RESPONSABLE') }}
                                            </th>
    
                                            <th>
                                                {{ __('Acción') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 13px">
                                        @foreach ($prestamoingresos as $prestamoingreso)
                                            <tr>
                                                <td scope="row">
                                                    {{ $prestamoingreso->id }}
                                                </td>
                                                <td scope="row">
                                                    {{ $prestamoingreso->origen }}
                                                </td>
                                                <td scope="row">
                                                    {{ $prestamoingreso->created_at->format('d/m/Y - H:i:s') }}
                                                </td>
                                                <td scope="row">
                                                    {{ $prestamoingreso->condicion }}
                                                </td>
    
                                                <td scope="row">
                                                @if(count($prestamoingreso->productos) > 0)
                                                    {{ $prestamoingreso->productos[0]->nombre_producto }}
                                                @endif
                                                </td>
    
                                                <td scope="row">
                                                    {{ $prestamoingreso->documento_responsable }}
                                                </td>
                                                <td scope="row">
                                                    {{ $prestamoingreso->nombre_responsable }}
                                                </td>
    
                                                <td class="btn-group align-items-center">
                                                    <div>
    
                                                        @if ($prestamoingreso->estado !== 'ANULADO')
                                                                
                                                                <a href="{{ route('inventarioprestamoingreso.show', [$prestamoingreso->id]) }}"
                                                                    class="btn btn-secondary btn-sm " style="height:33px" data-toggle="modal" data-target="#ModalShow{{ $prestamoingreso->id}}">
                                                                    {{ __('VER') }}
                                                                </a>
                                                        @endif
                                                    </div>
    
    
                                                    <div class="">
                                                        @if ($prestamoingreso->estado !== 'ANULADO')
    
                                                            @if ($prestamoingreso->condicion == 'CON DEVOLUCIÓN' && $prestamoingreso->estado != 'PRESTAMO DEVUELTO' && $prestamoingreso->estado != 'ANULADO')
                                                                <a href="{{ route('inventarioprestamoingreso.edit', [$prestamoingreso->id]) }}" data-toggle="modal" data-target="#ModalEntregar{{ $prestamoingreso->id}}"
                                                                    class="btn btn-outline-dark btn-sm ml-1">
                                                                    {{ __('CONFIRMAR DEVOLUCIÓN') }}
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                   
                                                    
    
                                                    <div class="">
                                                        @if ($prestamoingreso->estado !== 'ANULADO' && $prestamoingreso->estado == 'PRESTAMO PENDIENTE DE DEVOLUCIÓN')
                                                            <a href="{{ route('inventarioprestamoingreso.anular', $prestamoingreso->id) }}" class="bin-button btn anular" style="margin-left: 3px;">
                                                                        <svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none"
                                                                                viewBox="0 0 39 7"
                                                                                class="bin-top">
    
                                                                                <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                                                                                <line
                                                                                stroke-width="3"
                                                                                stroke="white"
                                                                                y2="1.5"
                                                                                x2="26.0357"
                                                                                y1="1.5"
                                                                                x1="12"
                                                                                ></line>
                                                                        </svg>
                                                                        <svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none"
                                                                                viewBox="0 0 33 39"
                                                                                class="bin-bottom"
                                                                                >
                                                                                <mask fill="white" id="path-1-inside-1_8_19">
                                                                                <path
                                                                                    d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                                                                                ></path>
                                                                                </mask>
                                                                                <path
                                                                                mask="url(#path-1-inside-1_8_19)"
                                                                                fill="white"
                                                                                d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                                                                                ></path>
                                                                                <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                                                                                <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                                                                        </svg>
                                                                        <svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none"
                                                                                viewBox="0 0 89 80"
                                                                                class="garbage"
                                                                                >
                                                                                <path
                                                                                fill="white"
                                                                                d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z"
                                                                                ></path>
                                                                        </svg>
                                                            </a>
                                                        @endif
                                                    </div>
                                                    
    
    
                                                    <div class="">
                                                        @if ($prestamoingreso->estado   == 'ANULADO')
                                                            <p class="text-red">ANULADO</p>
                                                        @endif
                                                    </div>
                                                    
    
                                                    
    
    
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
                        </div>
                        
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item {{ $prestamoingresos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $prestamoingresos->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $prestamoingresos->lastPage(); $i++)
                                    <li class="page-item {{ $prestamoingresos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $prestamoingresos->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $prestamoingresos->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $prestamoingresos->nextPageUrl() }}">
                                        {{ __('Siguiente') }}
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@include('inventariopringresos.modal.create')

@foreach($prestamoingresos as $prestamoingreso)
        @include('inventariopringresos.modal.show', ['id' => $prestamoingreso->id])    
        @include('inventariopringresos.modal.entregar', ['id' => $prestamoingreso->id])    
@endforeach


@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/updateadvice.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="{{asset('js/jquery.printPage.js')}}"></script>
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
    <script>
            $(document).on('click', '.anular', function(e){
                e.preventDefault();
                const url = $(this).attr('href');
                
                Swal.fire({
                    title: '¿Está seguro que quiere anular ingreso como prestamo?',
                    text: 'Estos cambios no son reversibles',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '¡Sí, continuar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
    </script>
@stop
