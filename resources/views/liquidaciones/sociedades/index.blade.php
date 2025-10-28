@extends('admin.layout')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/areas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
    <div class="container">

        <br>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="loader">
                {{ __('SOCIEDADES REGISTRADAS') }}
            </div>
            <div class="text-right col-md-6">
                <a class="" href="#" data-toggle="modal" data-target="#ModalCreate">
                    <button class="button-create">
                        {{ __('CREAR SOCIEDAD') }}
                    </button>
                </a>
            </div>

        </div>

        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="searcht" id="searcht" class="input-search form-control"
                                placeholder="BUSCAR AQUÍ...">
                        </div>
                    </div>

                    <div class="card-body ">

                        <table id="sociedades-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('CÓDIGO') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('NOMBRE') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('ACCIÓN') }}
                                    </th>

                                </tr>
                            </thead>

                            <tbody style="font-size: 13px">
                                @if (count($sociedades) > 0)
                                    @foreach ($sociedades as $sociedad)
                                        <tr>

                                            <td scope="row">
                                                {{ strtoupper($sociedad->codigo) }}
                                            </td>

                                            <td scope="row">
                                                {{ strtoupper($sociedad->nombre) }}
                                            </td>

                                            <td class="btn-group align-items-center">
                                                <div class="align-items-center">
                                                    <a class="btn btn-sm btn-secondary" href="#" data-toggle="modal"
                                                        data-target="#ModalShow{{ $sociedad->id }}">
                                                        {{ __('VER') }}
                                                    </a>
                                                </div>


                                                <a href="#" data-toggle="modal"
                                                    data-target="#ModalEdit{{ $sociedad->id }}" class="ml-1">

                                                    <button class="editBtn" style=" margin-top:-3px">
                                                        <svg height="1em" viewBox="0 0 512 512">
                                                            <path
                                                                d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </a>

                                                @include('liquidaciones.sociedades.modal.edit', [
                                                    'id' => $sociedad->id,
                                                ])



                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            {{ __('NO HAY DATOS DISPONIBLES') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-between">
                            <div>
                                {{ $sociedades->links('pagination::bootstrap-4') }}
                            </div>
                            <div>
                                {{ __('MOSTRANDO DEL') }} {{ $sociedades->firstItem() }} {{ __('AL') }}
                                {{ $sociedades->lastItem() }} {{ __('DE') }} {{ $sociedades->total() }}
                                {{ __('REGISTROS') }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('liquidaciones.sociedades.modal.create')

    @foreach ($sociedades as $sociedad)
        @include('liquidaciones.sociedades.modal.show', ['id' => $sociedad->id])
    @endforeach

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/updateadvice.js') }}"></script>

    <script>
        @if (session('status'))
            Swal.fire('ÉXITO', '{{ session('status') }}', 'success');
        @elseif (session('error'))
            Swal.fire('ERROR', '{{ session('error') }}', 'error');
        @endif
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#searcht').on('input', function(e) {
                e.preventDefault();
                let search_string = $(this).val();
                $.ajax({
                    url: "{{ route('search.lqsociedades') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {
                        $('#sociedades-table tbody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });
        });
    </script>
@endsection

@endsection
