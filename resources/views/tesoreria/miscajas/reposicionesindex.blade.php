@extends('admin.layout')

@push('css')
   <link rel="stylesheet" href="{{ asset('css/areas.css') }}">
   <link rel="stylesheet" href="{{ asset('css/micaja.css') }}">
    
@endpush

@section('content')
    <div class="container">

        <br>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="greeting col-md-6 d-flex justify-content-start">
                {{ __('REPOSICIONES DE LAS CAJAS REGISTRADAS') }}
            </div>    
            <div class="col-md-6 mt-2 d-flex justify-content-end">
                <a href="{{ url()->previous() }}">
                    <button class="ui-btn">
                        <span>
                            Volver
                        </span>
                    </button>
                </a>
            </div>
        </div>
    
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    
                
                    <div class="card-body ">
                        
                        <table id="reposicionescajas-table" class="table table-striped  ">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        {{ __('ID') }}
                                    </th>
                                 
                                    
                                    <th scope="col">
                                        {{ __('CAJA') }}
                                    </th>

                                    <th scope="col">
                                        {{ __('MOTIVO') }}
                                    </th>
                                    
                                    <th scope="col">
                                        {{ __('MONTO') }}
                                    </th> 
                            
                                </tr>
                            </thead>

                            <tbody style="font-size: 13px">
                                @if (count($reposicionescajas) > 0)
                                    @foreach ($reposicionescajas as $reposicioncaja)
                                        <tr >
                                            <td scope="row">
                                                {{ $reposicioncaja->id }}
                                            </td>
                                          
                                         

                                            <td scope="row">
                                                @if($reposicioncaja->caja)
                                                {{ $reposicioncaja->caja->nombre }}
                                                @endif
                                            </td>

                                            <td scope="row">
                                                @if($reposicioncaja->motivo)
                                                {{ $reposicioncaja->motivo->nombre }}
                                                @endif
                                            </td>
                                            <td scope="row">
                                                {{ $reposicioncaja->monto }}
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
                                    {{ $reposicionescajas->links('pagination::bootstrap-4') }}
                                </div>
                                <div>
                                    Mostrando del {{ $reposicionescajas->firstItem() }} al {{ $reposicionescajas->lastItem() }} de {{ $reposicionescajas->total() }} registros
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    


    

    @stop




@section('js')
    
        <script>
        @if (session('status'))
        Swal.fire('Éxito', '{{ session('status') }}', 'success');

           
        @elseif (session('error'))
        Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
        </script>
@stop