<div class="modal fade text-left" id="ModalCreate" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REGISTRAR ADELANTO') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" style="font-size: 30px" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <img style="width: 15px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="create-adelanto" action="{{ route('lqadelantos.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-6 g-3">
                            <label for="sociedad" class="text-SM">
                                {{ __('SOCIEDAD') }}
                            </label>
                            <br>
                            <select name="sociedad_id" id="sociedad"
                                class="form-control form-control-sm buscador @error('sociedad') is-invalid @enderror"
                                aria-label="" style="width: 100%" required>
                                <option selected value="">
                                    SELECCIONE LA SOCIEDAD
                                </option>
                                @foreach ($sociedades as $sociedad)
                                    <option value="{{ $sociedad->id }}"
                                        {{ old('sociedad') == $sociedad->id ? 'selected' : '' }}>
                                        {{ strtoupper($sociedad->codigo) }} - {{ strtoupper($sociedad->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipocomprobante')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form col-md-6" style="margin-top: 30px">
                            <input name="sociedad_nombre" id="sociedad_nombre" class="form-control form-control-sm"
                                placeholder="NOMBRE DE LA SOCIEDAD" disabled type="text">
                            <span class="input-border"></span>
                        </div>


                        <div class="form input-group col-md-4">
                            <input name="documento" id="documento" class="form-control form-control-sm"
                                placeholder="DOCUMENTO REPRESENTANTE..." type="text">
                                <button class="btn btn-sm btn-success" type="button" style="width:30.5px; height:30.5px"
                                id="buscar_beneficiario_btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                    viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                    <path
                                        d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <div class="form col-md-8 mb-2">
                            <input name="nombre" id="nombre" class="form-control form-control-sm"
                                placeholder="VALIDE EL NOMBRE DEL REPRESENTANTE DEL CLIENTE..." type="text">
                            <span class="input-border"></span>
                        </div>



                        <div class="form-group col-md-4 g-3">
                            <label for="tipo_comprobante" class="text-sm">
                                {{ __('TIPO DE COMPROBANTE') }}
                            </label>
                            <br>
                            <select name="tipo_comprobante_id" id="tipo_comprobante"
                                class="form-control form-control-sm buscador @error('tipo_comprobante') is-invalid @enderror"
                                aria-label="" style="width: 100%">
                                <option selected value="">
                                    SELECCIONE EL TIPO DE COMPROBANTE
                                </option>
                                @foreach ($tiposcomprobantes as $tipocomprobante)
                                    <option value="{{ $tipocomprobante->id }}"
                                        {{ old('banco') == $tipocomprobante->id ? 'selected' : '' }}>
                                        {{ strtoupper($tipocomprobante->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipocomprobante')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form col-md-4  mb-1">
                            <label for="comprobante_correlativo" class="text-sm">
                                {{ __('NRO COMPROBANTE') }}
                            </label>
                            <input name="comprobante_correlativo" id="comprobante_correlativo"
                                class="form-control form-control-sm" placeholder="CORRELATIVO DEL COMPROBANTE"
                                type="text">
                            <span class="input-border"></span>
                        </div>



                        <div class="form-group col-md-4 g-3">
                            <label for="cliente" class="text-sm">
                                {{ __('RAZON SOCIAL FACTURA') }}
                            </label>
                            <br>
                            <select name="cliente_id" id="cliente"
                                class="form-control form-control-sm buscador @error('cliente') is-invalid @enderror"
                                aria-label="" style="width: 100%">
                                <option selected value="">
                                    SELECCIONE LA RAZÓN SOCIAL DEL PROVEEDOR
                                </option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ old('cliente') == $cliente->id ? 'selected' : '' }}>
                                        {{ strtoupper($cliente->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>





                        <div class="form-group col-md-8 ">
                            <label for="cuenta" class="text-sm">
                                {{ __('CUENTA') }}
                            </label>
                            <br>
                            <select name="cuenta_id" id="cuenta"
                                class="form-control form-control-sm buscador @error('cuenta') is-invalid @enderror"
                                aria-label="" style="width: 100%" required="">
                                <option selected value="">
                                    SELECCIONE LA CUENTA
                                </option>
                                @foreach ($cuentas as $cuenta)
                                    <option value="{{ $cuenta->id }}"
                                        {{ old('cuenta') == $cuenta->id ? 'selected' : '' }}>
                                        {{ strtoupper($cuenta->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cuenta')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        
                        <div class="form col-md-4  mb-1">
                            <label for="nro_operacion" class="text-sm">
                                {{ __('NRO OPERACIÓN') }}
                            </label>
                            <input name="nro_operacion" id="nro_operacion"
                                class="form-control form-control-sm" placeholder="NRO OPERACIÓN..."
                                type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="form-group col-md-9 g-3">
                            <label for="motivo" class="text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <select name="motivo_id" id="motivo"
                                class="form-control form-control-sm buscador @error('cuenta') is-invalid @enderror"
                                aria-label="" style="width: 100%" required>
                                <option selected value="">
                                    SELECCIONE EL MOTIVO
                                </option>
                                @foreach ($motivos as $motivo)
                                    <option value="{{ $motivo->id }}"
                                        {{ old('motivo') == $motivo->id ? 'selected' : '' }}>
                                        {{ strtoupper($motivo->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('motivo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form col-md-3 mb-1">
                            <label for="fecha" class="text-sm">
                                {{ __('FECHA') }}
                            </label>
                            <input name="fecha" id="fecha" class="form-control form-control-sm"
                                placeholder="INGRESE LA FECHA" type="date" value="{{ date('Y-m-d') }}">
                            <span class="input-border"></span>
                        </div>



                        <div class="form-group col-md-12 g-3">
                            <label for="descripcion" class="text-sm">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            <input name="descripcion" id="descripcion"
                                class="form-control form-control-sm @error('descripcion') is-invalid @enderror"
                                placeholder="DE SER EL CASO, INGRESE UNA DESCRIPCIÓN...">
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2" id="detraccionDolaresField" style="display: none;">
                            <label for="monto" class="text-sm">
                                {{ __('SIN DETRACCIÓN DOLARES') }}
                            </label>
                            <input name="total_sin_detraccion_dolares" id="detraccion_dolares" disabled
                                class="form-control form-control-sm" placeholder="TOTAL EN DÓLARES" type="text">
                            <span class="input-border"></span>
                        </div>
                        <div class="col-md-6" id="detraccionSolesField" style="display: none;">
                            <label for="monto" class="text-sm">
                                {{ __('SIN DETRACCIÓN SOLES') }}
                            </label>
                            <input name="total_sin_detraccion_soles" id="detraccion_soles" class="form-control form-control-sm"
                                disabled placeholder="TOTAL EN SOLES" type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="col-md-2 d-flex flex-column align-items-center" style="margin-top:2px ">
                            <label for="monto" class="text-sm">
                                {{ __('DETRACCIÓN?') }}
                            </label>
                            <div class="checkbox-wrapper-12">
                                <div class="cbx">
                                    <input id="cbx-12" type="checkbox" name="detraccion_checked" onclick="toggleDetraccionFields()" />
                                    <label for="cbx-12"></label>
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                                        <path d="M2 8.36364L6.23077 12L13 2"></path>
                                    </svg>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                                    <defs>
                                        <filter id="goo-12">
                                            <feGaussianBlur in="SourceGraphic" stdDeviation="4" result="blur">
                                            </feGaussianBlur>
                                            <feColorMatrix in="blur" mode="matrix"
                                                values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" result="goo-12">
                                            </feColorMatrix>
                                            <feBlend in="SourceGraphic" in2="goo-12"></feBlend>
                                        </filter>
                                    </defs>
                                </svg>
                            </div>
                        </div>



                        <div class="form col-md-3 mb-3">
                            <label for="monto" class="text-sm">
                                {{ __('DOLARES') }}
                            </label>
                            <input disabled name="monto" id="monto" class="form-control form-control-sm"
                                placeholder="TOTAL EN DÓLARES" required="" type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="form col-md-3 mb-3">
                            <label for="tipo_cambio" class="text-sm">
                                {{ __('TIPO DE CAMBIO') }}
                            </label>
                            <input name="tipo_cambio" id="tipocambio" class="form-control form-control-sm"
                                placeholder="TIPO DE CAMBIO" required type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="form col-md-4 mb-3">
                            <label for="SOLES" class="text-sm">
                                {{ __('TOTAL') }}
                            </label>
                            <input disabled name="total" id="total" class="form-control form-control-sm"
                                placeholder="TOTAL EN SOLES" required type="text">
                            <span class="input-border"></span>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <button type="submit" class="btn btn-success btn-sm mr-1">
                            {{ __('REGISTRAR') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.buscador').select2({
                theme: "classic"
            });
            $('.buscador2').select2({
                theme: "classic"
            });
        });






        function toggleDetraccionFields() {
            const isChecked = document.getElementById('cbx-12').checked;

            // Get the fields
            const dolaresField = document.getElementById('detraccionDolaresField');
            const solesField = document.getElementById('detraccionSolesField');
            const dolaresInput = document.getElementById('detraccion_dolares');
            const solesInput = document.getElementById('detraccion_soles');
            const total = document.getElementById('total');

            // Toggle display based on checkbox state
            dolaresField.style.display = isChecked ? 'block' : 'none';
            solesField.style.display = isChecked ? 'block' : 'none';

            // Toggle required attribute and enable/disable inputs based on checkbox and tipocambio value
            if (isChecked) {
                dolaresInput.setAttribute('required', 'required');
                solesInput.setAttribute('required', 'required');

                // Retrieve tipocambio value and check if it's valid
                const tipocambio = parseFloat(document.getElementById('tipocambio').value);
                const total = parseFloat(document.getElementById('total').value);

                if (!isNaN(tipocambio) && !isNaN(total) ) {
                    dolaresInput.disabled = false; // Enable dolares input if tipocambio is valid
                    solesInput.disabled = false; // Enable soles input if tipocambio is valid
                } else {
                    dolaresInput.disabled = true; // Disable if tipocambio is invalid
                    solesInput.disabled = true;
                }
            } else {
                // Remove required attribute and disable inputs when the checkbox is unchecked
                dolaresInput.removeAttribute('required');
                solesInput.removeAttribute('required');
                dolaresInput.disabled = true;
                solesInput.disabled = true;
            }
        }
    
        $(document).on("input", '#tipocambio, #monto, #total', function() {
            var tipocambio = parseFloat($('#tipocambio').val()); // Convert to a float
            var monto = parseFloat($('#monto').val()); // Convert to a float
            var total = parseFloat($('#total').val()) || 0; // Safely parse the total, default to 0 if invalid

            if (!isNaN(tipocambio)) {
                // Calculate total if monto is provided
                if (!isNaN(monto) && monto && !$('#total').is(':focus')) {
                    total = (monto * tipocambio).toFixed(2); // Calculate total
                    $('#total').val(total); // Set total value
                }

                // Calculate monto if total is provided
                if (!isNaN(total) && total && !$('#monto').is(':focus')) {
                    monto = (total / tipocambio).toFixed(2); // Calculate monto
                    $('#monto').val(monto); // Set monto value
                }



                var detraccion_dolares = document.getElementById('detraccion_dolares');

                // Calculate 110% for the two fields upwards
                if (detraccion_dolares && (!isNaN(tipocambio)) && (!isNaN(monto))) {

                    var detDolares = Math.floor(monto * 1.111111111111111 * 100) / 100; // 110% of monto in dolares, rounded to two decimal places
                    var detSoles = Math.floor(total * 1.1111111111111111 * 100) / 100; // 110% of total in soles, rounded to two decimal places

                    // Set 110% values
                    $('#detraccion_dolares').val(detDolares);
                    $('#detraccion_soles').val(detSoles);


                }



            } else {
                console.log('Error: Invalid input in tipocambio');
            }
        });




        $(document).on("input", '#tipocambio, #monto, #total', function() {
            var tipocambio = parseFloat($('#tipocambio').val()); // Get and parse the tipocambio value
            var total = parseFloat($('#total').val()); // Get and parse the tipocambio value

            if (!isNaN(tipocambio) ) {
                // If tipocambio is valid, enable 'monto' and 'total' fields for input
                $('#monto').prop('disabled', false);
                $('#total').prop('disabled', false);

                // Check if detraccion fields are visible and enable them if so
                if ($('#detraccionDolaresField').is(':visible') && !isNaN(total) ) {
                    $('#detraccion_dolares').prop('disabled', false);
                }else {
                    $('#detraccion_dolares').prop('disabled', true); 
                }
                if ($('#detraccionSolesField').is(':visible') && !isNaN(total) ) {
                    $('#detraccion_soles').prop('disabled', false);
                }else{
                    $('#detraccion_soles').prop('disabled', true);
                }
            } else {
                // If tipocambio is not valid, disable 'monto', 'total', and detraccion fields
                $('#monto').prop('disabled', true);
                $('#total').prop('disabled', true);
                $('#detraccion_dolares').prop('disabled', true);
                $('#detraccion_soles').prop('disabled', true);
            }
        });
    
        $(document).on("input", "#sociedad", function() {
            var sociedad = $(this).val();
            var url = "{{ route('get.sociedad.nombre.by.code', ['sociedad' => ':sociedad']) }}";
            url = url.replace(':sociedad', sociedad);


            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var sociedad = response.sociedad;
                        $('#sociedad_nombre').val(response.sociedad.nombre.toUpperCase());
                    } else {
                        // Handle error: product not found
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                }
            });
        });



        $(document).on("input", "#cliente", function() {
            var cliente = $(this).val();
            var url = "{{ route('get.lqcliente.documento.by.nombre', ['cliente' => ':cliente']) }}";
            url = url.replace(':cliente', cliente);


            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var cliente = response.cliente;
                        $('#cliente_documento').val(response.cliente.documento);
                    } else {
                        console.log(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error:', error);
                }
            });
        });



        $('.create-adelanto').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Crear Adelanto?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#007777',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, confirmar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });




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



            $('#buscar_beneficiario_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento',
                    '#nombre');
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






    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                html: '@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach',
            });
        </script>
    @endif




@endpush
