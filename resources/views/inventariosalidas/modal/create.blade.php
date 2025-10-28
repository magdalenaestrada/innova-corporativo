<div class="modal fade text-left" id="ModalCreate" role="dialog" aria-hidden="true">        
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CREAR REQUERIMIENTO') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="button" style="font-size: 30px" class="close" data-dismiss="modal" aria-label="Close">
                            <img style="width: 15px" src="{{asset('images/icon/close.png')}}" alt="cerrar">    
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('inventariosalidas.store') }}">
                    @csrf


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
                                {{ __('UNIDAD') }}
                            </th>

                           
                            

                        
                            <th>
                                <button class="btn btn-sm btn-outline-dark" type="button" onclick="create_tr('table_body')" id="addMoreButton">
                                    <img style="width: 11px" src="{{asset('images/icon/mas.png')}}" alt="más">
                                </button>
                            </th>


                        </tr>
                        </thead>

                        <tbody id="table_body">
                            <tr>
                                <td>
                                    <select name="products[]" class="buscador form-control form-control-sm cart-product" style="width: 270px" required>
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
                                <input name="qty[]" type="number" step="0.00"  placeholder="0" required
                                class="form-control form-control-sm product-qty" value="1" style="max-width: 100px">
                                </td>
                                

                                
                                
                                <td>
                                        <input name="unidad[]" 
                                        class="form-control form-control-sm product-unidad" disabled placeholder="" >
                                </td>

                                


                               
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="remove_tr(this)" type="button">Quitar</button>

                                </td>
                            </tr>
                        </tbody>
                    

                    


                    </table>
                                          
    
                       


                    <!-- For doc table -->
                    <div class="row my-3">

                        <div class="form-group col-md-4 g-3">
                            <label for="documento_solicitante" class="text-sm">
                                {{ __('DOCUMENTO SOLICITANTE') }}
                            </label>
                            <span class="text-danger">(*)</span>

                            <div class="input-group">
                                <input type="text" required name="documento_solicitante" id="documento_solicitante"
                                    class="form-control form-control-sm @error('documento_solicitante') is-invalid @enderror"
                                    value="{{ old('documento_solicitante') }}" placeholder="Dni...  ">
                                <button class="btn btn-sm btn-success" type="button" id="buscar_solicitante_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                        <path
                                            d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('documento_solicitante')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-8 g-3">
                            <label for="nombre_solicitante" class="text-sm">
                                {{ __('NOMBRE SOLICITANTE') }}
                            </label>
                            <span class="text-danger">(*)</span>

                            <div class="input-field">

                                <input type="text" name="nombre_solicitante" required id="nombre_solicitante"
                                    class="form-control form-control-sm @error('nombre_solicitante') is-invalid @enderror"
                                    value="{{ old('nombre_solicitante') }}"
                                    placeholder="Datos obtenidos automáticamente...">
                            </div>
                            @error('datos_trabajador')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group col-md-4 g-3">
                            <label for="area_solicitante" class="text-sm" >
                                {{ __('AREA SOLICITANTE') }}
                            </label>
                            <span class="text-danger">(*)</span>

                            <div class="input-field">
                                <input type="text" name="area_solicitante" id="area_solicitante"
                                    class="form-control form-control-sm @error('area_solicitante') is-invalid @enderror"
                                    placeholder="Area solicitante del requerimiento..." required>
                            </div>

                            @error('area_solicitante')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-4  g-3">
                            <label for="prioridad" class="text-sm">
                                {{ __('PRIORIDAD') }}
                            </label>
                            <span class="text-danger">(*)</span>

                            <input type="text" name="prioridad" id="prioridad"
                                    class="form-control form-control-sm @error('prioridad') is-invalid @enderror"
                                    placeholder="Prioridad..." required>
                        </div>

                        <div class="form-group col-md-4 g-3">
                            <label for="codigo" class="text-sm" >
                                {{ __('CÓDIGO') }}
                            </label>
                            <span class="text-danger">(*)</span>

                            <div class="input-field">
                                <input type="text" name="codigo" id="codigo"
                                    class="form-control form-control-sm @error('codigo') is-invalid @enderror"
                                    placeholder="Codigo requerimiento..." required>
                            </div>

                            @error('codigo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                    </div>  
                                                            
                    <div class="form-group col-md-12 g-3">
                        <label for="descripcion" class="text-sm" >
                            {{ __('OBSERVACIÓN') }}
                        </label>
                        <textarea name="descripcion" id="descripcion" class="form-control form-control-sm @error('descripcion') is-invalid @enderror"
                            placeholder="De ser el caso, ingrese una descripción o comentario...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                                                
                        <div class="text-right mt-3">

                            <button class="btn btn-sm btn-secondary" type="submit" id="saveOrder">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@section('js')
    <script src="{{asset('js/interactive.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        @if (session('status'))
        Swal.fire('Éxito', '{{ session('status') }}', 'success');

        
        @elseif (session('error'))
        Swal.fire('Error', '{{ session('error') }}', 'error');
        @endif
    </script>


    <script>

        //llenar campos basado en el producto encontrado
                $(document).on("change", ".cart-product", function() {
                    var product = $(this).val();
                    var url = "{{ route('get.product-image.by.product', ['product' => ':product']) }}";
                    url = url.replace(':product', product);
                    var currentRow = $(this).closest('tr');

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                var product = response.product;
                                productImage = currentRow.find('.product-image');
                                productUnidad = currentRow.find('.product-unidad');
                                productImage.attr('src', product.image);
                                productUnidad.val(product.unidad.nombre);


                            } else {
                                // Handle error: product not found
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle AJAX errors
                        }
                    });
                });

    </script>


    <script>
        $(document).ready(function() {
                    $('.buscador').select2({theme: "classic"});
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

         
           

            

            $('#buscar_solicitante_btn').click(function() {
                buscarDocumento('{{ route('buscar.documento') }}', '#documento_solicitante',
                    '#nombre_solicitante');
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
@stop

