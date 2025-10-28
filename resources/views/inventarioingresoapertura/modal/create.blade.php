<div class="modal fade text-left" id="ModalCreate" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('AÑADIR STOCK') }}
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
                <form class="crear-accion" action="{{ route('inventarioingresoapertura.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-6 g-3">
                            <label for="producto" class="text-sm">
                                {{ __('PRODUCTO') }}
                            </label>
                            <br>
                            <select name="producto" id="producto"
                                class=" form-control form-control-sm buscador @error('producto') is-invalid @enderror"
                                aria-label="" required style="width: 100%">
                                <option value="">
                                    Seleccione uno de los productos listados
                                </option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}"
                                        {{ old('producto') == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre_producto }}
                                    </option>
                                @endforeach
                            </select>
                            @error('producto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        <div class="form-group col-md-6 g-3">
                            <label for="stock" class="text-sm">
                                {{ __('STOCK') }}
                            </label>
                            <span class="text-danger">(*)</span>
                            <input type="number" required step="0.01" name="stock" id="stock"
                                class="form-control form-control-sm @error('stock') is-invalid @enderror"
                                value="{{ old('stock') }}" placeholder="Stock">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>






                        <div class="col-md-12 text-right g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('APERTURA DE PRODUCTO') }}
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
        $('.crear-producto').submit(function(e) {
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
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.buscador').select2({
                theme: "classic"
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
