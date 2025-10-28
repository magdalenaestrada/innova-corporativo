<div class="modal fade text-left" id="ModalCreate" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CREAR CUENTA') }}
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
                <form class="crear-cuenta" action="{{ route('tscuentas.store') }}" method="POST">
                    @csrf
                    <div class="row">




                        <div class="form col-md-12 mb-3">
                            <input name="nombre" id="nombre" class="input form-control"
                                placeholder="Ingrese el nombre de la cuenta" required="" type="text">
                            <span class="input-border"></span>
                        </div>


                        <div class="form-group col-md-12 g-3">
                            <label for="tipo_moneda" class="text-muted">
                                {{ __('MONEDA') }}
                            </label>
                            <br>
                            <select name="tipo_moneda_id" id="tipo_moneda"
                                class=" form-control buscador @error('tipo_moneda') is-invalid @enderror" aria-label=""
                                style="width: 100%" required>
                                <option selected value="">
                                    Seleccione el tipo de moneda
                                </option>
                                @foreach ($tiposmonedas as $tipomoneda)
                                    <option value="{{ $tipomoneda->id }}"
                                        {{ old('tipomoneda') == $tipomoneda->id ? 'selected' : '' }}>
                                        {{ strtoupper($tipomoneda->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_moneda')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>




                        <div class="form-group col-md-12 g-3">
                            <label for="banco" class="text-muted">
                                {{ __('BANCO') }}
                            </label>
                            <br>
                            <select name="banco_id" id="banco"
                                class=" form-control buscador @error('banco') is-invalid @enderror" aria-label=""
                                style="width: 100%">
                                <option selected disabled>
                                    Seleccione al banco
                                </option>
                                @foreach ($bancos as $banco)
                                    <option value="{{ $banco->id }}"
                                        {{ old('banco') == $banco->id ? 'selected' : '' }}>
                                        {{ strtoupper($banco->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('banco')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>




                        <div class="form-group col-md-12 g-3">
                            <label for="encargado" class="text-muted">
                                {{ __('ENCARGADO') }}
                            </label>
                            <br>
                            <select name="encargado_id" id="encargado"
                                class=" form-control buscador2 @error('encargado') is-invalid @enderror" aria-label=""
                                style="width: 100%">
                                <option selected disabled>
                                    Seleccione al encargado
                                </option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->id }}"
                                        {{ old('empleado') == $empleado->id ? 'selected' : '' }}>
                                        {{ strtoupper($empleado->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('empleado')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>









                        <div class="col-md-12 text-right g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('CREAR CUENTA') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@push('js')


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
