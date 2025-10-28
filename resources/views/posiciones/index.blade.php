@extends('admin.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/areas.css') }}">
@endpush

@section('content')
    <div class="container">

        <br>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="loader">
                {{ __('POSICIONES REGISTRADAS') }}

            </div>
            <div class="text-right col-md-6">
                <a class="" href="#" data-toggle="modal" data-target="#ModalCreate">
                    <button class="button-create">
                        {{ __('CREAR POSICIÓN') }}
                    </button>

                </a>
            </div>

        </div>

        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">


                    <div class="card-body ">

                        <table id="posiciones-table" class="table table-striped  ">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                    <th scope="col">
                                        {{ __('NOMBRE') }}
                                    </th>

                                </tr>
                            </thead>

                            <tbody style="font-size: 13px">
                                @if (count($posiciones) > 0)
                                    @foreach ($posiciones as $posicion)
                                        <tr>
                                            <td scope="row">
                                                {{ $posicion->id }}
                                            </td>

                                            <td scope="row">
                                                {{ $posicion->nombre }}

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
                                {{ $posiciones->links('pagination::bootstrap-4') }}
                            </div>
                            <div>
                                Mostrando del {{ $posiciones->firstItem() }} al {{ $posiciones->lastItem() }} de
                                {{ $posiciones->total() }} registros
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    @include('posiciones.modal.create')


@stop




@section('js')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/updateadvice.js') }}"></script>


    <script>
        @if (session('status'))
            Swal.fire('Éxito', '{{ session('status') }}', 'success');
        @elseif (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>
@stop
