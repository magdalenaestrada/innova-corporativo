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
                                    {{ __('REQUERIMIENTO') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-danger btn-sm" href="{{ route('inventariosalidas.index') }}">
                                    <i class="fa-solid fa-x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <form action="{{ route('inventariosalidas.updateentregar', $inventariosalida->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')



                            <div class="form-group col-md-3 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('FECHA DE CREACIÓN') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->created_at }}" disabled>
                            </div>



                            <div class="form-group col-md-3 g-3">
                                <label for="inventariosalida_fin">
                                    {{ __('ESTADO DE LA ORDEN') }}
                                </label>
                                <input class="form-control" value="{{ $inventariosalida->estado }}" disabled>
                            </div>

                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion">
                                    {{ __('DESCRIPCIÓN') }}
                                </label>
                                <textarea class="form-control" disabled>{{ $inventariosalida->descripcion ? $inventariosalida->descripcion : 'No hay observación' }}</textarea>
                            </div>



                            <div class="mt-2">
                                @if (count($inventariosalida->productos) > 0)
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr >


                                                <th scope="col" class="text-center">
                                                    {{ __('SELECCIONAR') }}
                                                </th>

                                                <th>
                                                    {{ __('INGRESAR CANTIDAD ENTREGADA') }}
                                                </th>


                                                <th scope="col" class="text-center">
                                                    {{ __('PRODUCTO DEL REQUERIMIENTO') }}
                                                </th>
                                                <th scope="col" class="text-center">
                                                    {{ __('STOCK') }}
                                                </th>
                                                <th scope="col" class="text-center">
                                                    {{ __('CANTIDAD REQUERIDA') }}
                                                </th>

                                                <th scope="col" class="text-center">
                                                    {{ __('CANTIDAD ENTREGADA') }}
                                                </th>


                                                <th scope="col" class="text-center">
                                                    {{ __('FECHA DE CREACIÓN') }}
                                                </th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $entrega_posible = true;

                                            @endphp
                                            @foreach ($inventariosalida->productos as $producto)
                                                {{-- @php
                                                    if ($producto->stock <= $producto->pivot->cantidad) {
                                                        $entrega_posible = false;
                                                    }

                                                @endphp --}}
                                                <tr class="text-center">

                                                    @php
                                                        $cantidad_por_entregar = $producto->pivot->cantidad - $producto->pivot->cantidad_entregada;
                                                    @endphp

                                                    <td>
                                                        @if ($cantidad_por_entregar >= 0)
                                                            <input type="checkbox" name="selected_products[]"
                                                                value="{{ $producto->id }}" class="product-checkbox">
                                                        @else
                                                            COMPLETO
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="input-fields" style="display: none;">
                                                            <input type="number"  step="0.01"
                                                                name="qty_arrived[{{ $producto->id }}]"
                                                                class="additional-info form-control input-sm"
                                                                style="width: 50%">
                                                        </div>
                                                    </td>

                                                    <td scope="row" >
                                                        {{ $producto->nombre_producto }}
                                                    </td>
                                                    <td scope="row">
                                                        @if($producto->stock)
                                                        {{ $producto->stock }}
                                                        @else
                                                        0
                                                        @endif
                                                    </td>
                                                    <td scope="row">
                                                        {{ $producto->pivot->cantidad }}
                                                    </td>


                                                    <td scope="row">
                                                        {{ $producto->pivot->cantidad_entregada }}
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



                            
                                {{-- @if ($entrega_posible) --}}
                                    <div class="col-md-12 text-end g-3 m-3">
                                        <button type="submit" class="btn btn-warning  m-3">
                                            {{ __('CONFIRMAR SALIDA DE LOS PRODUCTOS AL ALMACEN') }}
                                        </button>
                                    </div>
                                {{-- @else
                                    <div class="col-md-12 text-end text-danger g-3 m-3">

                                        {{ __('NO PUEDES ENTREGAR ESTE REQUERIMIENTO PORQUE NO HAY SUFICIENTE STOCK PARA ESTE REQUERIMIENTO') }}

                                    </div>
                                @endif --}}


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
