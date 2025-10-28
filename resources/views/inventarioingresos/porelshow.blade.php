@extends('admin.layout')

@section('content')
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('ORDEN DE COMPRA') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-danger btn-sm" href="{{ route('inventarioingresos.index') }}">
                                    {{ __('VOLVER') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
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
                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button> -->
                        </div>





                            
                        <div class="form-group">
                                

                            <div class="row">
                                <div class="form-group col-md-3 g-3">
                                    <label for="inventarioingreso_fin">
                                        {{ __('FECHA DE CREACIÓN') }}
                                    </label>
                                    <input class="form-control" value="{{ $inventarioingreso->created_at }}" disabled>
                                </div>

                                <div class="form-group col-md-3 g-3">
                                    <label for="inventarioingreso_fin">
                                        {{ __('ESTADO DE LA ORDEN') }}
                                    </label>
                                    <input class="form-control" value="{{ $inventarioingreso->estado }}" disabled>
                                </div>

                                <div class="form-group col-md-3 g-3">
                                    <label for="inventarioingreso_fin">
                                        {{ __('CREADOR DE LA ORDEN') }}
                                    </label>
                                    <input class="form-control" value="{{ $inventarioingreso->usuario_ordencompra }}" disabled>
                                </div>

                                <div class="form-group col-md-3 g-3">
                                    <label for="inventarioingreso_fin">
                                        {{ __('ORDEN PAGADA POR') }}
                                    </label>
                                    <input class="form-control" value="{{ $inventarioingreso->usuario_cancelacion }}" disabled>
                                </div>

                                <div class="form-group col-md-3 g-3">
                                    <label for="inventarioingreso_fin">
                                        {{ __('ORDEN RECEPCIONADA POR') }}
                                    </label>
                                    <input class="form-control" value="{{ $inventarioingreso->usuario_recepcionista }}"
                                        disabled>
                                </div>
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
                                <div class="form-group col-md-4 g-3">
                                    <label for="datos_proveedor">
                                        {{ __('TELÉFONO PROVEEDOR') }}
                                    </label>
                                    <input class="form-control" value="{{ $inventarioingreso->proveedor->telefono }}" disabled>
                                </div>
                                <div class="form-group col-md-4 g-3">
                                    <label for="datos_proveedor">
                                        {{ __('DIRECCIÓN') }}
                                    </label>
                                    <input class="form-control" value="{{ $inventarioingreso->proveedor->direccion }}" disabled>
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
                                                    {{ __('PRECIO UNITARIO') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('SUBTOTAL') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('FECHA DE CREACIÓN') }}
                                                </th>


                                                <th scope="col">
                                                    {{ __('GUIA DE INGRESO AL ALMACEN') }}
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

                                                    <td scope="row">
                                                        {{ $producto->pivot->guiaingresoalmacen }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>



                                    </table>
                                @endif
                            </div>

                            <p class="text-center h5"> SUBTOTAL: {{ number_format($inventarioingreso->subtotal,2) }} {{ $inventarioingreso->tipomoneda }}</p>
                            <p class="text-center h4"> COSTO TOTAL: {{ number_format($inventarioingreso->total,2) }} {{ $inventarioingreso->tipomoneda }}</p>
                            


                            <div class="row">
                            <div class="form-group col-md-3 g-3">
                                            <label for="estado_pago">
                                                {{ __('ESTADO PAGO') }}
                                            </label>
                                            <input class="form-control" type="text" value="{{ $inventarioingreso->estado_pago }}" disabled>
                            </div>
                            <div class="form-group col-md-3 g-3">
                                            <label for="tipomoneda">
                                                {{ __('TIPO MONEDA') }}
                                            </label>
                                            <input class="form-control" type="text" value="{{ $inventarioingreso->tipomoneda }}" disabled>
                            </div>

                            </div>

                           


                            <div class="row">

                                <div class="form-group col-md-3 g-3">
                                    <label for="fecha_cancelacion">
                                        {{ __('FECHA DE CACELACION') }}
                                    </label>
                                    <input class="form-control" value="{{ $inventarioingreso->fecha_cancelacion }}" disabled>
                                </div>
                                                    
                                    <div class="row">
                                

                                    <div class="form-group col-md-3 g-3">
                                        <label for="tipocomprobante">
                                            {{ __('TIPO COMPROBANTE') }}
                                        </label>
                                        <input class="form-control" value="{{ $inventarioingreso->tipocomprobante }}" disabled>
                                    </div>

                                                                        

                                        <div class="form-group col-md-4 g-3">
                                            <label for="comprobante_correlativo">
                                                {{ __('COMPROBANTE CORRELATIVO') }}
                                            </label>
                                            <input class="form-control" type="text" value="{{ $inventarioingreso->comprobante_correlativo }}" disabled>
                                        </div>


                                        <div class="form-group col-md-4 g-3">
                                            <label for="tipopago">
                                                {{ __('TIPO PAGO') }}
                                            </label>
                                            <input class="form-control" type="text" value="{{ $inventarioingreso->tipopago }}" disabled>
                                        </div>


                                        
                                       

                                        <div class="form-group col-md-3 g-3">
                                            <label for="fecha_emision_comprobante">
                                                {{ __('FECHA DE EMISIÓN COMPROBANTE') }}
                                            </label>
                                            <input class="form-control" type="text" value="{{ $inventarioingreso->fecha_emision_comprobante }}" disabled>
                                        </div>


                                        @if($inventarioingreso->tipomoneda == 'DOLARES')
                                        <div class="form-group col-md-3 g-3">
                                            <label for="cambio_dia">
                                                {{ __('CAMBIO DEL DÍA') }}
                                            </label>
                                            <input class="form-control" type="text" value="{{ $inventarioingreso->cambio_dolar_precio_venta }}" disabled>
                                        </div>
                                        @endif


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
                                    </div>
                                
                            </div>




                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
