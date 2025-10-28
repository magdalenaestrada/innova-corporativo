@extends('admin.layout')

@section('content')
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="col-md-6">
                            {{ __('TODAS LAS OPERACIONES REGISTRADAS') }}
                            </div>
                            <div class="col-md-6 text-right">
                            @can('crear registro')
                                    <a class="btn btn-sm btn-special" href="{{ route('registros.create') }}">
                                    {{ __('CREAR NUEVO REGISTRO') }}
                                </a>
                            @endcan
                            </div>
                        
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            @if (count($registros) > 0)
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Operación') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Fecha y hora de registro') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Tipo de Vehículo') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Placa') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Documento cliente') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('Nombre o Razón Social Cliente') }}
                                    </th>
                    
                                    <th>
                                        {{ __('Acción') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registros as $registro)
                                    <tr>
                                        <td scope="row">
                                            {{ $registro->id }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->accion->nombre_accion }}
                                        </td>
                                        <td scope="row">
                                            {{ ($registro->created_at)->format('d/m/Y - H:i:s') }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->tipoVehiculo->nombre_vehiculo }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->placa }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->documento_cliente }}
                                        </td>
                                        <td scope="row">
                                            {{ $registro->datos_cliente }}
                                        </td>
                                        
                                        <td>
                                            @can('ver registro')
                                            <a href="{{ route('registros.show', $registro->id) }}" class="btn btn-secondary btn-sm">
                                                {{ __('VER') }}
                                            </a>
                                            @endcan
                                            @can('editar registro')
                                            <a href="{{ route('registros.edit', $registro->id) }}" class="btn btn-warning btn-sm">
                                                {{ __('EDITAR') }}
                                            </a>
                                            @endcan
                                            @can('eliminar registro')
                                            <form class="eliminar-registro" action="{{ route('registros.destroy', $registro->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    {{ __('ELIMINAR') }}
                                                </button>
                                            </form>
                                            @endcan
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
                                <li class="page-item {{ $registros->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $registros->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $registros->lastPage(); $i++)
                                    <li class="page-item {{ $registros->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $registros->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $registros->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $registros->nextPageUrl() }}">
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
    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/updateadvice.js') }}"></script>

        <script>
            @if(session('eliminar-registro') == 'Registro eliminado con éxito.')
                Swal.fire('Registro', 'eliminado exitosamente.', 'success')
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
    @endpush
@endsection