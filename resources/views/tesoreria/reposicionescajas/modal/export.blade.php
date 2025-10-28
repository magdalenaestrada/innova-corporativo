<div class="modal fade text-left" id="ModalExport"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REPORTE REPOSICIONES DE LAS CAJAS') }}
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
                <form class="crear-accion" action="{{ route('tsreposicionescajas.export-excel') }}" method="GET">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-6 g-3">
                            <label for="tipo_comprobante" class="text-muted">
                                {{ __('TIPO DE COMPROBANTE') }}
                            </label>
                            <br>
                            <select name="tipo_comprobante_id" id="tipo_comprobante1" class="form-control buscador @error('tipo_comprobante') is-invalid @enderror" aria-label="" style="width: 100%" >
                                <option value="">
                                    Seleccione el tipo de comprobante
                                </option>
                                @foreach ($tiposcomprobantes as $tipocomprobante)
                                    <option value="{{ $tipocomprobante->id }}" {{ old('banco') == $tipocomprobante->id ? 'selected' : '' }}>
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

                        <div class="form-group col-md-6 g-3">
                            <label for="motivo" class="text-muted">
                                {{ __('MOTIVO') }}
                            </label>
                            <br>
                            <select name="motivo_id" id="motivo2" class="form-control buscador @error('motivo1') is-invalid @enderror" aria-label="" style="width: 100%" >
                                <option selected value="">
                                    Seleccione el motivo
                                </option>
                                @foreach ($motivos as $motivo)
                                    <option value="{{ $motivo->id }}" {{ old('motivo') == $motivo->id ? 'selected' : '' }}>
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


                        <div class="form-group col-md-6 g-3">
                            <label for="caja" class="text-muted">
                                {{ __('CAJA') }}
                            </label>
                            <br>
                            <select name="caja_id" id="caja1" class="form-control buscador @error('caja') is-invalid @enderror" aria-label="" style="width: 100%" >
                                <option selected value="">
                                    Seleccione la caja
                                </option>
                                @foreach ($cajas as $caja)
                                    <option value="{{ $caja->id }}" {{ old('caja') == $caja->id ? 'selected' : '' }}>
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



                      
                        <div class="col-md-6"></div>


                        <div class="form-group col-md-6 g-3">
                            <label for="start_date" class="text-muted">
                                {{ __('FECHA INICIAL') }}
                            </label>
                            <input type="datetime-local" name="start_date" placeholder="Ingrese la fecha Inicial"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="end_date" class="text-muted">
                                {{ __('FECHA FINAL') }}
                            </label>
                            <input type="datetime-local" name="end_date" placeholder="Ingrese la fecha Final"
                                class="form-control">
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
            $('.crear-producto').submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Crear producto?',
                    icon: 'warning',
                    ShowCancelButton: true,
                    ConfirmButtonColor: '#3085d6',
                    CancelButtonColor: '#d33',
                    ConfirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        this.submit();
                    }
                })
            });
</script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    
    
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
