@extends('admin.layout')

@section('content')
    <div class="container">
        <br />
        <div class="card">

            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('CANCELAR TICKETS DE COMEDOR') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-danger btn-sm" href="{{ route('abonados.index') }}">
                            {{ __('VOLVER') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('abonados.store') }}">
                    @csrf

                    <div class="form-group col-md-12 g-3">
                        <label for="fecha_cancelacion" class="text-muted">
                            {{ __('FECHA DE CANCELACIÓN DE TICKETS DE COMEDOR') }}
                        </label>
                        <span class="text-danger">(*)</span>
                        <input type="datetime-local" name="fecha_cancelacion"
                            placeholder="Ingrese la fecha de cancelación de los tickets de comedor" class="form-control">
                    </div>

                    <div id="total-selection-container">
                        <div class="form-group col-md-12 g-3 mb-2" id="select_container">
                            <label for="lotes" class="text-muted">
                                {{ __('LOTES') }}
                            </label>
                            <select name="lotes[]" id="lotes" multiple required>

                                @foreach ($lotes as $lote)
                                    @php

$nombre_cliente = App\Models\Rancho::where('lote', $lote)
                                   ->where('cancelado', 'no')
                                   ->value('datos_cliente');

$sum_of_cantidad = App\Models\Rancho::where('lote', $lote)
                                    ->where('cancelado', 'no')
                                    ->sum('cantidad');
                                    @endphp
                                    <option value="{{ $lote }}" data-cantidad="{{ $sum_of_cantidad }}">
                                        {{ $lote }} ->
                                        {{ $nombre_cliente }} - CANTIDAD {{ $sum_of_cantidad }}</option>
                                @endforeach
                            </select>
                        </div>
                       


                        <!-- para cada documento cliente se muestran sus registros para que se eligan entre ellos solo los que se agregarán a la programación-->
                        <div id="ranchos_checkbox_container"></div>

                        <a href="#" id="mark_all_checkboxes" class="btn btn-outline-dark m-1">Seleccionar todo</a>
                        <div id="select_all_btns_socios_container"></div>
                    </div>
                    
                   

                    <div class="col-md-12 text-end g-3 h5 mt-3" id="sum-of-tons"></div>
                    <div class="col-md-12 text-right g-3 mt-3">
                        <button type="submit" class="btn btn-primary text-end mt-2">Cancelar Orden</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>

    <script>
            new MultiSelectTag('lotes');

            var select = document.getElementById('lotes');
            var select_container = document.getElementById('select_container');
            var total_selection_container = document.getElementById('total-selection-container')
            var sumDisplay = document.getElementById('sum-of-tons');

           

            // para cada documento cliente se muestran sus registros para que se eligan entre ellos solo los que se agregarán a la programación
            // ya tengo la variable #select para el input de la selección por documento cliente
            var ranchosCheckboxContainer = document.getElementById('ranchos_checkbox_container');
            var selectAllBtnsSociosContainer = document.getElementById('select_all_btns_socios_container');
            var ranchos = {!! json_encode($ranchos) !!};



            select_container.addEventListener('click', function() {
                var documento_socio = '';
                var documentos_socios = [];

                var selectedOption = select.options[select.selectedIndex];

                var selectedDocumentoClientes = []; // Array to store selected documento_cliente IDs

                // Loop through all selected options (multiselection)
                for (var i = 0; i < select.options.length; i++) {
                    if (select.options[i].selected) {
                        selectedDocumentoClientes.push(select.options[i].value);
                    }
                }

                // Filter ranchos based on ALL selected documento_clientes
                var filteredRanchos = ranchos.filter(function(rancho) {
                    return selectedDocumentoClientes.includes(rancho.lote);
                });


                ranchosCheckboxContainer.innerHTML = '';
                selectAllBtnsSociosContainer.innerHTML = '';



                filteredRanchos.forEach(function(rancho) {
                    var checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'ranchos[]';
                    checkbox.value = rancho.id;
                    checkbox.id = 'rancho_' + rancho.id;

                    checkbox.setAttribute('documento-socio', rancho.lote);
                    documento_socio = checkbox.getAttribute('documento-socio');
                    if (!documentos_socios.includes(documento_socio)) {
                        documentos_socios.push(documento_socio);
                    }


                    var label = document.createElement('label');
                    label.classList.add("label-checkbox");
                    label.appendChild(checkbox);
                    label.htmlFor = 'rancho_' + rancho.id;
                    label.appendChild(document.createTextNode(' ' + rancho.id + '. fecha creación: ' +
                        formatDate(rancho.created_at) + ', Cantidad: ' + rancho.cantidad +
                        ', Cliente: ' + rancho.datos_cliente +  ', ' + ' Lote: '+ rancho.lote));
                    var br = document.createElement('br');



                    ranchosCheckboxContainer.appendChild(label);
                    ranchosCheckboxContainer.appendChild(br);
                });

                documentos_socios.forEach(function(doc_socio) {
                    // Create a new <a> element
                    var btn = document.createElement('a');

                    // Set the id attribute
                    btn.id = 'socio_' + doc_socio;
                    btn.href = '#'

                    btn.classList.add('btn', 'btn-outline-dark', 'm-1', )
                    // Set the text content of the link
                    btn.textContent = 'Seleccionar todo por lote: ' + doc_socio;

                    // Append the button to a container (assuming selectAllBtnsSociosContainer is a function that appends buttons)
                    selectAllBtnsSociosContainer.appendChild(btn);
                });



                // Pick "Select All" button for socio
       
            
                if (documentos_socios.length > 0) {
                documentos_socios.forEach(function(doc_socio) {
                       
                        var selectAllButton = document.getElementById('socio_' + doc_socio);
                        console.log(3)
                        selectAllButton.addEventListener('click', function() {
                            // Find all checkboxes within the container

                            var documento_socio = '';

                            var checkboxes = ranchosCheckboxContainer.querySelectorAll('input[type="checkbox"]');

                            // Check all checkboxes
                            for (var i = 0; i < checkboxes.length; i++) {
                                documento_socio = checkboxes[i].getAttribute('documento-socio');
                                console.log(doc_socio)
                                if (documento_socio == doc_socio) {
                                    checkboxes[i].checked = true;
                                }

                            }



                        });

                    });
                }

            });


            // Create and add the "Select All" button
            var selectAllButton = document.getElementById('mark_all_checkboxes');
            selectAllButton.addEventListener('click', function() {
                // Find all checkboxes within the container

                var checkboxes = ranchosCheckboxContainer.querySelectorAll('input[type="checkbox"]');

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

                // Calculate and display the sum of the checkboxes
                total_selection_container.addEventListener('click', function() {
                    var checkboxes = ranchosCheckboxContainer.querySelectorAll('input[type="checkbox"]:checked');
                    var sum = 0;
                    checkboxes.forEach(function(checkbox) {
                        // Retrieve the rancho object associated with the checkbox
                        var ranchoId = checkbox.value;
                        var rancho = ranchos.find(function(item) {
                            return item.id == ranchoId;
                        });
                        // Add the toneladas value of the registro to the sum
                        sum += parseFloat(rancho.cantidad);
                    });
                    sumDisplay.textContent = 'Total Cantida de tickets: ' + sum;
                });
    </script>
@endsection

