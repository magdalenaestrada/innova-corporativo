@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('MÓDULO PARA FINALIZAR LA EJECUCIÓN') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a class="btn btn-danger btn-sm" href="{{ route('programacion.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="finalizar-programacion" action="{{ route('programacion.updatefinalizar', $programacion->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')




                    <div class="form-group col-md-12 g-3">
                        <label for="ejecucion_finalizada" class="text-muted">
                            {{ __('EJECUCIÓN FECHA FIN') }}
                        </label>
                        <span class="text-danger">(*)</span>
                        <input type="datetime-local" name="ejecucion_finalizada"
                            placeholder="Ingrese la fecha del Fin de la Ejecución" class="form-control">
                    </div>


                    <div class="form-group col-md-12 g-3">
                        <label for="observacion" class="text-muted">
                            {{ __('OBSERVACIÓN') }}
                        </label>
                        <textarea name="observacion" id="observacion" class="form-control @error('observacion') is-invalid @enderror"
                            placeholder="De ser el caso, ingrese una descripción o comentario...">{{ old('observacion') }}</textarea>
                        @error('observacion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                    <div id="total-selection-container">
                        <div class="form-group col-md-12 g-3 mb-1" id="select_container">
                            <label for="documentos_clientes" class="text-muted">
                                {{ __('TONELADAS EJECUTADAS') }}
                            </label>
                            <select name="documentos_clientes[]" id="documentos_clientes" multiple required>

                                @foreach ($documentos_clientes as $documento_cliente)
                                    @php
                                        $registros_cliente = $registros->where('documento_cliente', $documento_cliente);
                                        $sum_of_tons = $registros_cliente->sum('toneladas');
                                        $nombre_cliente = $registros_cliente->isNotEmpty()
                                            ? $registros_cliente->first()->datos_cliente
                                            : '';
                                    @endphp
                                    <option value="{{ $documento_cliente }}" data-toneladas="{{ $sum_of_tons }}">
                                        {{ $documento_cliente }}
                                        {{ $nombre_cliente }} - {{ $sum_of_tons }} TONELADAS</option>
                                @endforeach
                            </select>
                        </div>



                        <!-- para cada documento cliente se muestran sus registros para que se eligan entre ellos solo los que se agregarán a la programación-->
                        <div id="registros_checkbox_container"></div>
                        <a href="#" id="mark_all_checkboxes" class="btn btn-outline-dark mt-2">Seleccionar todo</a>
                    </div>


                    <div class="col-md-12 text-end g-3 h3 mt-3" id="sum-of-tons-programado"></div>
                    <div class="col-md-12 text-end g-3 h4 mt-3" id="sum-of-tons-ejecutado"></div>
                    <div class="col-md-12 text-end g-3 h5 mt-3" id="tons-restantes"></div>


                    <div class="form-group col-md-12 text-end g-3">
                        <button type="submit" class="btn btn-secondary btn-sm">
                            {{ __('ACTUALIZAR REGISTRO') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            new MultiSelectTag('documentos_clientes');

            var sumDisplayProgramado = document.getElementById('sum-of-tons-programado');
            var sumDisplayEjecutado = document.getElementById('sum-of-tons-ejecutado');
            var restantesDisplay = document.getElementById('tons-restantes');
            var select_container = document.getElementById('select_container');
            var select = document.getElementById('documentos_clientes');
            var total_selection_container = document.getElementById('total-selection-container')


            //calculate the sum of the total of tons programmed
            var sum_of_tons_programado_total = {{ $sum_of_tons_programado_total }};
            sumDisplayProgramado.textContent = 'Total toneladas programadas: ' + sum_of_tons_programado_total;

            // Calculate the total of tons executed and the left ones
            // Calculate and display the sum of the checkboxes
            total_selection_container.addEventListener('click', function() {
                var checkboxes = registrosCheckboxContainer.querySelectorAll('input[type="checkbox"]:checked');
                var sum_of_tons_ejecutadas_total = 0;
                var tons_restantes = 0
                checkboxes.forEach(function(checkbox) {
                    // Retrieve the registro object associated with the checkbox
                    var registroId = checkbox.value;
                    var registro = registros.find(function(item) {
                        return item.id == registroId;
                    });
                    // Add the toneladas value of the registro to the sum
                    sum_of_tons_ejecutadas_total += parseFloat(registro.toneladas);
                });
                // Making substraction to get the total of tons that are left
                tons_restantes = sum_of_tons_programado_total - sum_of_tons_ejecutadas_total
                //Displaying the totals
                sumDisplayEjecutado.textContent = 'Total toneladas ejecutadas: ' + sum_of_tons_ejecutadas_total;
                restantesDisplay.textContent     = 'Total toneladas restantes: ' + tons_restantes;
            });



            $('.editar-registro').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿actualizar registro?',
                    icon: 'warning',
                    ShowCancelButton: true,
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



            // para cada documento cliente se muestran sus registros para que se eligan entre ellos solo los que se agregarán a la finalización de la programación
            // ya tengo la variable #select para el input de la selección por documento cliente

            var registrosCheckboxContainer = document.getElementById('registros_checkbox_container');
            var registros = {!! json_encode($registros) !!};

            select_container.addEventListener('click', function() {

                var selectedOption = select.options[select.selectedIndex];

                var selectedDocumentoClientes = []; // Array to store selected documento_cliente IDs

                // Loop through all selected options (multiselection)
                for (var i = 0; i < select.options.length; i++) {
                    if (select.options[i].selected) {
                        selectedDocumentoClientes.push(select.options[i].value);
                    }
                }

                // Filter registros based on ALL selected documento_clientes
                var filteredRegistros = registros.filter(function(registro) {
                    return selectedDocumentoClientes.includes(registro.documento_cliente);
                });


                registrosCheckboxContainer.innerHTML = '';

                filteredRegistros.forEach(function(registro) {
                    var checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'registros[]';
                    checkbox.value = registro.id;
                    checkbox.id = 'registro_' + registro.id;

                    var label = document.createElement('label');
                    label.classList.add("label-checkbox");
                    label.appendChild(checkbox);
                    label.htmlFor = 'registro_' + registro.id;
                    label.appendChild(document.createTextNode(' ' + registro.id + '. fecha creación: ' +
                        formatDate(registro.created_at) + ', Toneladas: ' + registro.toneladas +
                        ', Cliente: ' + registro.datos_cliente + ' ' + '(' + registro
                        .documento_cliente + ')'));
                    var br = document.createElement('br');


                    registrosCheckboxContainer.appendChild(label);
                    registrosCheckboxContainer.appendChild(br);
                });

            });


            // Create and add the "Select All" button
            var selectAllButton = document.getElementById('mark_all_checkboxes');
            selectAllButton.addEventListener('click', function() {
                // Find all checkboxes within the container
                var checkboxes = registrosCheckboxContainer.querySelectorAll('input[type="checkbox"]');

                // Check all checkboxes
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = true;
                }
            });



            // Funcion para formatear la fecha
            function formatDate(dateString) {
                var date = new Date(dateString);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var seconds = date.getSeconds();

                // Ensure leading zero for single digit days, months, hours, minutes, and seconds
                day = day < 10 ? '0' + day : day;
                month = month < 10 ? '0' + month : month;
                hours = hours < 10 ? '0' + hours : hours;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
            }




            


        </script>
        @if ($errors->has('guia_remision') || $errors->has('guia_transportista'))
            <script>
                let errorMessage = '';

                @if ($errors->has('guia_remision'))
                    errorMessage += '<p>{{ $errors->first('guia_remision') }}</p>';
                @endif

                @if ($errors->has('guia_transportista'))
                    errorMessage += '<p>{{ $errors->first('guia_transportista') }}</p>';
                @endif

                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    html: errorMessage,
                });
            </script>
        @endif
    @endpush
@endsection
