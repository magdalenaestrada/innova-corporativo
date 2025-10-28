@extends('admin.layout')
@section('content')
    <div class="container">

        <br>


        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{ __('PROVEEDORES REGISTRADOS') }}

                    </div>



                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="products-table" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('RUC') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('RAZON SOCIAL') }}
                                        </th>





                                        <th scope="col">
                                            {{ __('DIRECCIÓN') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('TELÉFONO') }}
                                        </th>


                                    </tr>
                                </thead>

                                <tbody style="font-size:13px">
                                    @if (count($proveedores) > 0)
                                        @foreach ($proveedores as $proveedor)
                                            <tr>
                                                <td scope="row">
                                                    {{ $proveedor->id }}
                                                </td>





                                                <td scope="row">
                                                    {{ $proveedor->ruc }}
                                                </td>








                                                <td scope="row">
                                                    {{ $proveedor->razon_social }}
                                                </td>

                                                <td scope="row">
                                                    {{ $proveedor->direccion }}
                                                </td>


                                                <td scope="row">
                                                    {{ $proveedor->telefono }}
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



                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item {{ $proveedores->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $proveedores->previousPageUrl() }}">
                                        {{ __('Anterior') }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $proveedores->lastPage(); $i++)
                                    <li class="page-item {{ $proveedores->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $proveedores->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $proveedores->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $proveedores->nextPageUrl() }}">
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
            @if (session('eliminar-proveedor') == 'proveedor eliminado con éxito.')
                Swal.fire('proveedor', 'eliminado exitosamente.', 'success');
            @elseif (session('crear-proveedor') == 'proveedor creado con éxito.')
                Swal.fire('proveedor', 'creado exitosamente.', 'success');
            @elseif (session('actualizar-proveedor') == 'proveedor actulaizado con éxito.')
                Swal.fire('proveedor', 'añadido a familia existosamente.', 'success');
            @elseif (session('error'))
                Swal.fire('Error', '{{ session('error') }}', 'error');
            @endif
        </script>
        <script>
            $('.eliminar-proveedor').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar proveedor?',
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







        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }


            });
        </script>
    @endpush
@endsection
