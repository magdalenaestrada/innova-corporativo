@extends('admin.layout')

@section('css')

@stop

@section('content')
    <div class="container">

        <br>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('FAMILIAS REGISTRADAS') }}
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-sm btn-secondary" href="#" data-toggle="modal" data-target="#ModalCreate">
                                {{ __('CREAR FAMILIA') }}
                            </a>
                        </div>

                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('NOMBRE') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('DESCRIPCION') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('FAMILIA PADRE') }}
                                    </th>






                                    <th scope="col">
                                        {{ __('ACCIÓN') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($productosfamilias) > 0)
                                    @foreach ($productosfamilias as $familia)
                                        <tr>
                                            <td scope="row">
                                                {{ $familia->id }}
                                            </td>
                                            <td scope="row">
                                                {{ $familia->nombre }}
                                            </td>

                                            <td scope="row">
                                                @if ($familia->descripcion)
                                                    {{ $familia->descripcion }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td scope="row">
                                                @if ($familia->parent)
                                                    {{ $familia->parent->nombre }}
                                                @else
                                                    -
                                                @endif

                                            </td>





                                            <td>
                                                <a class="btn btn-secondary btn-sm"
                                                    href="{{ route('productosfamilias.edit', $familia->id) }}">
                                                    {{ __('AÑADIR A FAMILIA') }}
                                                </a>


                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            {{ __('No hay datos disponibles') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example" class="navigation">
                            <ul class="pagination justify-content-end">
                                <li class="page-item {{ $productosfamilias->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $productosfamilias->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $productosfamilias->lastPage(); $i++)
                                    <li class="page-item {{ $productosfamilias->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $productosfamilias->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $productosfamilias->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $productosfamilias->nextPageUrl() }}">
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

    @include('productosfamilias.modal.create')

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ asset('js/updateadvice.js') }}"></script>

        <script>
            @if (session('eliminar-familia') == 'Familia eliminada con éxito.')
                Swal.fire('Familia', 'eliminada exitosamente.', 'success');
            @elseif (session('crear-familia') == 'Familia creada con éxito.')
                Swal.fire('Familia', 'creada exitosamente.', 'success');
            @elseif (session('editar-familia') == 'Familia actualizada con éxito.')
                Swal.fire('Familia', 'actualizada exitosamente.', 'success');
            @elseif (session('error'))
                Swal.fire('Error', '{{ session('error') }}', 'error');
            @endif
        </script>
        <script>
            $('.eliminar-familia').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar producto?',
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
