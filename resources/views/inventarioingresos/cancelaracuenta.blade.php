@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('CANCELAR ORDEN DE COMPRA A CUENTA') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-danger btn-sm" href="{{ route('inventarioingresos.index') }}">
                                    {{ __('VOLVER') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>
                                        {{ __('Estás viendo el ID') }}
                                    </strong>
                                    <span class="badge text-bg-secondary">{{ $inventarioingreso->id }}</span>
                                    <strong>
                                        {{ __('y esta operación fue registrada el ') }}
                                    </strong>
                                    {{ $inventarioingreso->created_at->format('d-m-Y') }}
                                    <strong>
                                        {{ __('a la(s) ') }}
                                    </strong>
                                    {{ $inventarioingreso->created_at->format('H:i:s') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>

                            </div>



                            <div class="form-group col-md-3 g-3">
                                <label for="inventarioingreso_fin">
                                    {{ __('FECHA DE CREACIÓN') }}
                                </label>
                                <input class="form-control" value="{{ $inventarioingreso->created_at }}" disabled>
                            </div>

                            <div class="form-group col-md-3 g-3">
                                <label for="inventarioingreso_fin">
                                    {{ __('CREADOR DE LA ORDEN') }}
                                </label>
                                <input class="form-control" value="{{ $inventarioingreso->usuario_ordencompra }}" disabled>
                            </div>


                            <div class="form-group col-md-3 g-3">
                                <label for="inventarioingreso_fin">
                                    {{ __('ESTADO DE LA ORDEN') }}
                                </label>
                                <input class="form-control" value="{{ $inventarioingreso->estado }}" disabled>
                            </div>



                            <div class="row mb-3">

                                <div class="form-group col-md-4 g-3">
                                    <label for="documento_proveedor">
                                        {{ __('RUC PROVEEDOR') }}
                                    </label>
                                    <div class="input-group">
                                        <input class="form-control" value="{{ $inventarioingreso->proveedor->ruc }}"
                                            disabled>
                                        <button class="btn btn-secondary" type="button" id="buscar_proveedor_btn" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 25 25"
                                                style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                                <path
                                                    d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group col-md-8 g-3">
                                    <label for="datos_proveedor">
                                        {{ __('RAZÓN SOCIAL PROVEEDOR') }}
                                    </label>
                                    <input class="form-control" value="{{ $inventarioingreso->proveedor->razon_social }}" disabled>
                                </div>

                            </div>









                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion">
                                    {{ __('DESCRIPCIÓN') }}
                                </label>
                                <textarea class="form-control" disabled>{{ $inventarioingreso->descripcion ? $inventarioingreso->descripcion : 'No hay observación' }}</textarea>
                            </div>




                           




                            <div class="mt-2">
                                @if (count($inventarioingreso->productos) > 0)
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">

                                                <th scope="col">
                                                    {{ __('PRODUCTO DEL REQUERIMIENTO') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('CANTIDAD') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('PRECIO') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('SUBTOTAL') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('FECHA DE CREACIÓN') }}
                                                </th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventarioingreso->productos as $producto)
                                                <tr class="text-center">
                                                    <td scope="row">
                                                        {{ $producto->nombre_producto }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->cantidad }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->precio }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->subtotal }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->created_at }}
                                                    </td>







                                                </tr>
                                            @endforeach
                                        </tbody>



                                    </table>
                                @endif
                            </div>



                            <p class="text-center h5"> SUBTOTAL: {{ $inventarioingreso->subtotal }}</p>
                            <p class="text-center h4"> COSTO TOTAL: {{ $inventarioingreso->total }}</p>


                            <div class="form-group col-md-3 g-3">
                                            <label for="inventarioingreso_fin">
                                                {{ __('TIPO DE MONEDA PARA EL PAGO') }}
                                            </label>
                                            <input class="form-control" value="{{ $inventarioingreso->tipomoneda }}" disabled>
                            </div>


                            <form action="{{ route('inventarioingresos.updatecancelaracuenta', $inventarioingreso->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-between   mt-5" id="taskFormContainer">



                                    <div class="col-md-3 text-center">
                                        {{ __('FECHA DE PAGO O ADELANTO') }}
                                    </div>
                                    
                                    <div class="col-md-3 ">
                                        {{ __('MONTO') }}
                                    </div>

                                    <div class="col-md-3 ">
                                        {{ __('COMPROBANTE CORRELATIVO') }}
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <button class="btn  btn-primary pull-right" type="button" id="addMoreButton">AÑADIR PAGO O ADELANTO</button>
                                    </div>
            
            
                                </div>

                                <div class="pago-box-extra" id="itemsInOrder"></div>




                                <div class="pago-box hidden">
                                    <div class="row pago-item justify-content-between m-4">
            
                                        <div class="col-md-3 text-center">
                                            <input name="fechas_pagos[]" type="date" class="form-control pago-fecha" 
           value="{{ old('fechas_pagos.0', $today) }}" >

                                        </div>
                                        
                                        <div class="col-md-3 text-center">
                                            <input name="montos[]" type="number" step="0.01" value="0" placeholder=""
                                                class="form-control pago-monto"  style="max-width: 100px">
                                        </div>

                                        <div class="col-md-3 text-center">
                                            <input name="comprobantes[]" type="text"  value="0" placeholder=""
                                                class="form-control pago-comprobante" style="max-width: 150px">
                                        </div>
                                        
            
                                        <div class="text-end text-center col-md-2">
                                            <button class="btn btn btn-danger pull-right remove-row" type="button">Quitar</button>
                                        </div>
                                    </div>
                                </div>




                                <div class="mt-2">
                                    @if (count($inventarioingreso->pagosacuenta) > 0)
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr class="text-center">
    
                                                    <th scope="col">
                                                        {{ __('FECHA DE PAGO O ADELANTO A CUENTA') }}
                                                    </th>
                                                    <th scope="col">
                                                        {{ __('MONTO') }}
                                                    </th>
                                                    <th scope="col">
                                                        {{ __('COMPROBANTE CORRELATIVO') }}
                                                    </th>
                                                   
    
    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($inventarioingreso->pagosacuenta as $pago)
                                                    <tr class="text-center">
                                                        <td scope="row">
                                                            {{ $pago->fecha_pago }}
                                                        </td>
                                                        <td scope="row">
                                                            {{ $pago->monto }}
                                                        </td>
                                                        <td scope="row">
                                                            {{ $pago->comprobante_correlativo }}
                                                        </td>
                                                        
    
    
    
    
    
    
                                                    </tr>
                                                @endforeach
                                            </tbody>
    
    
    
                                        </table>
                                    @endif
    
    
    




                                <div class="col-md-12 text-end g-3 m-3">
                                    <button type="submit" class="btn btn-info  m-3">
                                        {{ __('CANCELAR ORDEN DE COMPRA A CUENTA') }}
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    @push('js')
        <script src="http://localhost/innova-app/public/js/packages/jquery.min.js"></script>
        <script>
            $("#addMoreButton").click(function() {
                var row = $(".pago-box").html();
                $(".pago-box-extra").append(row);
                $(".pago-box-extra .remove-row").last().removeClass('hideit');
                
                
            });

            $(document).on("click", ".remove-row", function() {
                $(this).closest('.row').remove();
                
            });




            

           

           
        </script>
    @endpush
@endsection
