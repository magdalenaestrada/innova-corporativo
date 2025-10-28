<div class="modal fade text-left" id="ModalCreate" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REGISTRAR DEVOLUCIÓN DE ADELANTO') }}
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
                <form class="create-ingresocuenta" action="{{ route('lqdevoluciones.store') }}" method="POST">
                    @csrf
                    <div class="row">






                        <div class="input-group form mb-1 col-md-4">
                            <input name="documento" id="documento" class="form-control form-control-sm"
                                placeholder="Documento de quien entrega..." type="text">
                            <span class="input-border"></span>
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
                                placeholder="Valide el nombre de quien entrega..." type="text">
                            <span class="input-border"></span>
                        </div>




                        <div class="form-group col-md-6 g-3">
                            <label for="tipo_comprobante" class="text-sm">
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


                        <div class="form col-md-6 mb-3 mt-4">
                            <input name="comprobante_correlativo" id="comprobante_correlativo"
                                class="form-control mt-1 form-control-sm"
                                placeholder="Ingrese el correlativo del comprobante" type="text">
                            <span class="input-border"></span>
                        </div>




                        <div class="form-group col-md-12 g-3">
                            <label for="cuenta" class="text-sm">
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


                        <div class="form-group col-md-12 g-3">
                            <label for="motivo" class="text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <select name="motivo_id" id="motivo"
                                class="form-control form-control-sm buscador @error('motivo') is-invalid @enderror"
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





                        <div class="form col-md-12 mb-3">
                            <label for="motivo" class="text-sm">
                                {{ __('DESCRIPICIÓN') }}
                            </label>
                            <input name="descripcion" id="descripcion" class="form-control form-control-sm"
                                placeholder="Ingrese la descripción" type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="form-group col-md-12 g-3">
                            <label for="cliente" class="text-sm">
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
                            @error('cliente')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group col-md-12 g-3">
                            <label for="sociedad" class="text-sm">
                                {{ __('SOCIEDAD') }}
                            </label>
                            <br>
                            <select name="sociedad_id" id="sociedad"
                                class="form-control form-control-sm buscador @error('sociedad') is-invalid @enderror"
                                aria-label="" style="width: 100%" required>
                                <option selected value="">
                                    Seleccione el sociedad
                                </option>
                                @foreach ($sociedades as $sociedad)
                                    <option value="{{ $sociedad->id }}"
                                        {{ old('sociedad') == $sociedad->id ? 'selected' : '' }}>
                                        {{ $sociedad->codigo }} - {{ $sociedad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sociedad')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-1" id="checkbox_adelantos_container"></div>



                        <div class="form col-md-6 mb-3">
                            <label for="fecha" class="text-sm">
                                {{ __('FECHA') }}
                            </label>
                            <input name="fecha" id="fecha" class="form-control form-control-sm"
                                placeholder="Ingrese la fecha" value="{{ date('Y-m-d') }}" type="date">
                            <span class="input-border"></span>
                        </div>

                        <div class="form col-md-6 mb-3">
                            <label for="monto" class="text-sm">
                                {{ __('MONTO') }}
                            </label>
                            <input name="monto" id="monto" class="form-control form-control-sm"
                                placeholder="Ingrese el monto" required="" type="text">
                            <span class="input-border"></span>
                        </div>








                        <div class="col-md-12 text-right g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('GUARDAR') }}
                            </button>
                        </div>
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
    </script>

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



        // Confirm dialog on form submit
        $('.create-ingresocuenta').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Crear Ingreso como Devolución?',
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
    </script>

    <script>
        $(document).ready(function() {
            // Hide the sociedad div by default
            $('#sociedad').closest('.form-group').hide();

            // Add event listener for cuenta selection
            $('#cuenta').on('change', function() {
                var cuentaValue = $(this).val();

                if (cuentaValue) {
                    // Show the sociedad div if cuenta is selected
                    $('#sociedad').closest('.form-group').show();
                    $('#checkbox_adelantos_container').show();
                } else {
                    // Hide the sociedad div if no cuenta is selected
                    $('#sociedad').closest('.form-group').hide();
                    $('#checkbox_adelantos_container').hide();
                }
            });
        });
    </script>


    <script>
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

                                container.append(`<h6 class="ml-1">ADELANTOS REGISTRADOS</h6>`)

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
    </script>


    <script>
        var adelantos = @json($adelantos);
        var cuentas = @json($cuentas);


        $(document).on('change', '#checkbox_adelantos_container input[type="checkbox"], #cuenta, #sociedad', function() {
                    let sum_dolares = 0;
                    let sum_soles = 0;
                    let cuenta_id = $('#cuenta').val();
                    let cuenta = cuentas.find(c => c.id == cuenta_id);
                    let tipomoneda = cuenta.tipomoneda.nombre;


                    $('#checkbox_adelantos_container input[type="checkbox"]:checked').each(
                        function() {

                            let dol_monto = 0;
                            let sol_monto = 0;
                            
                            var adelanto_id = $(this).val();

                            
                            let adelanto = adelantos.find(a => a.id == adelanto_id);



                            if (adelanto.salidacuenta.cuenta.tipomoneda.nombre == 'DOLARES') {


                                if (adelanto.total_sin_detraccion) {
                                    //VERIFICA SI EL ADELANTO ES EN DOLARES
                                    dol_monto = adelanto
                                        .total_sin_detraccion //OBTIENE EL MONTO DEL ADELANTO EN DOLARES (EL MONTO ESTÁ EN REALIDAD ALMACENADO EN LA TABLA DE SALIDAS DE LAS CUENTAS, PERO EXISTE UNA RELACIÓN ENTRE LAS SALIDAS DE LAS CUENTAS Y LOS ADELANTOS)
                                    sol_monto = adelanto.total_sin_detraccion * adelanto
                                        .tipo_cambio // HACE LA CONVERSION 
                                } else {

                                    dol_monto = adelanto.salidacuenta
                                        .monto //OBTIENE EL MONTO DEL ADELANTO EN DOLARES (EL MONTO ESTÁ EN REALIDAD ALMACENADO EN LA TABLA DE SALIDAS DE LAS CUENTAS, PERO EXISTE UNA RELACIÓN ENTRE LAS SALIDAS DE LAS CUENTAS Y LOS ADELANTOS)
                                    sol_monto = adelanto.salidacuenta.monto * adelanto
                                        .tipo_cambio // HACE LA CONVERSION 

                                }


                            } else { // EN CASO EL ADELANTO SE HIZO DESDE LA CUENTA EN SOLES

                                if (adelanto.total_sin_detraccion) {
                                    dol_monto = Math.round((adelanto.total_sin_detraccion / adelanto.tipo_cambio) *
                                            100) /
                                        100; // HACE LA CONVERSION DE SOLES A DOLARES
                                    sol_monto = adelanto.total_sin_detraccion // EL MONTO EN SOLES ES EL MISMO
                                } else {

                                    dol_monto = Math.round((adelanto.salidacuenta.monto / adelanto.tipo_cambio) * 100) /
                                        100; // HACE LA CONVERSION DE SOLES A DOLARES
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




                        if (tipomoneda == 'DOLARES') {
                            $('#monto').val(''); //SE PASA LA SUMA AL  INPUT EN EL HTML

                            $('#monto').val(sum_dolares.toFixed(2)); //SE PASA LA SUMA AL  INPUT EN EL HTML

                        } else {
                            $('#monto').val(''); //SE PASA LA SUMA AL  INPUT EN EL HTML

                            $('#monto').val(sum_soles.toFixed(2)); //SE PASA LA SUMA AL  INPUT EN EL HTML

                        }


                    });
    </script>











@endpush
