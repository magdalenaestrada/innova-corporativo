@extends('layouts.app')

@section('content')
<div class="container">
        
        <div class="card">

            <div class="card-header ">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CREAR PRESTAMO SALIDA') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('inventarioprestamosalida.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
                
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('inventarioprestamosalida.store') }}">
                    @csrf
                    <div class="row justify-content-between  mb-3" id="taskFormContainer">



                        <div class="col-md-3 text-center">
                            {{ __('PRODUCTO') }}
                        </div>
                        
                        <div class="col-md-3 ">
                            {{ __('CANTIDAD') }}
                        </div>
                        
                        <div class="col-md-2">
                            <button class="btn  btn-primary pull-right" type="button" id="addMoreButton">AÑADIR MÁS</button>
                        </div>


                    </div>

                    <div class="product-box-extra" id="itemsInOrder">

                    </div>

                    <div class="product-box hidden">
                        <div class="row product-item justify-content-between m-4">

                            <div class="col-md-3 text-center">
                                <select name="products[]" class="form-control cart-product" style="max-width: 250px">
                                    <option selected disabled>{{ __('-- Seleccione una opción') }}</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}"
                                            {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                            {{ $producto->nombre_producto }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            
                            <div class="col-md-3 text-center">
                                <input name="qty[]" type="number" step="0.01"  placeholder=""
                                    class="form-control product-qty" value="1" style="max-width: 100px">
                            </div>
                            

                            <div class="col-md-2 text-center">
                                <button class="btn btn btn-danger pull-right remove-row" type="button">Quitar</button>
                            </div>
                        </div>
                    </div>


                    



                    




                    <!-- For doc table -->
                    <div class="row my-3">

                        <div class="form-group col-md-4 g-3">
                            <label for="documento_responsable" class="text-success">
                                {{ __('DOCUMENTO RESPONSABLE') }}
                            </label>
                            <div class="input-group">
                                <input type="text" name="documento_responsable" id="documento_responsable"
                                    class="form-control @error('documento_responsable') is-invalid @enderror"
                                    value="{{ old('documento_responsable') }}" placeholder="INGRESE DNI">
                                <button class="btn btn-primary" type="button" id="buscar_responsable_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
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
                            <label for="nombre_responsable class="text-muted">
                                {{ __('NOMBRE RESPONSABLE') }}
                            </label>
                            <div class="input-field">

                                <input type="text" name="nombre_responsable" id="nombre_responsable"
                                    class="form-control @error('nombre_responsable') is-invalid @enderror"
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
                            <label for="destino" class="text-muted">
                                {{ __('DESTINO') }}
                            </label>
                            <div class="input-field">
                                <input type="text" name="destino" id="destino"
                                    class="form-control @error('destino') is-invalid @enderror"
                                    placeholder="Area solicitante del requerimiento...">
                            </div>

                            @error('destino')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        
                    <div class="form-group col-md-3 g-3 mb-3">
                        <label for="condicion">
                            {{ __('CONDICIÓN') }}
                        </label>

                        <select name="condicion" id="condicion"
                            class="form-select @error('condicion') is-invalid @enderror" aria-label="">
                            <option selected disabled>{{ __('-- Seleccione una opción') }}</option>

                            <option value="CON DEVOLUCIÓN" {{ old('condicion') == 'CON DEVOLUCIÓN' ? 'selected' : '' }}>
                                CON DEVOLUCIÓN
                            </option>
                            <option value="SIN DEVOLUCIÓN" {{ old('condicion') == 'SIN DEVOLUCIÓN' ? 'selected' : '' }}>
                                SIN DEVOLUCIÓN
                            </option>
                        </select>
                    </div>


                    <div class="form-group col-md-12 g-3">
                        <label for="observacion" >
                            {{ __('OBSERVACIÓN') }}
                        </label>
                        <textarea name="observacion" id="observacion" class="form-control @error('observacion') is-invalid @enderror"
                            placeholder="Ingrese una observación o comentario...">{{ old('observacion') }}</textarea>
                        @error('observacion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                        


                    </div>
                        
                                 
                                                        




                        <div class=" mt-3 text-end">

                            <button class="btn btn btn-primary pull-right" type="submit" id="saveOrder">Guardar</button>
                        </div>
                    </div>
                </form>

            </div>







        </div>
</div>

@push('js')
    <script src="http://localhost/innova-app/public/js/packages/jquery.min.js"></script>
    <script>
            $("#addMoreButton").click(function() {
                var row = $(".product-box").html();
                $(".product-box-extra").append(row);
                $(".product-box-extra .remove-row").last().removeClass('hideit');
                $(".product-box-extra .product-price").last().text('0.0');
                $(".product-box-extra .product-qty").last().val('1');
                $(".product-box-extra .product-total").last().text('0.0');
            });

            $(document).on("click", ".remove-row", function() {
                $(this).closest('.row').remove();
            });
                       
    </script>
@endpush
@endsection
