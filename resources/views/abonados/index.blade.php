@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                        {{ __('TODOS LOS PAGOS DEL COMEDOR REGISTRADOS') }}
                        </div>
                        <div class="col-md-6 text-right">
                        @can('use pagos tickets comedor')
                            <a class="btn btn-sm btn-special" href="{{ route('abonados.create') }}">
                                {{ __('PAGAR TICKETS DEL COMEDOR') }}
                            </a>
                        @endcan
                        </div>
                           
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" >
                            @if (count($abonados) > 0)
                            <thead>
                                <tr>

                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('FECHA CANCELACIÓN') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('FECHA CREACIÓN') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('CLIENTE') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('USUARIO') }}
                                    </th>
                                    <th>
                                        {{ __('ACCIÓN') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 13px">
                                @foreach ($abonados as $abonado)
                                    <tr>
                                        <td scope="row">
                                            {{ $abonado->id }}
                                        </td>
                                        <td scope="row">
                                            {{ $abonado->fecha_cancelacion }}
                                        </td>
                                        <td scope="row">
                                            {{ $abonado->created_at }}
                                        </td> 
                                        
                                        <td scope="row">
                                            @php
                                            $reg_ranchos= $abonado->ranchos;
                                            $doc = '';
                                            foreach ( $reg_ranchos as $rancho)
                                            {
                                                $doc = $rancho->datos_cliente;
                                            }
                                            @endphp    
                                            {{ $doc }}                                           
                                        </td>
                                        <td scope="row">
                                            {{ $abonado->usuario }}
                                        </td> 
                                        
                                        
                                        <td>                      
                                            <a href="{{ route('abonados.show', $abonado->id) }}" class="btn btn-secondary btn-sm">
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
                                <li class="page-item {{ $abonados->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $abonados->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $abonados->lastPage(); $i++)
                                    <li class="page-item {{ $abonados->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $abonados->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $abonados->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $abonados->nextPageUrl() }}">
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
    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/updateadvice.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
            $('.btnprn').printPage();
            
            });
        </script>

    
        <script>
            @if(session('crear-abonado-cancelar-tickets') == 'Se cancelaron los tickets de comedor exitosamente.')
                Swal.fire('Liquidación de comedor', 'realizada exitosamente.', 'success')
            @endif
            @if(session('crear-registro') == 'Registro creado con éxito.')
                Swal.fire('Registro', 'creado exitosamente.', 'success')
            @endif
            @if(session('editar-registro') == 'Registro actualizado con éxito.')
                Swal.fire('Registro', 'actualizado exitosamente.', 'success')
            @endif
        </script>
        <script>
            $('.eliminar-registro').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar registro?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, continuar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        this.submit();
                    }
                })
            });
        </script>
    @stop
@endsection