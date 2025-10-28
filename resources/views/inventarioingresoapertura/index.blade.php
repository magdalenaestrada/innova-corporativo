@extends('admin.layout')

@section('content')
    <div class="container">

        <br>
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            {{ __('APERTURAS REGISTRADAS') }}
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-sm btn-special" href="#" data-toggle="modal" data-target="#ModalCreate">
                                {{ __('CREAR APERTURA') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col">
                                            {{ __('PRODUCTO') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('STOCK INICIAL') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('CREACIÓN') }}
                                        </th>



                                    </tr>
                                </thead>

                                <tbody style="font-size: 13px">
                                    @if (count($inventarioingresosapertura) > 0)
                                        @foreach ($inventarioingresosapertura as $apertura)
                                            <tr>
                                                <td scope="row">
                                                    {{ $apertura->id }}
                                                </td>
                                                <td scope="row">
                                                    {{ $apertura->producto->nombre_producto }}
                                                </td>


                                               
                                                <td scope="row">
                                                    {{ $apertura->stock }}
                                                </td>

                                                <td scope="row" class="text-center">
                                                    {{ $apertura->created_at }}

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

                        <!-- Pagination -->

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end flex-wrap">
                                <!-- Previous Page Link -->
                                <li class="page-item {{ $inventarioingresosapertura->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $inventarioingresosapertura->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">{{ __('Anterior') }}</span>
                                    </a>
                                </li>

                                <!-- First Page Link -->
                                <li
                                    class="page-item {{ $inventarioingresosapertura->currentPage() == 1 ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $inventarioingresosapertura->url(1) }}">1</a>
                                </li>

                                <!-- Second Page Link -->
                                @if ($inventarioingresosapertura->lastPage() > 1)
                                    <li
                                        class="page-item {{ $inventarioingresosapertura->currentPage() == 2 ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $inventarioingresosapertura->url(2) }}">2</a>
                                    </li>
                                @endif

                                <!-- Ellipsis and Middle Pages -->
                                @if ($inventarioingresosapertura->lastPage() > 3)
                                    @if ($inventarioingresosapertura->currentPage() > 3)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    @if (
                                        $inventarioingresosapertura->currentPage() > 2 &&
                                            $inventarioingresosapertura->currentPage() < $inventarioingresosapertura->lastPage() - 1)
                                        <li class="page-item active">
                                            <a class="page-link"
                                                href="{{ $inventarioingresosapertura->url($inventarioingresosapertura->currentPage()) }}">{{ $inventarioingresosapertura->currentPage() }}</a>
                                        </li>
                                    @endif

                                    @if ($inventarioingresosapertura->currentPage() < $inventarioingresosapertura->lastPage() - 2)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                <!-- Last Two Pages Links -->
                                @if ($inventarioingresosapertura->lastPage() > 2)
                                    <li
                                        class="page-item {{ $inventarioingresosapertura->currentPage() == $inventarioingresosapertura->lastPage() - 1 ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $inventarioingresosapertura->url($inventarioingresosapertura->lastPage() - 1) }}">{{ $inventarioingresosapertura->lastPage() - 1 }}</a>
                                    </li>
                                    <li
                                        class="page-item {{ $inventarioingresosapertura->currentPage() == $inventarioingresosapertura->lastPage() ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $inventarioingresosapertura->url($inventarioingresosapertura->lastPage()) }}">{{ $inventarioingresosapertura->lastPage() }}</a>
                                    </li>
                                @endif

                                <!-- Next Page Link -->
                                <li class="page-item {{ $inventarioingresosapertura->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $inventarioingresosapertura->nextPageUrl() }}"
                                        aria-label="Next">
                                        <span aria-hidden="true">{{ __('Siguiente') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>


            </div>
        </div>
    </div>
    @include('inventarioingresoapertura.modal.create')

    @stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/updateadvice.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        

    <script>
        @if (session('status'))
            Swal.fire('Éxito', '{{ session('status') }}', 'success');
        @elseif (session('error'))
                Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>
    
@endsection

