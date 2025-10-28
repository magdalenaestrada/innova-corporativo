<div class="modal fade text-left" id="ModalCreate"   role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mt-2">
                                {{ __('CREAR SALIDA RÁPIDA') }}
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
                    <form method="POST" action="{{ route('invsalidasrapidas.store') }}">
                        @csrf
                        <div class="table-responsive">
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
                                        <button class="btn btn-sm btn-outline-dark pull-right" type="button" onclick="create_tr('table_body')" id="addMoreButton">
                                            <img style="width: 13px" src="{{ asset('images/icon/mas.png') }}" alt="más">
                                        </button>
                                    </th>
        
        
                                </tr>
                                </thead>
        
                                <tbody id="table_body">
                                    <tr>
                                        
                                        <td>
                                            <select name="products[]" class="form-control   buscador cart-product"
                                                style="width: 240px; height:30px" required>
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
                                            <input name="qty[]" type="text"  required
                                            class="form-control form-control-sm product-qty" placeholder="0.0" >
                                        </td>
                                        <td>
                                            <input name="unidad[]"  required
                                            class="form-control form-control-sm product-unidad" disabled placeholder="" >
                                        </td>
                                    
                                                        
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="remove_tr(this)" type="button">Quitar</button>
        
                                        </td>
                                    </tr>
                                </tbody>
                                            
                            </table>
                        </div>
                        
                                                            
                        <div class="row mb-3">
                            <div class="form-group col-md-4 g-3">
                                <label for="documento_solicitante" class="text-sm">
                                    {{ __('DNI SOLICITANTE') }}
                                </label>
                                <span class="text-danger">(*)</span>
                                <div class="input-group">
                                    <input type="text" required name="documento_solicitante" id="documento_solicitante"
                                        class="form-control form-control-sm @error('documento_solicitante') is-invalid @enderror"
                                        value="{{ old('documento_solicitante') }}" placeholder="Ingrese documento...">
                                    <button class="btn btn-sm btn-primary" type="button" id="buscar_solicitante_btn">
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
                                    {{ __('NOMBRE DEL SOLICITANTE') }}
                                </label>
                                <span class="text-danger">(*)</span>
                                <input type="text" required name="nombre_solicitante" id="nombre_solicitante"
                                    class="form-control form-control-sm @error('nombre_solicitante') is-invalid @enderror"
                                    value="{{ old('nombre_solicitante') }}" placeholder="Datos obtenidos automáticamente...">
                                @error('datos_proveedor')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>             
                        <div class="row">
                            

                                <div class="form-group col-md-6 g-3 mb-3">
                                    <label for="destino	" class="text-sm">
                                                {{ __('DESTINO') }}
                                    </label>
                                    <span class="text-danger">(*)</span>
                                    <input required type="text" step="0.01" name="destino" id="stock" class="form-control form-control-sm @error('destino') is-invalid @enderror" value="{{ old('destino') }}" placeholder="Destino...">
                                    @error('destino')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 g-3 mb-3" id="tipo_comprobante_especifico_group" style="display:none;">
                                    <label for="tipo_comprobante_especifico">
                                        {{ __('TIPO COMPROBANTE ESPECIFICO') }}
                                    </label>
                                    <span class="text-danger">(*)</span>
                                    <input type="text" name="tipo_comprobante_especifico" id="tipo_comprobante_especifico" class="form-control">
                                    @error('tipo_comprobante_especifico')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                
                        </div>
                        

                        <div class="d-flex justify-content-end align-items-center mt-2">
                        
                            
                

                                <button class="btn btn-sm btn-secondary pull-right" type="submit" id="saveOrder">Guardar</button>

                        </div>
                    </form>

                </div>
        </div>
    </div>
</div>






