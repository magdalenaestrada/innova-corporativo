<div class="modal fade text-left" id="ModalExport"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REPORTE') }}
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
                <form class="crear-accion" action="{{ route('pesos.export-excel') }}" method="GET">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-12 g-3">
                            <label for="observacion" class="text-muted">
                                {{ __('OBSERVACIÓN') }}
                            </label>
                            <br>
                            <select name="Observacion" id="Observacion" class=" form-control buscador @error('Observacion') is-invalid @enderror" aria-label="" style="width: 100%">
                                <option selected disabled>
                                    Seleccione uno de las Observaciones listados
                                </option>
                                @php
                                    $observedPesos = [];
                                @endphp
                                @foreach ($pesos as $peso)
                                    @if (!in_array($peso->Observacion, $observedPesos))
                                        <option value="{{ $peso->Observacion }}" {{ old('peso') == $peso->Observacion ? 'selected' : '' }}>
                                            {{ $peso->Observacion }}
                                        </option>
                                        @php
                                            $observedPesos[] = $peso->Observacion;
                                        @endphp
                                    @endif
                                @endforeach
                            </select>
                            @error('peso')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                      



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



