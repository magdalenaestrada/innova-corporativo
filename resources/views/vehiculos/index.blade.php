@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ __('TIPO DE VEHÍCULOS REGISTRADOS') }}
                        <a class="btn btn-sm btn-secondary" href="{{ route('vehiculos.create') }}">
                            {{ __('CREAR TIPO DE VEHÍCULO') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            @if (count($vehiculos) > 0)
                            <tbody>
                                @foreach ($vehiculos as $vehiculo)
                                    <tr>
                                        <td scope="row">
                                            {{ $vehiculo->id }}
                                        </td>
                                        <td scope="row">
                                            {{ $vehiculo->nombre_vehiculo }}
                                        </td>
                                        <td scope="row">
                                            @if ($vehiculo->descripcion_vehiculo)
                                                {{ $vehiculo->descripcion_vehiculo }}
                                                @else
                                                {{ __('no hay descripción disponible') }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('vehiculos.show', $vehiculo->id) }}" class="btn btn-secondary btn-sm">
                                                {{ __('VER') }}
                                            </a>
                                            <a href="{{ route('vehiculos.edit', $vehiculo->id) }}" class="btn btn-warning btn-sm">
                                                {{ __('EDITAR') }}
                                            </a>
                                            <form class="eliminar-vehiculo" action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    {{ __('ELIMINAR') }}
                                                </button>
                                            </form>
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
                                <li class="page-item {{ $vehiculos->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $vehiculos->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $vehiculos->lastPage(); $i++)
                                    <li class="page-item {{ $vehiculos->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $vehiculos->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $vehiculos->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $vehiculos->nextPageUrl() }}">
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
        <script>
            @if(session('eliminar-vehiculo') == 'Tipo de vehículo creado con éxito.')
                Swal.fire('Tipo de vehículo', 'eliminado exitosamente.', 'success')
            @endif
            @if(session('crear-vehiculo') == 'Tipo de vehículo creado con éxito.')
                Swal.fire('Tipo de vehículo', 'creado exitosamente.', 'success')
            @endif
            @if(session('editar-vehiculo') == 'Tipo de vehículo creado con éxito.')
                Swal.fire('Tipo de vehículo', 'actualizado exitosamente.', 'success')
            @endif
        </script>
        <script>
            $('.eliminar-vehiculo').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar tipo de vehículo?',
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