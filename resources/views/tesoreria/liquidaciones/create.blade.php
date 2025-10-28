@extends('admin.layout')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/areas.css') }}">
@endpush
@section('content')
    <div class="container">
        <br />
        <div class="card">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('LIQUIDAR') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-danger btn-sm" href="{{ route('lqliquidaciones.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form class="create-liquidacion" method="POST" action="{{ route('lqliquidaciones.store') }}">
                    @csrf

                    <div class="row" style="margin-top: -16px">

                        <div class=" col-md-5 g-3 ">
                            <label for="cuenta" class="text-sm" style="margin-bottom: 2px">
                                {{ __('CUENTA') }}
                            </label>
                            <br>
                            <select name="cuenta_id" id="cuenta"
                                class="form-control form-control-sm buscador @error('cuenta') is-invalid @enderror"
                                aria-label="" style="width: 100%" required="">
                                <option selected value="">
                                    Seleccione la cuenta
                                </option>
                                @foreach ($cuentas as $cuenta)
                                    <option value="{{ $cuenta->id }}"
                                        {{ old('cuenta') == $cuenta->id ? 'selected' : '' }}>
                                        {{ $cuenta->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cuenta')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 ">
                            <label for="motivo" class="text-sm" style="margin-bottom: 2px">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <select name="motivo_id" id="motivo"
                                class=" form-control form-control-sm buscador @error('cuenta') is-invalid @enderror"
                                aria-label="" style="width: 100%" required>
                                <option selected value="">
                                    Seleccione el motivo
                                </option>
                                @foreach ($motivos as $motivo)
                                    <option value="{{ $motivo->id }}"
                                        {{ old('motivo') == $motivo->id ? 'selected' : '' }}>
                                        {{ $motivo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('motivo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form col-md-2 ">
                            <label for="fecha" class="text-sm" style="margin-bottom: 2px">
                                {{ __('FECHA') }}
                            </label>
                            <input name="fecha" id="fecha" class="form-control form-control-sm"
                                placeholder="Ingrese la fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}"
                                type="date">
                            <span class="input-border"></span>
                        </div>


                        <div style="margin-top:-13px" class="form-group col-md-3 g-3">
                            <label for="tipo_comprobante" class="text-sm" style="margin-bottom: 2px">
                                {{ __('TIPO DE COMPROBANTE') }}
                            </label>
                            <br>
                            <select name="tipo_comprobante_id" id="tipo_comprobante"
                                class=" form-control form-control-sm buscador @error('tipo_comprobante') is-invalid @enderror"
                                aria-label="" style="width: 100%">
                                <option selected value="">
                                    Seleccione el tipo de comprobante
                                </option>
                                @foreach ($tiposcomprobantes as $tipocomprobante)
                                    <option value="{{ $tipocomprobante->id }}"
                                        {{ old('banco') == $tipocomprobante->id ? 'selected' : '' }}>
                                        {{ $tipocomprobante->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipocomprobante')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div style="margin-top:-13px" class="form col-md-3  ">
                            <label for="comprobante_correlativo" class="text-sm" style="margin-bottom: 2px">
                                {{ __('NRO COMPROBANTE') }}
                            </label>
                            <input name="comprobante_correlativo" id="comprobante_correlativo"
                                class="form-control-sm form-control" placeholder="Ingrese el correlativo del comprobante"
                                type="text">
                            <span class="input-border"></span>
                        </div>

                        <div style="margin-top:-13px" class="form-group col-md-4 g-3">
                            <label for="cliente" class="text-sm" style="margin-bottom: 2px">
                                {{ __('RAZON SOCIAL FACTURA') }}
                            </label>
                            <br>
                            <select name="cliente_id" id="cliente"
                                class=" form-control form-control-sm buscador @error('cliente') is-invalid @enderror"
                                aria-label="" style="width: 100%">
                                <option selected value="">
                                    Seleccione la razón social del proveedor
                                </option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ old('cliente') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre }}
                                    </option>
                                @endforeach
                            </select>

                        </div>



                        <div style="margin-top:-13px" class="form col-md-2  ">
                            <label for="nro_operacion" class="text-sm" style="margin-bottom: 2px">
                                {{ __('NRO OPERACIÓN') }}
                            </label>
                            <input name="nro_operacion" id="nro_operacion" class="form-control-sm form-control"
                                placeholder="Operación..." type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="input-group form  col-md-4 ">
                            <input name="documento" id="documento" class=" form-control form-control-sm"
                                placeholder="Documento del representante..." type="text">
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

                        <div class="form col-md-8">
                            <input name="nombre" id="nombre" class=" form-control form-control-sm"
                                placeholder="Valide el nombre del representante del cliente..." type="text">
                            <span class="input-border"></span>
                        </div>

                        <div style="margin-top: 1px" class="form-group col-md-12 ">
                            <label for="descripcion" class="text-sm" style="margin-bottom: 2px">
                                {{ __('DESCRIPCIÓN') }}
                            </label>
                            <input name="descripcion" id="descripcion"
                                class="form-control form-control-sm @error('descripcion') is-invalid @enderror"
                                placeholder="De ser el caso, ingrese una descripción...">
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>





                        <div style="margin-top:-13px" class="form-group col-md-6     ">
                            <label for="sociedad" class="text-sm" style="margin-bottom: 2px">
                                {{ __('SOCIEDAD CÓDIGO') }}
                            </label>
                            <br>
                            <select name="sociedad_id" id="sociedad"
                                class=" form-control form-control-sm buscador @error('sociedad') is-invalid @enderror"
                                aria-label="" style="width: 100%" required>
                                <option selected value="">
                                    Seleccione la sociedad
                                </option>
                                @foreach ($sociedades as $sociedad)
                                    <option value="{{ $sociedad->id }}"
                                        {{ old('sociedad') == $sociedad->id ? 'selected' : '' }}>
                                        {{ $sociedad->codigo }} - {{ $sociedad->nombre }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div style="margin-top:-13px" class="form col-md-6  ">
                            <label for="sociedad" class="text-sm" style="margin-bottom: 2px">
                                {{ __('NOMBRE') }}
                            </label>
                            <input name="sociedad_nombre" id="sociedad_nombre" class=" form-control form-control-sm"
                                placeholder="Nombre de la sociedad" disabled type="text">
                            <span class="input-border"></span>
                        </div>

                        <!-- CONTAINER PARA LOS ADELANTOS RELACIONADOS A ESTA SOCIEDAD -->
                        <div id="checkbox_adelantos_container" class="col-md-12  mb-1">
                        </div>



                        <div style="margin-top:-5px" class="form col-md-4 ">
                            <label for="dolares" class="text-sm" style="margin-bottom: 2px">
                                {{ __('LIQUIDACIÓN EN DOLARES') }}
                            </label>
                            <input name="dolares" id="dolares" class="form-control form-control-sm"
                                placeholder="Total en dolares" required="" type="text">
                            <span class="input-border"></span>
                        </div>

                        <div style="margin-top:-5px" class="form col-md-4 ">
                            <label for="tipo_cambio" class="text-sm" style="margin-bottom: 2px">
                                {{ __('TIPO CAMBIO') }}
                            </label>
                            <input name="tipo_cambio" id="tipocambio" class="form-control form-control-sm"
                                placeholder="Ingrese el tipo de cambio" required type="text">
                            <span class="input-border"></span>
                        </div>

                        <div style="margin-top:-5px" class="form col-md-4">
                            <label for="soles" class="text-sm" style="margin-bottom: 2px">
                                {{ __('CONVERSIÓN') }}
                            </label>
                            <input name="soles" id="soles" class="form-control form-control-sm"
                                placeholder="Total en soles" required type="text">
                            <span class="input-border"></span>
                        </div>



                        <div class="col-md-6">

                            <label for="descuento" class="text-info text-sm" style="margin-bottom: 2px">
                                {{ __('DESCUENTO POR ADELANTOS DOLARES') }}
                            </label>
                            <input name="descuento_dolares" id="descuento_dolares"
                                class="bg-info .text-white form-control form-control-sm" value="0.00" placeholder=""
                                required type="text">
                            <span class="input-border"></span>
                        </div>


                        <div class="col-md-6">

                            <label for="descuento" class="text-info text-sm" style="margin-bottom: 2px">
                                {{ __('DESCUENTO POR ADELANTOS SOLES') }}
                            </label>
                            <input name="descuento_soles" id="descuento_soles"
                                class="bg-info .text-white form-control form-control-sm" value="0.00" placeholder=""
                                required type="text">
                            <span class="input-border"></span>
                        </div>






                        <div class="col-md-6 mb-2" id="detraccionDolaresField" style="display: none;">
                            <label for="monto" class="text-sm">
                                {{ __('CON DETRACCIÓN DOLARES') }}
                            </label>
                            <input name="total_sin_detraccion_dolares" id="detraccion_dolares" disabled
                                class="form-control form-control-sm" placeholder="TOTAL EN DÓLARES" type="text">
                            <span class="input-border"></span>
                        </div>
                        <div class="col-md-6" id="detraccionSolesField" style="display: none;">
                            <label for="monto" class="text-sm">
                                {{ __('CON DETRACCIÓN SOLES') }}
                            </label>
                            <input name="total_sin_detraccion_soles" id="detraccion_soles"
                                class="form-control form-control-sm" disabled placeholder="TOTAL EN SOLES"
                                type="text">
                            <span class="input-border"></span>
                        </div>



                        <div class="col-md-2 d-flex flex-column align-items-center" style="margin-top:2px ">
                            <label for="monto" class="text-sm">
                                {{ __('DETRACCIÓN?') }}
                            </label>
                            <div class="checkbox-wrapper-12">
                                <div class="cbx">
                                    <input id="cbx-12" type="checkbox" name="detraccion_checked"
                                        onclick="toggleDetraccionFields()" />
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


                        <div class="col-md-5 ">

                            <label for="importe_dolares" class="text-success text-sm" style="margin-bottom: 2px">
                                {{ __('IMPORTE FINAL DOLARES') }}
                            </label>
                            <input name="importe_total_dolares" id="importe_total_dolares"
                                class="bg-success .text-white form-control form-control-sm" value="0.00" placeholder=""
                                required type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="col-md-5 ">

                            <label for="importe_soles" class="text-success text-sm" style="margin-bottom: 2px">
                                {{ __('IMPORTE FINAL SOLES') }}
                            </label>
                            <input name="importe_total_soles" id="importe_total_soles"
                                class="bg-success .text-white form-control form-control-sm" value="0.00" placeholder=""
                                required type="text">
                            <span class="input-border"></span>
                        </div>




                        <div class="col-md-6">

                            <label for="otros_descuentos_dolares" class="text-secondary text-sm"
                                style="margin-bottom: 2px">
                                {{ __('OTROS DESCUENTOS DOLARES') }}
                            </label>
                            <input name="otros_descuentos_dolares" id="otros_descuentos_dolares"
                                class=" .text-white form-control form-control-sm" placeholder="0.00" type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="col-md-6">

                            <label for="otros_descuentos_soles" class="text-secondary text-sm"
                                style="margin-bottom: 2px">
                                {{ __('OTROS DESCUENTOS SOLES') }}
                            </label>
                            <input name="otros_descuentos_soles" id="otros_descuentos_soles"
                                class="form-control form-control-sm" placeholder="0.00" type="text">
                            <span class="input-border"></span>
                        </div>



                        <div class="col-md-12 text-right g-3">
                            <button type="submit" class="btn btn-sm btn-secondary text-end mt-2">REGISTRAR
                                LIQUIDACIÓN</button>
                        </div>
                        <br>

                    </div>

                </form>
            </div>
        </div>
    </div>

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var adelantos = @json($adelantos);
        // BUSCADOR CON SEARCHING
        $(document).ready(function() {
            $('.buscador').select2({
                theme: "classic"
            });
        });
        $(document).ready(function() {
            // BASADO EN LA SOCIEDAD MUESTRA LOS ADELANTOS CON UN CHECKBOX
            $('#sociedad').change(function() {
                let sociedadId = $(this).val();

                if (sociedadId) {
                    $.ajax({
                        url: '{{ route('get.adelantos.by.sociedad') }}', // Adjust the URL to your route
                        method: 'GET',
                        data: {
                            sociedad_id: sociedadId
                        },
                        success: function(data) {
                            let container = $('#checkbox_adelantos_container');
                            container.empty(); // Clear previous checkboxes

                            if (data.length > 0) {

                                container.append(
                                    `<h6 style = "margin-bottom: -3px; margin-top: -10px">ADELANTOS REGISTRADOS</h6>`
                                )

                                data.forEach(function(adelanto) {
                                    let dol_monto;
                                    let sol_monto;

                                    if (adelanto.salidacuenta.cuenta.tipomoneda
                                        .nombre == 'DOLARES') {

                                        if (adelanto.total_sin_detraccion) {

                                            dol_monto = adelanto.total_sin_detraccion
                                            sol_monto = adelanto.total_sin_detraccion *
                                                adelanto.tipo_cambio

                                        } else {

                                            dol_monto = adelanto.salidacuenta.monto
                                            sol_monto = adelanto.salidacuenta.monto *
                                                adelanto.tipo_cambio

                                        }






                                    } else {


                                        if (adelanto.total_sin_detraccion) {
                                            dol_monto = Math.round((adelanto
                                                    .total_sin_detraccion / adelanto
                                                    .tipo_cambio) *
                                                100) / 100;
                                            sol_monto = adelanto.total_sin_detraccion

                                        } else {
                                            dol_monto = Math.round((adelanto
                                                    .salidacuenta.monto / adelanto
                                                    .tipo_cambio) *
                                                100) / 100;
                                            sol_monto = adelanto.salidacuenta.monto
                                        }





                                    }


                                    container.append(`
                                        <div class="col-md-12">

                                                <input type="checkbox" name="adelantos[]" value="${adelanto.id}" id="adelanto_${adelanto.id}">
                                                <span style="font-size:13px;" for="adelanto_${adelanto.id}">
            DOLARES: ${dol_monto}, CAMBIO: ${adelanto.tipo_cambio}, SOLES: ${sol_monto}, 
            COMPROBANTE: ${adelanto.salidacuenta.comprobante_correlativo ? 
                        adelanto.salidacuenta.comprobante_correlativo : 
                        '001-IN-' + adelanto.id}
            </span>
                                        </div>
                                    `);
                                });
                            } else {
                                container.append(
                                    '<p>No hay adelantos activos para esta sociedad.</p>');
                            }
                        }
                    });
                } else {
                    $('#checkbox_adelantos_container').empty(); // Clear if no sociedad is selected
                }
            });
        });

        function get_soles_from_dolares(dolares, tipocambio) {
            return (dolares * tipocambio).toFixed(2);
        }

        function get_dolares_from_soles(soles, tipocambio) {
            return Math.round((soles / tipocambio) * 100) / 100;
        }

        function discountadelantos(liquidacion, descuentos_por_adelantos) {
            return (liquidacion - descuentos_por_adelantos).toFixed(2);
        }

        function discountothers(ultimomonto, otrodescuento) {
            return (ultimomonto - otrodescuento).toFixed(2);
        }

        function update_with_detraccion() {

            const isChecked = document.getElementById('cbx-12').checked;
            
            let importe_total_dolares = isNaN(parseFloat($('#importe_total_dolares').val())) ? 0 : parseFloat(
                $('#importe_total_dolares').val());

            let importe_total_soles = isNaN(parseFloat($('#importe_total_soles').val())) ? 0 : parseFloat(
                $('#importe_total_soles').val());

            if (isChecked) {
                if (importe_total_dolares) {
                    let con_detraccion = importe_total_dolares;
                    importe_total_dolares = 0.9 * con_detraccion;
                    $('#detraccion_dolares').val(con_detraccion);
                    $('#importe_total_dolares').val(importe_total_dolares); // Set the result in the #total field
                } else {
                    $('#detraccion_dolares').val('');

                    $('#importe_total_dolares').val(''); // Clear the total field if inputs are not valid
                }





                if (importe_total_soles) {
                    let con_detraccion = importe_total_soles;
                    importe_total_soles = 0.9 * con_detraccion;
                    $('#detraccion_soles').val(con_detraccion);
                    $('#importe_total_soles').val(importe_total_soles); // Set the result in the #total field
                } else {
                    $('#detraccion_dolares').val('');

                    $('#importe_total_soles').val(''); // Clear the total field if inputs are not valid
                }

            }




        }


        function makebothdiscounts() { //SE CALCULA EN CASO SE INGRESE UN VALOR EN TIPO CAMBIO, EN EL CAMPO PARA EL TOTAL EN DOLARES, O EN EL CAMPO OTROS DESCUENTOS
            var liq_dolares = parseFloat($('#dolares')
                .val()); // SE OBTIENE EL TOTAL DEL HTML Y SE CONVIERTE A FLOAT
            var descuento_por_adelantos_dolares = isNaN(parseFloat($('#descuento_dolares').val())) ? 0 : parseFloat(
                $(
                    '#descuento_dolares').val());

            var otros_descuentos_dolares = isNaN(parseFloat($('#otros_descuentos_dolares').val())) ? 0 : parseFloat(
                $(
                    '#otros_descuentos_dolares').val());

            const isChecked = document.getElementById('cbx-12').checked;

            if (liq_dolares) {
                var total_dolares = discountadelantos(liq_dolares, descuento_por_adelantos_dolares);
                if (otros_descuentos_dolares) {

                    if(isChecked){
                        total_dolares = 0.9 * total_dolares
                    }

                    

                    total_dolares = discountothers(total_dolares, otros_descuentos_dolares)
                }
                $('#importe_total_dolares').val(total_dolares); // Set the result in the #total field
            } else {
                $('#importe_total_dolares').val(''); // Clear the total field if inputs are not valid
            }
            var liq_soles = parseFloat($('#soles').val()); // Convert to a float
            var descuento_por_adelantos_soles = isNaN(parseFloat($('#descuento_soles').val())) ? 0 : parseFloat($(
                '#descuento_soles').val());
            var otros_descuentos_soles = isNaN(parseFloat($('#otros_descuentos_soles').val())) ? 0 : parseFloat($(
                '#otros_descuentos_soles').val());


            if (liq_soles) {
                var total_soles = discountadelantos(liq_soles, descuento_por_adelantos_soles);
                if (otros_descuentos_soles) {
                    if(isChecked){
                        total_soles = 0.9 * total_soles
                    } 

                    total_soles = discountothers(total_soles, otros_descuentos_soles)
                }
                $('#importe_total_soles').val(total_soles); // Set the result in the #total field
            } else {
                $('#importe_total_soles').val(''); // Clear the total field if inputs are not valid
            }

        }




        //
        function reset_detraccion() {}
        //FUNCIÓN PARA CONVERTIR LIQUIDACIÓN EN DOLARES A SOLES
        $(document).on("input", '#tipocambio, #dolares', function() {
            var tipocambio = parseFloat($('#tipocambio').val()); // Convert to a float
            var dolares = parseFloat($('#dolares').val()); // Convert to a float

            if (dolares && tipocambio && !isNaN(tipocambio) && !isNaN(dolares)) {
                var total = get_soles_from_dolares(dolares, tipocambio); // Multiply and format to 2 decimal places
                $('#soles').val(total); // Set the result in the #total field
            } else {
                $('#soles').val(''); // Clear the total field if inputs are not valid
            }
        });
        //FUNCIÓN PARA CONVERTIR LIQUIDACIÓN EN SOLES A DOLARES
        $(document).on("input", '#tipocambio, #soles', function() {
            var tipocambio = parseFloat($('#tipocambio').val()); // Convert to a float
            var soles = parseFloat($('#soles').val()); // Convert to a float

            if (soles && tipocambio && !isNaN(tipocambio) && !isNaN(soles)) {
                var total = get_dolares_from_soles(soles, tipocambio); // Multiply and format to 2 decimal places
                $('#dolares').val(total); // Set the result in the #total field
            } else {
                $('#dolares').val(''); // Clear the total field if inputs are not valid
            }
        });
        //FUNCIÓN PARA CONVERTIR EN SOLES OTROS DESCUENTOS
        $(document).on("input", '#otros_descuentos_dolares, #tipocambio', function() {
            var tipocambio = parseFloat($('#tipocambio').val()); // Convert to a float
            var dolares = parseFloat($('#otros_descuentos_dolares').val()); // Convert to a float

            if (dolares && tipocambio && !isNaN(tipocambio) && !isNaN(dolares)) {
                var total = get_soles_from_dolares(dolares, tipocambio); // Multiply and format to 2 decimal places
                $('#otros_descuentos_soles').val(total); // Set the result in the #total field
            } else {
                $('#otros_descuentos_soles').val(''); // Clear the total field if inputs are not valid
            }
        });

        //FUNCIÓN PARA CONVERTIR EN DOLARES OTROS DESCUENTOS
        $(document).on("input", '#otros_descuentos_soles, #tipocambio', function() {
            var tipocambio = parseFloat($('#tipocambio').val()); // Convert to a float
            var soles = parseFloat($('#otros_descuentos_soles').val()); // Convert to a float

            if (soles && tipocambio && !isNaN(tipocambio) && !isNaN(soles)) {
                var total = get_dolares_from_soles(soles, tipocambio); // HACE LA CONVERSION DE SOLES A DOLARES

                $('#otros_descuentos_dolares').val(total); // Set the result in the #total field
            } else {
                $('#otros_descuentos_dolares').val(''); // Clear the total field if inputs are not valid
            }
        });

        //CALCULAR Y PASAR EL TOTAL DESPUES DE DESCONTAR LOS ADELANTOS
        $(document).on("input", '#tipocambio, #dolares, #soles,  #otros_descuentos_dolares, #otros_descuentos_soles ',
            function() {
                makebothdiscounts()
            });

        // ACTUALIZA EL CAMPO DE DESCUENTOS EN BASE A LOS CHECKBOXES SELECCIONADOS
        $(document).on('change', '#checkbox_adelantos_container input[type="checkbox"]', function() {
            var sum_dolares = 0; //INICIALIZA VARIABLE DE LA SUMA DE LOS ADELANTOS EN DOLARES
            var sum_soles = 0; //INICIALIZA VARIABLE DE LA SUMA DE LOS ADELANTOS EN SOLES
            $('#checkbox_adelantos_container input[type="checkbox"]:checked').each(
                function() { //EVENTO CUANDO SE SELECCIONA UN CHECKBOX
                    let adelantoId = $(this).val(); //OBTIENE EL ADELANTO QUE SE SELECCIONÓ
                    let adelanto = adelantos.find(a => a.id == adelantoId); //OBTIENE EL OBJETO
                    let tipocambio = adelanto.tipo_cambio;
                    let dol_monto; // INICIALIZA LA VARIABLE DEL MONTO DEL ADELANTO EN DOLARES
                    let sol_monto; // INICIALIZA LA VARIABLE DEL MONTO DEL ADELANTO EN SOLES
                    if (adelanto.salidacuenta.cuenta.tipomoneda.nombre == 'DOLARES') {
                        if (adelanto.total_sin_detraccion) {
                            //VERIFICA SI EL ADELANTO ES EN DOLARES
                            dol_monto = adelanto
                                .total_sin_detraccion //OBTIENE EL MONTO DEL ADELANTO EN DOLARES (EL MONTO ESTÁ EN REALIDAD ALMACENADO EN LA TABLA DE SALIDAS DE LAS CUENTAS, PERO EXISTE UNA RELACIÓN ENTRE LAS SALIDAS DE LAS CUENTAS Y LOS ADELANTOS)
                            sol_monto = get_soles_from_dolares(adelanto.total_sin_detraccion, tipocambio);
                        } else {

                            dol_monto = adelanto.salidacuenta
                                .monto //OBTIENE EL MONTO DEL ADELANTO EN DOLARES (EL MONTO ESTÁ EN REALIDAD ALMACENADO EN LA TABLA DE SALIDAS DE LAS CUENTAS, PERO EXISTE UNA RELACIÓN ENTRE LAS SALIDAS DE LAS CUENTAS Y LOS ADELANTOS)
                            sol_monto = get_soles_from_dolares(adelanto.salidacuenta.monto, tipocambio);
                        }

                    } else { // EN CASO EL ADELANTO SE HIZO DESDE LA CUENTA EN SOLES

                        if (adelanto.total_sin_detraccion) {
                            dol_monto = get_dolares_from_soles(adelanto.total_sin_detraccion, tipocambio);
                            sol_monto = adelanto.total_sin_detraccion; // EL MONTO EN SOLES ES EL MISMO
                        } else {

                            dol_monto = get_dolares_from_soles(adelanto.salidacuenta.monto, adelanto
                                .tipo_cambio);
                            sol_monto = adelanto.salidacuenta.monto // EL MONTO EN SOLES ES EL MISMO
                        }
                    }

                    if (adelanto) {
                        sum_dolares += parseFloat(dol_monto) ||
                            0; // SE SUMA AL TOTAL DEL DESCUENTO EN DOLARES EL MONTO EN DOLARES DEL ADELANTO
                        sum_soles += parseFloat(sol_monto) ||
                            0; // SE SUMA AL TOTAL DEL DESCUENTO EN SOLES EL MONTO EN SOLES DEL ADELANTO
                    }
                });

            $('#descuento_dolares').val(sum_dolares.toFixed(2)); //SE PASA LA SUMA AL  INPUT EN EL HTML
            $('#descuento_soles').val(sum_soles.toFixed(2)); //SE PASA LA SUMA AL  INPUT EN EL HTML

            makebothdiscounts()


        });

        function toggleDetraccionFields() {
            const isChecked = document.getElementById('cbx-12').checked;
            // Get the fields
            const dolaresField = document.getElementById('detraccionDolaresField');
            const solesField = document.getElementById('detraccionSolesField');
            const dolaresInput = document.getElementById('detraccion_dolares');
            const solesInput = document.getElementById('detraccion_soles');
            // Toggle display based on checkbox state
            dolaresField.style.display = isChecked ? 'block' : 'none';
            solesField.style.display = isChecked ? 'block' : 'none';
            // Toggle required attribute and enable/disable inputs based on checkbox and tipocambio value
            if (isChecked) {
                dolaresInput.setAttribute('required', 'required');
                solesInput.setAttribute('required', 'required');
                // Retrieve tipocambio value and check if it's valid


                dolaresInput.disabled = false; // Enable dolares input if tipocambio is valid
                solesInput.disabled = false; // Enable soles input if tipocambio is valid

                $('#otros_descuentos_dolares').val('');
                $('#otros_descuentos_soles').val('');

                update_with_detraccion()

            } else {
                // Remove required attribute and disable inputs when the checkbox is unchecked
                dolaresInput.removeAttribute('required');
                solesInput.removeAttribute('required');
                dolaresInput.disabled = true;
                solesInput.disabled = true;
                $('#otros_descuentos_dolares').val('');
                $('#otros_descuentos_soles').val('');

                makebothdiscounts()


            }
        }
        // Confirm dialog on form submit
        $('.create-liquidacion').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Crear Liquidación  ?',
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
        //FINDING DOCUMENTO REPRESENTANTE ADELLANTO FUNCTIONALITY
        $('#nombre').on('input', function(e) {
            e.preventDefault();
            let search_string = $(this).val();
            if (search_string.length >= 10) {
                $.ajax({
                    url: "{{ route('autocomp.representliquidacion') }}",
                    method: 'GET',
                    data: {
                        search_string: search_string
                    },
                    success: function(response) {

                        $('#documento').val(response.documento);

                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });

            }
        });
        //OBTIENE EL NOMBRE DE LA SOCIEDAD EN BASE AL CÓDIGO DE LA MISMA
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
                        $('#sociedad_nombre').val(response.sociedad.nombre);
                    } else {
                        // Handle error: product not found
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                }
            });
        });
        //API SUNAT Y RENIEC
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
@endsection
@endsection
