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
                                    {{ __('CANCELAR ORDEN DE COMPRA') }}
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


                        <div class="form-group" >




                            <div class="row" style="margin-top:-10px">

                                <div class="form-group col-md-4 g-3">
                                    <label for="inventarioingreso_fin" class="text-sm">
                                        {{ __('FECHA DE CREACIÓN') }}
                                    </label>
                                    <input class="form-control form-control-sm" value="{{ $inventarioingreso->created_at }}"
                                        disabled>
                                </div>

                                <div class="form-group col-md-4 g-3">
                                    <label for="inventarioingreso_fin" class="text-sm">
                                        {{ __('CREADOR DE LA ORDEN') }}
                                    </label>
                                    <input class="form-control form-control-sm"
                                        value="{{ $inventarioingreso->usuario_ordencompra }}" disabled>
                                </div>


                                <div class="form-group col-md-4 g-3">
                                    <label for="inventarioingreso_fin" class="text-sm">
                                        {{ __('ESTADO DE LA ORDEN') }}
                                    </label>
                                    <input class="form-control form-control-sm" value="{{ $inventarioingreso->estado }}"
                                        disabled>
                                </div>
                            </div>




                            @if ($inventarioingreso->proveedor)
                                <div class="row mb-3">

                                    <div class="form-group col-md-4 g-3">
                                        <label for="documento_proveedor" class="text-sm">
                                            {{ __('RUC PROVEEDOR') }}
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm"
                                                value="{{ $inventarioingreso->proveedor->ruc }}" disabled>

                                        </div>
                                    </div>
                                    <div class="form-group col-md-8 g-3">
                                        <label for="datos_proveedor" class="text-sm">
                                            {{ __('RAZÓN SOCIAL PROVEEDOR') }}
                                        </label>
                                        <input class="form-control form-control-sm"
                                            value="{{ $inventarioingreso->proveedor->razon_social }}" disabled>
                                    </div>


                                    <div class="form-group col-md-12 g-3">
                                        <label for="descripcion" class="text-sm">
                                            {{ __('OBSERVACIÓN') }}
                                        </label>
                                        <textarea class="form-control form-control-sm" disabled>{{ $inventarioingreso->descripcion ? $inventarioingreso->descripcion : 'No hay observación' }}</textarea>
                                    </div>


                                </div>
                            @endif






                            <div class="mt-2 table-responsive">
                                @if (count($inventarioingreso->productos) > 0)
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">

                                                <th scope="col">
                                                    {{ __('PRODUCTO') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('FECHA DE CREACIÓN') }}
                                                </th>

                                                <th scope="col">
                                                    {{ __('CANTIDAD') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('VALOR UNITARIO') }}
                                                </th>
                                                <th scope="col">
                                                    {{ __('SUBTOTAL') }}
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
                                                        {{ $producto->pivot->created_at }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->cantidad }}
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->precio }}
                                                    </td>
                                                    <td scope="row" class="text-right">
                                                         {{$producto->pivot->subtotal,2}}
                                                    </td>
                                               







                                                </tr>
                                            @endforeach


                                            <tr class="table-warning">
                                                <td></td>
                                                <td></td>
                                                <td>SUBTOTAL: </td>
                                                <td></td>

                                                <td class="text-end">
                                                    <div class="text-right">
                                                        {{ number_format($inventarioingreso->subtotal, 2) }}</div>
                                                </td>
                                            </tr>
                                        </tbody>



                                    </table>
                                @endif
                            </div>


           
                            <p class="text-center h5"> IMPORTE TOTAL: {{ $inventarioingreso->total }}
                                {{ $inventarioingreso->tipomoneda }}</p>









                            <form action="{{ route('inventarioingresos.updatecancelar', $inventarioingreso->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-md-4 g-3">
                                        <label for="fecha_cancelacion" class="text-sm">
                                            {{ __('FECHA DE CANCELACION') }}
                                        </label>
                                        <input required class="form-control form-control-sm" type="datetime-local"
                                            name="fecha_cancelacion">
                                    </div>












                                    <div class="form-group col-md-4 g-3">
                                        <label for="comprobante_correlativo" class="text-sm">
                                            {{ __('COMPROBANTE CORRELATIVO') }}
                                        </label>
                                        <input class="form-control form-control-sm" required type="text"
                                            name="comprobante_correlativo">
                                    </div>

                                    <div class="form-group col-md-4 g-3">
                                        <label for="tipopago" class="text-sm">
                                            {{ __('TIPO PAGO') }}
                                        </label>

                                        <select required name="tipopago" id="tipopago"
                                            class="form-select form-control form-control-sm @error('tipopago') is-invalid @enderror"
                                            aria-label="">
                                            <option value="">{{ __('-- Seleccione una opción') }}</option>

                                            <option value="CONTADO" {{ old('tipopago') == 'CONTADO' ? 'selected' : '' }}>
                                                CONTADO
                                            </option>
                                            <option value="CREDITO" {{ old('tipopago') == 'CRÉDITO' ? 'selected' : '' }}>
                                                CRÉDITO
                                            </option>
                                            <option value="A CUENTA" {{ old('tipopago') == 'A CUENTA' ? 'selected' : '' }}>
                                                A CUENTA
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 g-3">
                                        <label for="fecha_emision_comprobante" class="text-sm">
                                            {{ __('FECHA DE EMISIÓN COMPROBANTE') }}
                                        </label>
                                        <input class="form-control form-control-sm" required id="fecha_emision_comprobante"
                                            type="date" name="fecha_emision_comprobante">
                                    </div>

                                    @if ($inventarioingreso->tipomoneda == 'DOLARES')
                                        <div class="form-group col-md-4 g-3">
                                            <label for="cambio_dia" class="text-sm ">
                                                {{ __('CAMBIO DEL DÍA') }}
                                            </label>
                                            <input class="form-control form-control-sm" type="text" name="cambio_dia"
                                                id="cambio_dia">
                                        </div>
                                    @endif




                                    <div class="col-md-12 text-right g-3 ">
                                        <button type="submit" class="btn btn-sm btn-info  ">
                                            {{ __('CANCELAR ORDEN DE COMPRA') }}
                                        </button>
                                    </div>

                                </div>
                            </form>






                        </div>

                    </div>
                </div>
            </div>
        </div>
    @stop
    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#fecha_emision_comprobante').change(function() {
                    var selectedDate = $(this).val();

                    $.ajax({
                        url: '{{ route('get_selling_price') }}',
                        type: 'GET',
                        data: {
                            fecha: selectedDate
                        },
                        success: function(response) {
                            $('#cambio_dia').val(response.precio_venta);
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
    @endpush
