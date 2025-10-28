@extends('admin.layout')
@push('css')
   <link rel="stylesheet" href="{{ asset('css/areas.css') }}">

@endpush


@section('content')
    <div class="container">

        <br>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="loader">
            {{ __('LOTES REGISTRADOS') }}

            </div >    
            <div class="text-right col-md-6">
            <a class="" href="#" data-toggle="modal" data-target="#ModalCreate">
                <button class="button-create">
                    {{ __('REGISTRAR LOTE') }}
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
                                @if (count($lotes) > 0)
                                    @foreach ($lotes as $lote)
                                        <tr>
                                            <td scope="row">
                                                {{ $lote->id }}
                                            </td>

                                            <td scope="row">
                                                {{ $lote->codigo }} 
                                            </td>
                                          
                                            <td scope="row">
                                                {{ $lote->nombre }} 
                                            </td>

                                            <td>
                                                <a class="btn btn-secondary btn-sm" href="#" data-toggle="modal" data-target="#ModalShow{{ $lote->id}}">
                                                    {{ __('VER') }}
                                                </a>
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
                                    {{ $lotes->links('pagination::bootstrap-4') }}
                                </div>
                                <div>
                                    Mostrando del {{ $lotes->firstItem() }} al {{ $lotes->lastItem() }} de {{ $lotes->total() }} registros
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    


    @include('liquidaciones.lotes.modal.create')

    @foreach($lotes as $lote)

        @include('liquidaciones.lotes.modal.show', ['id' => $lote->id])
    @endforeach




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