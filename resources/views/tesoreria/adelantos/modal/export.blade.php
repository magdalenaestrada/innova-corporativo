<div class="modal fade text-left" id="ModalExport" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REPORTE DE LOS ADELANTOS A LOS CLIENTES') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                            <img style="width: 15px" src="{{ asset('images/icon/close.png') }}" alt="cerrar">
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="crear-accion" action="{{ route('lqadelantos.export-excel') }}" method="GET">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-6 g-3">
                            <label for="sociedad" class="text-sm">
                                {{ __('SOCIEDAD') }}
                            </label>
                            <br>
                            <select name="sociedad_id" id="sociedad2" class="form-control buscador @error('sociedad') is-invalid @enderror" aria-label="" style="width: 100%" onchange="this.value = this.value.toUpperCase();">
                                <option selected value="">
                                    Seleccione la sociedad
                                </option>
                                @foreach ($sociedades as $sociedad)
                                    <option value="{{ $sociedad->id }}" {{ old('sociedad') == $sociedad->id ? 'selected' : '' }}>
                                        {{ strtoupper($sociedad->codigo) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipocomprobante')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form col-md-6  mb-3" style="margin-top: 30px ">
                            <input name="sociedad_nombre" id="sociedad_nombre1" class=" form-control form-control-sm" placeholder="Nombre de la sociedad" disabled type="text" style="text-transform: uppercase;">
                            <span class="input-border"></span>
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="tipo_comprobante" class="text-sm">
                                {{ __('TIPO DE COMPROBANTE') }}
                            </label>
                            <br>
                            <select name="tipo_comprobante_id" id="tipo_comprobante2" class="form-control buscador @error('tipo_comprobante') is-invalid @enderror" aria-label="" style="width: 100%" onchange="this.value = this.value.toUpperCase();">
                                <option value="">
                                    Seleccione el tipo de comprobante
                                </option>
                                @foreach ($tiposcomprobantes as $tipocomprobante)
                                    <option value="{{ $tipocomprobante->id }}" {{ old('banco') == $tipocomprobante->id ? 'selected' : '' }}>
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

                        <div class="col-md-6"></div>

                        <div class="form-group col-md-6 g-3">
                            <label for="start_date" class="text-sm">
                                {{ __('FECHA INICIAL') }}
                            </label>
                            <input type="datetime-local" name="start_date" placeholder="Ingrese la fecha Inicial" class="form-control form-control-sm" style="text-transform: uppercase;">
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="end_date" class="text-sm">
                                {{ __('FECHA FINAL') }}
                            </label>
                            <input type="datetime-local" name="end_date" placeholder="Ingrese la fecha Final" class="form-control form-control-sm" style="text-transform: uppercase;">
                        </div>

                        <div class="col-md-12 text-right g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('EXPORTAR REPORTE') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@push('js')
<script>
    // Enforce uppercase input for sociedad_nombre
    $('#sociedad2').on('input', function() {
        var sociedad = $(this).val();
        var url = "{{ route('get.sociedad.nombre.by.code', ['sociedad' => ':sociedad']) }}";
        url = url.replace(':sociedad', sociedad);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#sociedad_nombre1').val(response.sociedad.nombre.toUpperCase());
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
        $('.buscador').select2({theme: "classic"});
    });
</script>

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error de validación',
            html: '@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach',
        });
    </script>
@endif
@endpush
