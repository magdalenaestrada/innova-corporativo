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
                                    {{ __('ORDEN DE COMPRA') }}
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













                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion">
                                    {{ __('DESCRIPCIÓN') }}
                                </label>
                                <textarea class="form-control" disabled>{{ $inventarioingreso->descripcion ? $producto->descripcion : 'No hay observación' }}</textarea>
                            </div>

                            <form action="{{ route('inventarioingresos.updaterecepcionar', $inventarioingreso->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mt-2">
                                    @if (count($inventarioingreso->productos) > 0)
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col">
                                                        {{ __('SELECCIONAR') }}
                                                    </th>
                                                    <th>
                                                        {{ __('INGRESAR CANTIDAD RECIBIDA') }}
                                                    </th>


                                                    <th scope="col">
                                                        {{ __('PRODUCTO DEL REQUERIMIENTO') }}
                                                    </th>
                                                    <th scope="col">
                                                        {{ __('CANTIDAD') }}
                                                    </th>

                                                    <th scope="col">
                                                        {{ __('CANTIDAD RECIBIDA') }}
                                                    </th>

                                                    <th scope="col">
                                                        {{ __('CANTIDAD POR RECIBIR') }}
                                                    </th>

                                                    <th scope="col">
                                                        {{ __('FECHA DE CREACIÓN') }}
                                                    </th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($inventarioingreso->productos as $producto)
                                                    <tr class="text-center">
                                                        @php
                                                            $cantidad_por_recibir = $producto->pivot->cantidad - $producto->pivot->cantidad_ingresada
                                                        @endphp
                                                        
                                                        <td>
                                                        @if($cantidad_por_recibir != 0)
                                                            <input type="checkbox" name="selected_products[]"
                                                                value="{{ $producto->id }}" class="product-checkbox">
                                                        @else
                                                            COMPLETO
                                                        @endif
                                                        </td>
                                                        <td>
                                                            <div class="input-fields" style="display: none;">
                                                                <input type="number" step="0.01"
                                                                    name="qty_arrived[{{ $producto->id }}]"
                                                                    class="additional-info form-control input-sm"
                                                                    style="width: 50%">
                                                            </div>
                                                        </td>
                                                        <td scope="row">
                                                            {{ $producto->nombre_producto }}
                                                        </td>
                                                        <td scope="row">
                                                            {{ $producto->pivot->cantidad }}
                                                        </td>

                                                        <td>
                                                        {{ $producto->pivot->cantidad_ingresada }}
                                                        </td>

                                                        <td>
                                                            
                                                            {{ $cantidad_por_recibir }}
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

                                <div class="form-group col-md-3 g-3">
                                    <label for="guiaingresoalmacen">
                                        {{ __('GUIA DE INGRESO AL ALMACEN') }}
                                    </label>
                                    <input class="form-control" type="text" name="guiaingresoalmacen">
                                </div>



                                <div class="col-md-12 text-end g-3 m-3">
                                    <button type="submit" class="btn btn-warning  m-3">
                                        {{ __('CONFIRMAR INGRESO DE LOS PRODUCTOS AL ALMACEN') }}
                                    </button>
                                </div>


                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var checkboxes = document.querySelectorAll('.product-checkbox');

                checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        var inputFields = this.parentNode.parentNode.querySelector('.input-fields');


                        if (this.checked) {
                            inputFields.style.display = 'block';
                        } else {
                            inputFields.style.display = 'none';
                            inputFields.querySelector('input').value = '';
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
