<div class="modal fade text-left" id="ModalCreate" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REGISTRAR REPOSICIÓN DE CAJA') }}
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
                <form class="crear-reposicion" action="{{ route('tsreposicionescajas.store') }}" method="POST">
                    @csrf
                    <div class="row">

                       

                        <div class="form-group col-md-6 g-3">
                            <label for="caja" class="text-sm">
                                {{ __('CAJA') }}
                            </label>
                            <br>
                            <select name="caja_id" id="caja"
                                class=" form-control form-control-sm buscador @error('caja') is-invalid @enderror"
                                aria-label="" style="width: 100%" required="">
                                <option value="">
                                    Seleccione la caja
                                </option>
                                @foreach ($cajas as $caja)
                                    <option value="{{ $caja->id }}"
                                        {{ old('caja') == $caja->id ? 'selected' : '' }}>
                                        {{ $caja->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('caja')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="cuenta_procedencia" class="text-sm">
                                {{ __('CUENTA DE PROCEDENCIA') }}
                            </label>
                            <br>
                            <select name="cuenta_procedencia_id" id="cuenta_procedencia"
                                class=" form-control form-control-sm buscador @error('cuenta_procedencia') is-invalid @enderror"
                                aria-label="" style="width: 100%" required="">
                                <option value="">
                                    Seleccione la cuenta de procedencia
                                </option>
                                @foreach ($cuentas as $cuenta)
                                    @if ($cuenta->tipomoneda->nombre == 'SOLES')
                                        <option value="{{ $cuenta->id }}"
                                            {{ old('cuenta_procedencia') == $cuenta->id ? 'selected' : '' }}>
                                            {{ $cuenta->nombre }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('cuenta_procedencia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="tipo_comprobante" class="text-sm">
                                {{ __('TIPO DE COMPROBANTE') }}
                            </label>
                            <br>
                            <select name="tipo_comprobante_id" id="tipo_comprobante"
                                class=" form-control form-control-sm buscador @error('tipo_comprobante') is-invalid @enderror"
                                aria-label="" style="width: 100%">
                                <option value="">
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

                        <div class="form col-md-6 mb-3" style="margin-top: 30px">
                            <input name="comprobante_correlativo" id="comprobante_correlativo"
                                class="form-control form-control-sm"
                                placeholder="Ingrese el correlativo del comprobante" type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="form-group col-md-12 g-3 ">
                            <label for="motivo" class="text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <select name="motivo_id" id="motivo"
                                class=" form-control form-control-sm buscador @error('cuenta') is-invalid @enderror"
                                aria-label="" style="width: 100%" required="">
                                <option selected value="">
                                    Seleccione el motivo
                                </option>
                                @foreach ($motivos as $motivo)
                                    <option value="{{ $motivo->id }}"
                                        {{ old('cuenta') == $motivo->id ? 'selected' : '' }}>
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
                            <input name="descripcion" id="descripcion" class=" form-control form-control-sm"
                                placeholder="Ingrese la descripción" type="text">
                            <span class="input-border"></span>
                        </div>

                        <div class="form col-md-12 mb-3">
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

                // Realizar la solicitud AJAX al controlador
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        documento: inputValue,
                        tipo_documento: tipoDocumento
                    },
                    success: function(response) {
                        console.log('1', 'API Response:', response);
                        // Manejar la respuesta del controlador
                        if (tipoDocumento === 'dni') {
                            $(datosId).val(response.nombres + ' ' + response.apellidoPaterno + ' ' +
                                response.apellidoMaterno);
                        } else {
                            $(datosId).val(response.razonSocial);
                        }

                        $(datosId).removeClass('is-invalid').addClass('is-valid');
                    },
                    error: function(xhr, status, error) {
                        // Manejar el error de la solicitud
                        console.log('3', xhr.responseText);
                        $(datosId).val('');
                        $(datosId).removeClass('is-valid').addClass('is-invalid');
                    }
                });
            }

            $('#documento').on('input', function() {
                var inputLength = $(this).val().length;
                if (inputLength === 8 || inputLength === 11) {
                    buscarDocumento('{{ route('buscar.documento') }}', '#documento', '#nombre');
                }
            });



            // Validar ruc o dni y cambiar el borde a verde al llenar los campos
            $('#documento').off('input').on('input', function() {
                var inputLength = $(this).val().length;
                if (inputLength === 8 || inputLength === 11) {
                    buscarDocumento('{{ route('buscar.documento') }}', '#documento', '#nombre');
                }
            });

            // Cambiar el borde a verde cuando se llenen los campos datos_cliente
            $('.datos-input').on('input', function() {
                var value = $(this).val();
                $(this).toggleClass('is-valid', value.trim().length > 0);
                $(this).toggleClass('is-invalid', value.trim().length === 0);
            });
        });




        $('.crear-reposicion').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Crear Reposición de la caja?',
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
