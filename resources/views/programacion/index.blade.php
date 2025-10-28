@extends('admin.layout')

@section('content')
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('TODAS LAS PROGRAMACIONES REGISTRADAS') }}
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-sm btn-special" href="{{ route('programacion.create') }}">
                                {{ __('CREAR NUEVA PROGRAMACIÓN') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            @if (count($programaciones) > 0)
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('FECHA INICIO PROGRAMACIÓN') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('FECHA FIN PROGRAMACIÓN') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('FECHA INICIO EJECUCIÓN') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('FECHA FIN EJECUCIÓN') }}
                                        </th>


                                        <th class="text-center">
                                            {{ __('ACCIÓN') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programaciones as $programacion)
                                        <tr>
                                            <td scope="row">
                                                {{ $programacion->id }}
                                            </td>
                                            <td scope="row">
                                                {{ $programacion->programacion_inicio }}
                                            </td>
                                            <td scope="row">
                                                {{ $programacion->programacion_fin }}
                                            </td>
                                            <td scope="row">
                                                {{ $programacion->ejecucion_inicio }}
                                            </td>
                                            <td scope="row">
                                                {{ $programacion->ejecucion_finalizada }}
                                            </td>


                                            <td>
                                                @if ($programacion->estado != 'finalizada')
                                                    <a href="{{ route('programacion.start', $programacion->id) }}"
                                                        class="btn btn-secondary btn-sm">
                                                        {{ __('INICIAR') }}
                                                    </a>
                                                    <a href="{{ route('programacion.finalizar', $programacion->id) }}"
                                                        class="btn btn-secondary btn-sm">
                                                        {{ __('FINALIZAR') }}
                                                    </a>
                                                    <a href="{{ route('programacion.show', $programacion->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        {{ __('VER') }}
                                                    </a>
                                                    <form class="eliminar-registro"
                                                        action="{{ route('programacion.destroy', $programacion->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            {{ __('ELIMINAR') }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('programacion.show', $programacion->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        {{ __('VER') }}
                                                    </a>
                                                @endif

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
                                <li class="page-item {{ $programaciones->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $programaciones->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $programaciones->lastPage(); $i++)
                                    <li class="page-item {{ $programaciones->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $programaciones->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $programaciones->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $programaciones->nextPageUrl() }}">
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
            @if (session('eliminar-programacion') == 'Programacion eliminada con éxito.')
                Swal.fire('Programación', 'eliminado exitosamente.', 'success')
            @endif
            @if (session('crear-programacion') == 'Programación creada con éxito.')
                Swal.fire('Programación', 'creada exitosamente.', 'success')
            @endif
            @if (session('editar-programaxion') == 'Programación actualizado con éxito.')
                Swal.fire('Programación', 'actualizado exitosamente.', 'success')
            @endif
        </script>
        <script>
            $('.eliminar-registro').submit(function(e) {
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
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
        </script>
    @endpush
@endsection
