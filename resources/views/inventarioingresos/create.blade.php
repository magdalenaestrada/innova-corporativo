@extends('admin.layout')

@section('content')
    <div class="container">

        <br>

        <div class="card">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CREAR ORDEN DE COMPRA') }}
                        </h6>
                    </div>


                    <div class="col-md-6 text-right">
                        <a class="btn btn-danger btn-sm" href="{{ route('inventarioingresos.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>

            </div>

            <div class="card-body table-responsive">
                <form method="POST" action="{{ route('inventarioingresos.store') }}">
                    @csrf

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th class="text-sm">
                                    {{ __('CAJAS') }}
                                </th>

                                <th class="text-sm">
                                    {{ __('UNIDADES X CAJA') }}
                                </th>

                                <th class="text-sm">
                                    {{ __('VALOR X CAJA') }}
                                </th>

                                <th class="text-sm">
                                    {{ __('PRODUCTO') }}
                                </th>

                                <th class="text-sm">
                                    {{ __('VALOR UNITARIO') }}
                                </th>
                                <th class="text-sm">
                                    {{ __('CANTIDAD') }}
                                </th>

                                <th class="text-sm">
                                    {{ __('UNIDAD') }}
                                </th>


                                <th class="text-sm">
                                    {{ __('SUBTOTAL') }}
                                </th>



                                <th>


                                    <button class="btn-add" type="button" onclick="create_tr('table_body')"
                                        id="addMoreButton">

                                        <div class="add-sign">+</div>

                                        <div class="add-text">Añadir</div>


                                    </button>

                                </th>


                            </tr>
                        </thead>

                        <tbody id="table_body" style="font-size: 15px">
                            <tr>

                                <td><input name="cajas[]" class="form-control form-control-sm cajas" placeholder="0"></td>
                                <td><input name="unds_x_caja[]" class="form-control form-control-sm unds_x_caja"
                                        placeholder="0"></td>
                                <td><input name="valor_caja[]" class="form-control form-control-sm valor_caja"
                                        placeholder="0.0"></td>
                                <td>
                                    <select name="products[]" class="form-control   buscador cart-product"
                                        style="width: 240px; height:30px" required>
                                        <option value="">{{ __('-- Seleccione una opción') }}</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}"
                                                {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                                {{ $producto->nombre_producto }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input id="product_price[]" name="product_price[]" required
                                        class="form-control form-control-sm product-price" placeholder="0.0"></input>
                                </td>
                                <td>
                                    <input name="qty[]" class="form-control product-qty form-control-sm" required
                                        placeholder="0.0">
                                </td>

                                <td>
                                    <input name="unidad[]" class="form-control product-unidad form-control-sm" disabled
                                        placeholder="">
                                </td>

                                <td>
                                    <input id="item_total" name="item_total[]"
                                        class="form-control form-control-sm product-total"></input>
                                </td>
                                <td>




                                    <button class="button-remove" type="button" onclick="remove_tr(this)">
                                        <svg viewBox="0 0 448 512" class="remove-icon">
                                            <path
                                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                            </path>
                                        </svg>
                                    </button>







                                </td>
                            </tr>
                        </tbody>


                    </table>


                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="tipomoneda" class="text-sm">
                                {{ __('TIPO MONEDA') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <select name="tipomoneda" id="tipomoneda"
                                class="form-control form-control-sm @error('tipomoneda') is-invalid @enderror form-control"
                                aria-label="" required>
                                <option value="">{{ __('-- Seleccione una opción') }}</option>

                                <option value="SOLES" {{ old('tipomoneda') == 'SOLES' ? 'selected' : '' }}>
                                    SOLES
                                </option>
                                <option value="DOLARES" {{ old('tipomoneda') == 'DOLARES' ? 'selected' : '' }}>
                                    DOLARES
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="form-group col-md-3 g-3">
                            <label for="documento_proveedor" class="text-sm">
                                {{ __('RUC PROVEEDOR') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <div class="input-group">
                                <input type="text" name="documento_proveedor" required id="documento_proveedor"
                                    class="form-control form-control-sm @error('documento_proveedor') is-invalid @enderror"
                                    value="{{ old('documento_proveedor') }}" placeholder="ingrese DNI ó RUC">
                                <button class="btn btn-sm btn-success" type="button" id="buscar_proveedor_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                        <path
                                            d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('documento_proveedor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 g-3">
                            <label for="datos_proveedor" class="text-sm">
                                {{ __('NOMBRE Ó RAZÓN SOCIAL PROVEEDOR') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="text" name="proveedor" required id="datos_proveedor"
                                class="form-control form-control-sm @error('datos_proveedor') is-invalid @enderror"
                                value="{{ old('datos_proveedor') }}" placeholder="Datos obtenidos automáticamente...">
                            @error('datos_proveedor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4 g-3 ">
                            <label for="telefono_proveedor" class="text-sm">
                                {{ __('TELÉFONO DEL PROVEEDOR') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input required type="text" step="0.01" name="telefono_proveedor"
                                id="telefono_proveedor"
                                class="form-control form-control-sm @error('telefono_proveedor') is-invalid @enderror"
                                value="{{ old('telefono_proveedor') }}" placeholder="Teléfono del proveedor...">
                            @error('telefono_proveedor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    <div class="row col-md-12 g-3 mb-2">
                        <label for="direccion_proveedor" class="text-sm">
                            {{ __('DIRECCIÓN DEL PROVEEDOR') }}
                        </label>
                        <span class="text-danger">(*)</span>
                        <input type="text" required step="0.01" name="direccion_proveedor"
                            id="direccion_proveedor"
                            class="form-control form-control-sm @error('direccion_proveedor') is-invalid @enderror"
                            value="{{ old('direccion_proveedor') }}" placeholder="Dirección del proveedor...">
                        @error('direccion_proveedor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="row col-md-12 g-3">
                        <label for="observacion" class="text-sm">
                            {{ __('OBSERVACIÓN') }}
                        </label>
                        <textarea name="observacion" id="observacion"
                            class="form-control form-control-sm @error('observacion') is-invalid @enderror"
                            placeholder="De ser el caso, ingrese una observación o comentario...">{{ old('observacion') }}</textarea>
                        @error('observacion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                    <div class="row mt-4 justify-content-end">

                        <div class="d-flex col-md-3 align-items-center justify-content-between">

                            <span style="margin-right:5px"><b>SUMA:</b></span>
                            <input id="product_sub_total" name="product_sub_total"
                                class="product-sub-total form-control form-control-sm" value="0.0"></input>

                        </div>

                        <div class="d-flex col-md-3 align-items-center justify-content-between">

                            <span style="margin-right:5px"><b>DESCUENTO:</b></span>
                            <input id="product_descuento" name="product_descuento"
                                class="product_descuento form-control form-control-sm" value="0.0"></input>

                        </div>

                        <div class="d-flex col-md-3 align-items-center justify-content-between">

                            <span style="margin-right:5px"><b>SUBTOTAL:</b></span>
                            <input id="product_after_descuento" name="product_after_descuento"
                                class="product_after_descuento form-control form-control-sm" value="0.0"></input>

                        </div>

                        <div class="d-flex col-md-3 text-center align-items-center justify-content-between">
                            <span class="" style="margin-right:5px"><b>TOTAL: </b></span>
                            <input id="product_grand_total" name="product_grand_total"
                                class="product-grand-total form-control form-control-sm" value="0.0">
                        </div>


                        <div class="col-md-1 text-right">

                            <button class="btn btn-sm btn-secondary pull-right" type="submit"
                                id="saveOrder">Guardar</button>
                        </div>
                    </div>


                </form>
            </div>



        </div>
    </div>
@stop
@section('js')
    <script src="{{ asset('js/interactive.js') }}"></script>

    <script src="{{ asset('js/packages/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        @if (session('error'))
            Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif


        function updateRowTotal(row) {
            var price = parseFloat(row.find('.product-price').val()) || 0;
            var qty = parseFloat(row.find('.product-qty').val()) || 0;
            var total = price * qty;
            row.find('.product-total').val(total.toFixed(2));
        }

        function calculateGrandTotal() {
            var subTotal = 0;
            var descuento = $('#product_descuento').val();
            var after_descuento = 0;
            var grandTotal = 0;
         
            $(".product-total").each(function() {
                subTotal += parseFloat($(this).val()) || 0;
            });
            after_descuento = (subTotal  - descuento)
            grandTotal = (after_descuento) * 1.18
            

            $("#product_sub_total").val(subTotal.toFixed(2));
            $("#product_grand_total").val(grandTotal.toFixed(2));
            $("#product_after_descuento").val(after_descuento.toFixed(2));

        }



        function updateRowValorUnitarioandCantidad(row) {
            var cajas = parseFloat(row.find('.cajas').val()) || 0;
            var unds_x_caja = parseFloat(row.find('.unds_x_caja').val()) || 0;
            var valor_x_caja = parseFloat(row.find('.valor_caja').val()) || 0;
            var precio_unitario = unds_x_caja ? valor_x_caja / unds_x_caja : 0;
            var cantidad_unidades = unds_x_caja * cajas;
            row.find('.product-price').val(precio_unitario);
            row.find('.product-qty').val(cantidad_unidades);

        }



        //calcular precio unitario y cantidad basado en las cajas
        $(document).on("input", ".cajas, .unds_x_caja, .valor_caja", function() {
            var row = $(this).closest('tr');
            updateRowValorUnitarioandCantidad(row);

            updateRowTotal(row);
            calculateGrandTotal();

        });






        //calcular los totales
        $(document).on("input", ".cart-product, .product-qty, .product-price, .product_descuento", function() {
            var row = $(this).closest('tr');
            updateRowTotal(row);
            calculateGrandTotal();

        });







        //llenar campos basado en el producto encontrado
        $(document).on("change", ".cart-product", function() {
            var product = $(this).val();
            var url = "{{ route('get.product-image.by.product', ['product' => ':product']) }}";
            url = url.replace(':product', product);
            var currentRow = $(this).closest('tr');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var product = response.product;
                        productUnidad = currentRow.find('.product-unidad');
                        productUnidad.val(product.unidad.nombre);


                    } else {
                        // Handle error: product not found
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                }
            });
        });



        $(document).ready(function() {
            $('.buscador').select2({
                theme: "classic"
            });
        });
    </script>



    <!-- API SUNAT Custom script to handle document search -->


    <script>
        //API SUNAT
        $(document).ready(function() {
            function isRucOrDni(value) {
                return value.length === 8 || value.length === 11;
            }

            function buscarDocumento(url, inputId, datosId) {
                var inputValue = $(inputId).val();
                var tipoDocumento = inputValue.length === 8 ? 'dni' : 'ruc';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        documento: inputValue,
                        tipo_documento: tipoDocumento
                    },
                    success: function(response) {
                        console.log('API Response:', response);
                        if (tipoDocumento === 'dni') {
                            $(datosId).val(response.nombres + ' ' + response.apellidoPaterno + ' ' +
                                response.apellidoMaterno);
                        } else {
                            $(datosId).val(response.razonSocial);
                        }
                        $(datosId).removeClass('is-invalid').addClass('is-valid');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        $(datosId).val('');
                        $(datosId).removeClass('is-valid').addClass('is-invalid');
                    }
                });
            }



            $('#buscar_proveedor_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_proveedor',
                    '#datos_proveedor');
            });


            // Input validation
            $('.documento-input').on('input', function() {
                var value = $(this).val();
                var isValid = isRucOrDni(value);
                $(this).toggleClass('is-valid', isValid);
                $(this).toggleClass('is-invalid', !isValid);
            });

            $('.datos-input').on('input', function() {
                var value = $(this).val();
                $(this).toggleClass('is-valid', value.trim().length > 0);
                $(this).toggleClass('is-invalid', value.trim().length === 0);
            });
        });
    </script>


    <script>
        $('#datos_proveedor').on('input', function(e) {
            e.preventDefault();
            let search_string = $(this).val();
            if (search_string.length >= 10) {
                console.log(1);
                $.ajax({
                    url: "{{ route('autocomp.proveedor') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {
                        console.log(1)

                        $('#documento_proveedor').val(response.ruc);
                        $('#direccion_proveedor').val(response.direccion);
                        $('#telefono_proveedor').val(response.telefono);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });

            }
        });

        $('#documento_proveedor').on('input', function(e) {
            e.preventDefault();
            let search_string = $(this).val();
            if (search_string.length >= 7) {
                console.log(1);
                $.ajax({
                    url: "{{ route('autocompbyruc.proveedor') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {
                        console.log(1)

                        $('#datos_proveedor').val(response.razon_social);
                        $('#direccion_proveedor').val(response.direccion);
                        $('#telefono_proveedor').val(response.telefono);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });

            }
        });
    </script>

@endsection
