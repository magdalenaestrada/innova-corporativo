<div class="modal fade text-left" id="ModalCreate"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mt-2">
                                {{ __('CREAR INGRESO RÁPIDO') }}
                            </h6>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                                <img style="width: 13px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('invingresosrapidos.store') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
    
    
                                
                                <th>
                                    {{ __('PRODUCTO') }}
                                </th>
                                <th>
                                    {{ __('VALOR') }}
                                </th>
                                <th>
                                    {{ __('CANTIDAD') }}
                                </th>
    
    
                                <th>
                                    {{ __('SUBTOTAL') }}
                                </th>
    
                            
                                <th>
                                    <button class="btn btn-sm btn-outline-dark pull-right" type="button" onclick="create_tr('table_body')" id="addMoreButton">
                                        <img style="width: 15px" src="{{ asset('images/icon/mas.png') }}" alt="más">
                                    </button>
                                </th>
    
    
                            </tr>
                            </thead>
    
                            <tbody id="table_body">
                                <tr>
                                    
                                    <td>
                                        <select name="products[]" class="buscador form-control  cart-product" style="width: 300px; height:32px" required>
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
                                        <input required id="product_price[]" name="product_price[]" class="form-control form-control-sm product-price"
                                        placeholder="0.0"></input>
                                    </td>
                                    <td>
                                        <input required name="qty[]" type="text" 
                                        class="form-control form-control-sm product-qty" placeholder="0.0" >
                                    </td>
                                    
                                    <td>
                                        <input id="item_total" name="item_total[]" class="form-control form-control-sm product-total" placeholder="0.0"></input>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="remove_tr(this)" type="button">Quitar</button>
    
                                    </td>
                                </tr>
                            </tbody>
                                         
                        </table>
                    </div>

                                                           
                    <div class="row mb-3">
                        <div class="form-group col-md-4 g-3">
                            <label for="documento_proveedor" class="text-sm">
                                {{ __('RUC PROVEEDOR') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <div class="input-group">
                                <input required type="text" name="documento_proveedor" id="documento_proveedor"
                                    class="form-control form-control-sm @error('documento_proveedor') is-invalid @enderror"
                                    value="{{ old('documento_proveedor') }}" placeholder="Ingrese documento...">
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
                        <div class="form-group col-md-8 g-3">
                            <label for="datos_proveedor" class="text-sm">
                                {{ __('NOMBRE O RAZÓN SOCIAL PROVEEDOR') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input required type="text" name="proveedor" id="datos_proveedor"
                                class="form-control form-control-sm @error('datos_proveedor') is-invalid @enderror"
                                value="{{ old('datos_proveedor') }}" placeholder="Datos obtenidos automáticamente...">
                            @error('datos_proveedor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>             
                    <div class="row">
                            <div class="form-group col-md-6 g-3 ">
                                <label for="tipo_comprobante" class="text-sm">
                                    {{ __('TIPO COMPROBANTE') }}
                                </label>
                                <span class="text-danger">(*)</span>
                                <select name="tipo_comprobante" id="tipo_comprobante"
                                    class=" @error('tipo_comprobante') is-invalid @enderror form-control form-control-sm" aria-label="" required>
                                    <option value="">{{ __('-- Seleccione una opción') }}</option>

                                    <option value="BOLETA" {{ old('tipo_comprobante') == 'BOLETA' ? 'selected' : '' }}>
                                        BOLETA
                                    </option>
                                    <option value="FACTURA" {{ old('tipo_comprobante') == 'FACTURA' ? 'selected' : '' }}>
                                        FACTURA
                                    </option>
                                    <option value="TICKET" {{ old('tipo_comprobante') == 'TICKET' ? 'selected' : '' }}>
                                        TICKET
                                    </option>
                                    <option value="OTRO" {{ old('tipo_comprobante') == 'OTRO' ? 'selected' : '' }}>
                                        OTRO
                                    </option>
                                    
                                </select>
                            </div>

                            <div class="form-group col-md-6 g-3 ">
                                <label for="comprobante_correlativo	" class="text-sm">
                                            {{ __('COMPROBANTE CORRELATIVO') }}
                                </label>
                                <span class="text-danger">(*)</span>
                                <input required type="text" step="0.01" name="comprobante_correlativo" id="stock" class="form-control form-control-sm @error('comprobante_correlativo') is-invalid @enderror" value="{{ old('comprobante_correlativo') }}" placeholder="Comprobante correlativo...">
                                @error('comprobante_correlativo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 g-3 mb-3" id="tipo_comprobante_especifico_group" style="display:none;">
                                <label for="tipo_comprobante_especifico" class="text-sm">
                                    {{ __('TIPO COMPROBANTE ESPECIFICO') }}
                                </label>
                                <span class="text-danger">(*)</span>
                                <input type="text" name="tipo_comprobante_especifico" id="tipo_comprobante_especifico" class="form-control form-control-sm">
                                @error('tipo_comprobante_especifico')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            
                    </div>
                    

                    <div class="d-flex justify-content-end row align-items-center mt-2">

                        <div class=" mr-3 d-flex align-items-center">
                            <span class="text-sm mr-1"><b>SUBTOTAL:</b></span>
                            <div class="text-right">

                                
                                <input id="product_sub_total" name="product_sub_total" class="product-sub-total form-control form-control-sm"
                                    value="0.0"></input>

                            </div>

                        </div>

                        <div class="d-flex align-items-center">
                            <span class="text-sm mr-1"><b>TOTAL:</b></span>
                        
                            <div class="text-right">

                            
                            <input id="product_grand_total" name="product_grand_total" class="product-sub-total form-control form-control-sm"
                                value="0.0"></input>

                            </div>

                        </div>
                        
                        
                        <div class="col-md-2 ">

                            <button class="btn ml-5 btn-sm btn-secondary pull-right" type="submit" id="saveOrder">Guardar</button>
                        </div>
                    </div>
                </form>

                </div>
        </div>
    </div>
</div>
@section('js')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('js/interactive.js')}}"></script>
    
    <script>
        //Esta función actualiza el subtotal por fila añadida y producto
        function updateRowTotal(row) {
            var price = parseFloat(row.find('.product-price').val()) || 0;
            var qty = parseFloat(row.find('.product-qty').val()) || 0;
            var total = price * qty;
            row.find('.product-total').val(total.toFixed(2));
        }
        //Esta función calcula el subtotal total en base a los subtotales
        function calculateGrandTotal() {
            var valuetipoComprobanteSelect = document.getElementById('tipo_comprobante').value;

            var subTotal = 0;
            var grandTotal = 0;
            $(".product-total").each(function() {
                subTotal += parseFloat($(this).val()) || 0;
            });
            //CALCULA EL 18% de impuesto en caso se use factura
            if (valuetipoComprobanteSelect === 'FACTURA'){
                grandTotal = subTotal * 1.18
            }else{
                grandTotal = subTotal
            }
            $("#product_sub_total").val(subTotal.toFixed(2));
            $("#product_grand_total").val(grandTotal.toFixed(2));

        }

        $(document).on("input", ".cart-product, .product-qty, .product-price", function() {
            var row = $(this).closest('tr'); 
            updateRowTotal(row);
            calculateGrandTotal();
                    
        });

        $(document).on("input", ".cart-product", function() {
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
                                productImage = currentRow.find('.product-image');
                                productImage.attr('src', product.image);


                            } else {
                                // Handle error: product not found
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle AJAX errors
                        }
                    });
        });


    
        document.addEventListener('DOMContentLoaded', function() {
            var tipoComprobanteSelect = document.getElementById('tipo_comprobante');
            var tipoComprobanteEspecificoGroup = document.getElementById('tipo_comprobante_especifico_group');
            var tipoComprobanteEspecificoInput = document.getElementById('tipo_comprobante_especifico');
            var submitButton = document.getElementById('submit_button');

            tipoComprobanteSelect.addEventListener('change', function() {
                calculateGrandTotal() //Cálcula el total cada que se selecciona un nuevo tipo de comprobate

                if (this.value === 'OTRO') {
                    tipoComprobanteEspecificoGroup.style.display = 'block';
                    tipoComprobanteEspecificoInput.required = true; // Make the field required
                    validateInput(); // Initial validation when 'OTRO' is selected
                } else {
                    tipoComprobanteEspecificoGroup.style.display = 'none';
                    tipoComprobanteEspecificoInput.value = '';
                    tipoComprobanteEspecificoInput.required = false; // Remove the required attribute
                    submitButton.style.display = 'block'; // Show the submit button if not 'OTRO'
                }
            });

            tipoComprobanteEspecificoInput.addEventListener('input', function() {
                validateInput();
            });

            function validateInput() {
                if (tipoComprobanteEspecificoInput.value.trim() === '') {
                    submitButton.style.display = 'none';
                } else {
                    submitButton.style.display = 'block';
                }
            }
            
            $(document).ready(function() {
            $('.buscador').select2({theme: "classic"});
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tipoComprobanteSelect = document.getElementById('tipo_comprobante');
            var tipoComprobanteEspecificoGroup = document.getElementById('tipo_comprobante_especifico_group');
            var tipoComprobanteEspecificoInput = document.getElementById('tipo_comprobante_especifico');
            var saveOrderButton = document.getElementById('saveOrder');

            tipoComprobanteSelect.addEventListener('change', function() {
                if (this.value === 'OTRO') {
                    tipoComprobanteEspecificoGroup.style.display = 'block';
                    tipoComprobanteEspecificoInput.required = true; // Make the field required
                    validateInput(); // Initial validation when 'OTRO' is selected
                } else {
                    tipoComprobanteEspecificoGroup.style.display = 'none';
                    tipoComprobanteEspecificoInput.value = '';
                    tipoComprobanteEspecificoInput.required = false; // Remove the required attribute
                    saveOrderButton.style.display = 'block'; // Show the submit button if not 'OTRO'
                }
            });

            tipoComprobanteEspecificoInput.addEventListener('input', function() {
                validateInput();
            });

            function validateInput() {
                if (tipoComprobanteEspecificoInput.value.trim() === '') {
                    saveOrderButton.style.display = 'none';
                } else {
                    saveOrderButton.style.display = 'block';
                }
            }
            
            $(document).ready(function() {
            $('.buscador').select2({theme: "classic"});
            });
            
            
        });
        
        
        
        $(document).ready(function() {
            $('.buscador').select2({theme: "classic"});
        });
        
        
    </script>  
        
    <!-- Custom script to handle document search -->
    
    <script>
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

            // Button click handlers
            $('#buscar_cliente_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_cliente', '#datos_cliente');
            });

            $('#buscar_conductor_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_conductor',
                    '#datos_conductor');
            });

            $('#buscar_balanza_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_balanza', '#datos_balanza');
            });

            $('#buscar_socio_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_socio', '#datos_socio');
            });

            $('#buscar_trabajador_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_trabajador',
                    '#datos_trabajador');
            });

            $('#buscar_proveedor_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_proveedor',
                    '#datos_proveedor');
            });

            $('#buscar_solicitante_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_solicitante',
                    '#nombre_solicitante');
            });

            $('#buscar_responsable_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_responsable',
                    '#nombre_responsable');
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

@stop
