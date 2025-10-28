<div class="modal fade text-left" id="ModalExport" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('REPORTE DE SALIDAS RÁPIDAS') }}
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
                <form class="crear-accion" action="{{ route('invsalidarapida.export-excel') }}" method="GET">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-6 g-3">
                            <label for="destino" class="text-sm">
                                {{ __('DESTINO') }}
                            </label>
                            <br>
                            <select name="destino" id="destino"
                                class="form-control buscador @error('destino') is-invalid @enderror" aria-label=""
                                style="width: 100%">
                                <option value=''>
                                    Seleccione uno de los destinos listados
                                </option>
                                @php
                                    $destinos = [];
                                    foreach ($invsalidasrapidas as $invsalidarapida) {
                                        $destinos[] = $invsalidarapida->destino;
                                    }
                                    $destinos = array_unique($destinos); // Eliminar duplicados
                                    sort($destinos); // Ordenar alfabéticamente
                                @endphp
                                @foreach ($destinos as $destino)
                                    <option value="{{ $destino }}"
                                        {{ old('destino') == $destino ? 'selected' : '' }}>
                                        {{ $destino }}
                                    </option>
                                @endforeach
                            </select>
                            @error('destino')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="nombre_solicitante" class="text-sm">
                                {{ __('NOMBRE SOLICITANTE') }}
                            </label>
                            <br>
                            <select name="nombre_solicitante" id="nombre_solicitante"
                                class="form-control buscador @error('destino') is-invalid @enderror" aria-label=""
                                style="width: 100%">
                                <option value="">
                                    Seleccione uno de los solicitantes listados
                                </option>
                                @php
                                    $solicitantes = [];
                                    foreach ($invsalidasrapidas as $invsalidarapida) {
                                        $solicitantes[] = $invsalidarapida->nombre_solicitante;
                                    }
                                    $solicitantes = array_unique($solicitantes); // Eliminar duplicados
                                    sort($solicitantes); // Ordenar alfabéticamente
                                @endphp
                                @foreach ($solicitantes as $solicitante)
                                    <option value="{{ $solicitante }}"
                                        {{ old('solicitante') == $destino ? 'selected' : '' }}>
                                        {{ $solicitante }}
                                    </option>
                                @endforeach
                            </select>
                            @error('solicitante')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group col-md-6 g-3">
                            <label for="producto122" class="text-sm">
                                {{ __('PRODUCTO') }}
                            </label>
                            <br>
                            <select name="producto_id" id="producto1222"
                                class="form-control form-control-sm buscador @error('producto122') is-invalid @enderror"
                                aria-label="" style="width: 100%">
                                <option  value="">
                                    Seleccione el producto
                                </option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}"
                                        {{ old('producto122') == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre_producto }}
                                    </option>
                                @endforeach
                            </select>
                            @error('producto122')
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
                            <input type="datetime-local" name="start_date" placeholder="Ingrese la fecha Inicial"
                                class="form-control form-control-sm">
                        </div>

                        <div class="form-group col-md-6 g-3">
                            <label for="end_date" class="text-sm">
                                {{ __('FECHA FINAL') }}
                            </label>
                            <input type="datetime-local" name="end_date" placeholder="Ingrese la fecha Final"
                                class="form-control form-control-sm">
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
