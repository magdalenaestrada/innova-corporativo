@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('VER PAGO DE TICKETS DE COMEDOR') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-danger btn-sm" href="{{ route('abonados.index') }}">
                                    {{ __('VOLVER') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="form-group col-md-3 g-3">
                                <label for="fecha_cancelacion">
                                    {{ __('FECHA DE PAGO') }}
                                </label>
                                <input class="form-control" value="{{ $abonado->fecha_cancelacion }}" disabled>
                            </div>


                            @php
                                foreach ($abonado->ranchos as $rancho) {
                                    $documento_cliente = $rancho->documento_cliente;
                                }
                                $datos_cliente = $rancho->datos_cliente;

                            @endphp
                            
                            <div class="form-group col-md-4 g-3">
                                <label for="datos_cliente">
                                    {{ __('DATOS CLIENTE') }}
                                </label>
                                <input class="form-control" value="{{ $datos_cliente }}" disabled>
                            </div>

                            <div class="mt-1 table-responsive">
                                @if (count($abonado->ranchos) > 0)
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">

                                                <th scope="col">
                                                    {{ __('ID') }}
                                                </th>

                                

                                                <th scope="col">
                                                    {{ __('DOCUMENTO TRABAJADOR') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('DATOS TRABAJADOR') }}
                                                </th>

                                                <th scope="col">
                                                    {{ __('CANTIDAD') }}
                                                </th>

                                                

                                                <th scope="col">
                                                    {{ __('CANCELADO') }}
                                                </th>

                                                <th scope="col">
                                                    {{ __('COMIDA') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('LOTE') }}
                                                </th>
                                              

                                                <th scope="col">
                                                    {{ __('FECHA CREACIÓN') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($abonado->ranchos as $rancho)
                                                <tr class="text-center">
                                                    <td scope="row">
                                                        {{ $rancho->id }}
                                                    </td>


                                       

                                                    <td scope="row">
                                                        @if ($rancho->documento_trabajador)
                                                            {{ $rancho->documento_trabajador }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td scope="row">
                                                        @if ($rancho->datos_trabajador)
                                                            {{ $rancho->datos_trabajador }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td scope="row">
                                                        {{ $rancho->cantidad }}
                                                    </td>
                                                    <td>
                                                        @if($rancho->abonados)
                                                        {{ $rancho->id }}
                                                        @endif
                                                    </td>   

                                                    

                                                    <td scope="row">
                                                        {{ $rancho->cancelado }}
                                                    </td>

                                                    <td scope="row">
                                                        {{ $rancho->comida->nombre }}

                                                    </td>
                                                    
                                                    <td scope="row">
                                                        {{ $rancho->lote }}

                                                    </td>
                                                    
                                                    <td scope="row">
                                                        {{ $rancho->created_at }}

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                @endif


                                <p class="col-md-12 text-end g-3 h3 mt-3">Cantidad: {{ $sum_cantidad_total }}</p>

                            </div>



                            <a href="{{ route('cancelacion.prnpriview', $abonado->id) }}"
                                class="btnprn btn btn-info">IMPRIMIR</a>






                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

    @section('js')
        <script type="text/javascript" src="{{ asset('js/jquery.printPage.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.btnprn').printPage();

            });
        </script>
    @endsection
