<div class="modal fade text-left" id="ModalExport" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REPORTE DE CAJA') }}
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
                <form class="crear-accion" action="{{ route('tsmiscajas.export-excel') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 g-3">
                            <label for="caja" class="text-muted">{{ __('CAJA') }}</label>
                            <select name="caja_id" id="caja5" required
                                class="form-control buscador @error('caja') is-invalid @enderror" style="width: 100%">
                                <option selected value="">Seleccione la caja</option>
                                @foreach ($cajas as $caja)
                                    <option value="{{ $caja->id }}"
                                        {{ old('caja') == $caja->id ? 'selected' : '' }}>
                                        {{ $caja->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 g-3" id="reposiciones-container" style="display: none;">
                            <label for="reposicion" class="text-muted">{{ __('REPOSICIÓN') }}</label>
                            <select required name="reposicion_id" id="reposicion5" class="form-control buscador"
                                style="width: 100%">
                                <option selected value="">Seleccione la reposición</option>
                            </select>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('#caja5').on('change', function() {
            let cajaId = $(this).val();

            if (cajaId) {
                $.ajax({
                    url: "{{ route('get.reposiciones') }}",
                    type: 'GET',
                    data: {
                        cajaId: cajaId
                    },
                    success: function(data) {
                        $('#reposicion5').empty().append(
                            '<option value="">Seleccione la reposición</option>');



                        $.each(data, function(index, reposicion) {

                            const fecha = new Date(reposicion.created_at);
                            const formattedDate =
                                `${fecha.getFullYear()}/${(fecha.getMonth() + 1).toString().padStart(2, '0')}/${fecha.getDate().toString().padStart(2, '0')}`;

                            $('#reposicion5').append(
                                `<option value="${reposicion.id}">${reposicion.id} - ${formattedDate} MONTO: S/. ${reposicion.salidacuenta.monto}</option>`
                            );

                        });
                        $('#reposiciones-container').show();
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo cargar las reposiciones para esta caja.'
                        });
                    }
                });
            } else {
                $('#reposicion5').empty().append('<option value="">Seleccione la reposición</option>');
                $('#reposiciones-container').hide();
            }
        });



        // Display validation errors with SweetAlert
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                html: '@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach',
            });
        @endif
    </script>
@endpush
