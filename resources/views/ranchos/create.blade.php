@extends('admin.layout')

@section('content')
<br>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CREAR TICKET DE COMEDOR') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-danger btn-sm" href="{{ route('ranchos.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="crear-rancho" action="{{ route('ranchos.store') }}" method="POST">
                    @csrf


                    <div class="row">




                        
                        <div class="form-group col-md-12 g-3">
                            <label for="datos_cliente" class="text-muted">
                                {{ __('NOMBRE CLIENTE') }}
                            </label>
                            <div class="input-field">
                                <input type="text" name="datos_cliente" id="datos_cliente"
                                    class="form-control @error('datos_cliente') is-invalid @enderror"
                                    placeholder="Datos obtenidos automáticamente...">
                            </div>

                            @error('datos_cliente')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        

                        <div class="form-group col-md-4 g-3">
                            <label for="documento_trabajador" class="text-success">
                                {{ __('DOCUMENTO COMENSAL') }}
                            </label>
                            <div class="input-group">
                                <input type="text" name="documento_trabajador" id="documento_trabajador"
                                    class="form-control @error('documento_trabajador') is-invalid @enderror"
                                    value="{{ old('documento_trabajador') }}" placeholder="INGRESE DNI O RUC">
                                <button class="btn btn-primary" type="button" id="buscar_trabajador_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 25 25" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                        <path
                                            d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @error('documento_trabajador')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-8 g-3">
                            <label for="datos_trabajador" class="text-muted">
                                {{ __('DATOS COMENSAL') }}
                            </label>
                            <div class="input-field">

                                <input type="text" name="datos_trabajador" id="datos_trabajador"
                                    class="form-control @error('datos_trabajador') is-invalid @enderror"
                                    value="{{ old('datos_trabajador') }}"
                                    placeholder="Datos obtenidos automáticamente...">
                            </div>
                            @error('datos_trabajador')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        <div class="form-group col-md-3 g-3 ">
                            <label for="lote" class="text-muted">
                                {{ __('LOTE') }}
                            </label>
                            <div class="input-field">

                                <input type="text" name="lote" id="lote"
                                    class="form-control @error('lote') is-invalid @enderror"
                                    value="{{ old('lote') }}"
                                    placeholder="Ingresar lote...">
                            </div>
                            @error('lote')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        

                        

                        <div class="form-group col-md-3 g-3">
                            <label for="cantidad" class="text-muted">
                                {{ __('CANTIDAD') }}
                            </label>
                            <input type="number" name="cantidad" id="cantidad"
                                class="form-control @error('cantidad') is-invalid @enderror"
                                value="{{ old('cantidad') }}" placeholder="0" min="0">
                            @error('cantidad')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group col-md-6 g-3">
                            <label for="comida" >
                                {{ __('COMIDA') }}
                            </label>
                            <br>
                            <select name="comida_id" id="comida"
                                class="form-control  buscador @error('sociedad') is-invalid @enderror"
                                aria-label="" style="width: 100%" required>
                                <option selected value="">
                                    SELECCIONE LA COMIDA
                                </option>
                                @foreach ($comidas as $comida)
                                    <option value="{{ $comida->id }}"
                                        {{ old('comida') == $comida->id ? 'selected' : '' }}>
                                        {{ strtoupper($comida->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('comida')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                      
                      



                        <div class="col-md-12 text-right g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('GUARDAR TICKET DE COMEDOR') }}
                            </button>
                        </div>

                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    @push('js')
        <script type="text/javascript">
            $(document).ready(function() {

                $.ajax({
                    type: 'get',
                    url: '{{ route('findPersona') }}',
                    success: function(response) {
                        console.log(response);

                        var custArray = response;
                        var dataCust = {};
                        var dataCust2 = {};
                        for (var i = 0; i < custArray.length; i++) {
                            dataCust[custArray[i].datos_persona] = null;
                            dataCust2[custArray[i].datos_persona] = custArray[i];
                        }
                        console.log("dataCust2");
                        console.log(dataCust2);


                        $('input#datos_cliente').autocomplete({
                            data: dataCust,
                            onAutocomplete: function(reqdata) {

                                $('#documento_cliente').val(dataCust2[reqdata][
                                    'documento_persona'
                                ]);
                            }
                        })
                    }
                })

                $.ajax({
                    type: 'get',
                    url: '{{ route('findPersona') }}',
                    success: function(response) {
                        console.log(response);

                        var custArray = response;
                        var dataCust = {};
                        var dataCust2 = {};
                        for (var i = 0; i < custArray.length; i++) {
                            dataCust[custArray[i].datos_persona] = null;
                            dataCust2[custArray[i].datos_persona] = custArray[i];
                        }
                        console.log("dataCust1");
                        console.log(dataCust2);


                        $('input#datos_socio').autocomplete({
                            data: dataCust,
                            onAutocomplete: function(reqdata) {

                                $('#documento_socio').val(dataCust2[reqdata][
                                    'documento_persona']);
                            }
                        })
                    }
                })

                $.ajax({
                    type: 'get',
                    url: '{{ route('findPersona') }}',
                    success: function(response) {
                        console.log(response);

                        var custArray = response;
                        var dataCust = {};
                        var dataCust2 = {};
                        for (var i = 0; i < custArray.length; i++) {
                            dataCust[custArray[i].datos_persona] = null;
                            dataCust2[custArray[i].datos_persona] = custArray[i];
                        }
                        console.log(dataCust2);


                        $('input#datos_trabajador').autocomplete({
                            data: dataCust,
                            onAutocomplete: function(reqdata) {

                                $('#documento_trabajador').val(dataCust2[reqdata][
                                    'documento_persona'
                                ]);
                            }
                        })
                    }
                })


            })
        </script>
        <script>
            $('.crear-cliente').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Crear cliente?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, confirmar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
        </script>
    @endpush
@endsection
