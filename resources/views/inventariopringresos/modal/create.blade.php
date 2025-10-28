<div class="modal fade text-left" id="ModalCreate" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

                <div class="card-header ">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mt-2">
                                {{ __('CREAR PRESTAMO INGRESO') }}
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
                    <form method="POST" action="{{ route('inventarioprestamoingreso.store') }}">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
    
                                        <th>
                                            {{ __('PRODUCTO') }}
                                        </th>
    
                                        <th>
                                            {{ __('CANTIDAD') }}
                                        </th>
    
                                        <th>
                                            <button class="btn btn-outline-dark btn-sm" type="button"
                                                onclick="create_tr('table_body')" id="addMoreButton">
                                                <img style="width: 13px" src="{{ asset('images/icon/mas.png') }}"
                                                    alt="más">
                                            </button>
                                        </th>
    
                                    </tr>
                                </thead>
    
                                <tbody id="table_body">
                                    <tr>
                                        <td>
                                            <select name="products[]"
                                                class="form-control form-control-sm buscador cart-product"
                                                style="width: 450px" required>
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
                                            <input name="qty[]" required type="number" step="0.00" placeholder="0.00"
                                                class="form-control form-control-sm product-qty" value="1"
                                                style="max-width: 100px">
                                        </td>
    
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="remove_tr(this)"
                                                type="button">Quitar</button>
    
                                        </td>
                                    </tr>
                                </tbody>
    
    
    
    
    
                            </table>
                        </div>
                    

                        <!-- For doc table -->
                        <div class="row my-3">

                            <div class="form-group col-md-4 g-3">
                                <label for="documento_responsable" class="text-sm">
                                    {{ __('DOCUMENTO RESPONSABLE') }}
                                </label>
                                <span class="text-danger">(*)</span>

                                <div class="input-group">
                                    <input type="text" required name="documento_responsable"
                                        id="documento_responsable"
                                        class="form-control form-control-sm @error('documento_responsable') is-invalid @enderror"
                                        value="{{ old('documento_responsable') }}" placeholder="INGRESE DNI">
                                    <button class="btn btn-sm btn-primary" type="button" id="buscar_responsable_btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 25 25"
                                            style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                            <path
                                                d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                @error('documento_responsable')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-8 g-3">
                                <label for="nombre_responsable" class="text-sm">
                                    {{ __('NOMBRE RESPONSABLE') }}
                                </label>
                                <span class="text-danger">(*)</span>

                                <div class="input-field">

                                    <input type="text" required name="nombre_responsable" id="nombre_responsable"
                                        class="form-control form-control-sm @error('nombre_responsable') is-invalid @enderror"
                                        value="{{ old('nombre_responsable') }}"
                                        placeholder="Datos obtenidos automáticamente...">
                                </div>
                                @error('nombre_responsable')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="form-group col-md-5 g-3">
                                <label for="destino" class="text-sm">
                                    {{ __('ORIGEN') }}
                                </label>
                                <span class="text-danger">(*)</span>

                                <div class="input-field">
                                    <input required type="text" name="origen" id="destino"
                                        class="form-control form-control-sm @error('destino') is-invalid @enderror"
                                        placeholder="Area solicitante del requerimiento...">
                                </div>

                                @error('destino')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>




                            <div class="form-group col-md-4 g-3 mb-3">
                                <label for="condicion" class="text-sm">
                                    {{ __('CONDICIÓN') }}
                                </label>
                                <span class="text-danger">(*)</span>


                                <select name="condicion" id="condicion"
                                    class="form-control form-control-sm @error('condicion') is-invalid @enderror" aria-label="" required>
                                    <option value="">{{ __('-- Seleccione una opción') }}</option>

                                    <option value="CON DEVOLUCIÓN"
                                        {{ old('condicion') == 'CON DEVOLUCIÓN' ? 'selected' : '' }}>
                                        CON DEVOLUCIÓN
                                    </option>
                                    <option value="SIN DEVOLUCIÓN"
                                        {{ old('condicion') == 'SIN DEVOLUCIÓN' ? 'selected' : '' }}>
                                        SIN DEVOLUCIÓN
                                    </option>
                                </select>
                            </div>


                            <div class="form-group col-md-12 g-3">
                                <label for="observacion" class="text-sm">
                                    {{ __('OBSERVACIÓN') }}
                                </label>
                                <span class="text-danger">(*)</span>

                                <textarea required name="observacion" id="observacion" class="form-control form-control-sm @error('observacion') is-invalid @enderror"
                                    placeholder="Ingrese una observación o comentario...">{{ old('observacion') }}</textarea>
                                @error('observacion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>





                        </div>

                        <div class=" mt-3 text-right">

                            <button class="btn btn-sm btn-secondary pull-right" type="submit"
                                id="saveOrder">Guardar</button>
                        </div>
                    </form>

            

        </div>
    </div>
</div>
</div>

@push('js')
    <script src="{{ asset('js/interactive.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.buscador').select2({
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










@endpush
