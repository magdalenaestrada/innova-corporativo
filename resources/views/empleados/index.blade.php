@extends('admin.layout')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/areas.css') }}">
@endpush


@section('content')
    <div class="container">

        <br>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="loader">
                {{ __('EMPLEADOS REGISTRADOS') }}

            </div>
            <div class="text-right col-md-6">
                <a class="" href="#" data-toggle="modal" data-target="#ModalCreate">
                    <button class="button-create">
                        {{ __('REGISTRAR EMPLEADO') }}
                    </button>

                </a>
            </div>

        </div>

        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">


                    <div class="card-body ">

                        <table id="products-table" class="table table-striped  ">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('DOCUMENTO') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('NOMBRE') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('ÁREA') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('JEFE') }}
                                    </th>

                                </tr>
                            </thead>

                            <tbody style="font-size: 13px">
                                @if (count($empleados) > 0)
                                    @foreach ($empleados as $empleado)
                                        <tr>
                                            <td scope="row">
                                                {{ $empleado->id }}
                                            </td>

                                            <td scope="row">
                                                {{ strtoupper($empleado->documento) }}
                                            </td>

                                            <td scope="row">
                                                {{ strtoupper($empleado->nombre) }}
                                            </td>

                                            <td scope="row">
                                                @if ($empleado->area)
                                                    {{ strtoupper($empleado->area->nombre) }}
                                                @endif
                                            </td>

                                            <td scope="row">
                                                @if ($empleado->jefe)
                                                    {{ strtoupper($empleado->jefe->nombre) }}
                                                @endif
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
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between">
                            <div>
                                {{ $empleados->links('pagination::bootstrap-4') }}
                            </div>
                            <div>
                                Mostrando del {{ $empleados->firstItem() }} al {{ $empleados->lastItem() }} de
                                {{ $empleados->total() }} registros
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    @include('empleados.modal.create')






    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/updateadvice.js') }}"></script>

        <script>
            @if (session('status'))
                Swal.fire('Éxito', '{{ session('status') }}', 'success');
            @elseif (session('error'))
                Swal.fire('Error', '{{ session('error') }}', 'error');
            @endif
        </script>
    @endpush

@endsection
