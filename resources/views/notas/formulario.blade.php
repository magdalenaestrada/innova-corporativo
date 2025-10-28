@extends('admin.layout')

@section('content')
    <br>
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">CREAR NOTA DE PEDIDO</h5>
                <a href="{{ route('nota-pedido.index') }}" class="btn btn-secondary btn-sm">Volver</a>
            </div>
            @php
                use Carbon\Carbon;
                $hoy = Carbon::now('America/Lima')->format('Y-m-d');
            @endphp
            <div class="card-body">
                <form action="{{ route('nota-pedido.store') }}" method="POST" id="formNotaPedido">
                    @csrf
                    {{-- DATOS DEL PROVEEDOR --}}
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="dni" class="form-label">DNI</label>
                            <div class="input-group">
                                <input type="text" name="dni" id="dni" class="form-control" required
                                    placeholder="Ingrese documento">
                                <button class="btn btn-success" type="button" id="buscar_dni_btn">Buscar</button>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="proveedor" class="form-label">Conductor</label>
                            <input type="text" name="proveedor" id="proveedor" class="form-control" required
                                placeholder="Nombre del proveedor">
                        </div>
                        <div class="col-md-2">
                            <label for="placa_vehiculo" class="form-label">Placa</label>
                            <input type="text" name="placa_vehiculo" id="placa_vehiculo" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label for="kilometraje" class="form-label">Kilometraje
                            </label>
                            <input type="text" name="kilometraje" id="kilometraje" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="fecha_creacion" class="form-label">Fecha</label>
                            <input type="date" name="fecha_creacion" id="fecha_creacion" class="form-control"
                                max="{{ $hoy }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="encargado_id" class="form-label">Encargado</label>
                            <select name="encargado_id" id="encargado_id" class="form-control" required>
                                <option value="">-- Seleccione un encargado --</option>
                                @foreach ($encargados as $encargado)
                                    <option value="{{ $encargado->id }}">{{ $encargado->nombre ?? $encargado->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control">
                        </div>
                    </div>

                    <hr>
                    <h6 class="mb-3">Productos</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th class="text-center">
                                        <button class="btn btn-success btn-sm" type="button" id="addMoreButton">+
                                            Añadir</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="table_body" style="font-size: 15px">
                                <tr>
                                    <td>
                                        <select name="products[]" class="form-control buscador cart-product" required>
                                            <option value="">-- Seleccione una opción --</option>
                                            @foreach ($productos as $producto)
                                                <option value="{{ $producto->id }}">{{ $producto->nombre_producto }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input name="qty[]" class="form-control form-control-sm" required
                                            placeholder="0.0">
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm" type="button"
                                            onclick="remove_tr(this)">✕</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <input type="hidden" name="detalles" id="inputDetalles">

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Guardar Nota de Pedido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // === Agregar nueva fila ===
        document.getElementById('addMoreButton').addEventListener('click', function() {
            const fila = `
            <tr>
                <td>
                    <select name="products[]" class="form-control buscador cart-product" required>
                        <option value="">-- Seleccione una opción --</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre_producto }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input name="qty[]" class="form-control form-control-sm" required placeholder="0.0">
                </td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm" type="button" onclick="remove_tr(this)">✕</button>
                </td>
            </tr>`;
            $('#table_body').append(fila);
        });

        // === Eliminar fila ===
        function remove_tr(button) {
            $(button).closest('tr').remove();
        }

        // === Serializar datos antes de enviar ===
        $('#formNotaPedido').on('submit', function(e) {
            const detalles = [];
            $('#table_body tr').each(function() {
                const producto = $(this).find('select').val();
                const cantidad = $(this).find('input').val();
                if (producto && cantidad) {
                    detalles.push({
                        producto,
                        cantidad
                    });
                }
            });
            $('#inputDetalles').val(JSON.stringify(detalles));
        });

        // === Buscar proveedor por RUC o razón social ===
        // === Buscar proveedor por DNI o RUC ===
        $('#buscar_dni_btn').click(function() {
            const documento = $('#dni').val().trim();

            if (documento.length < 8) {
                Swal.fire('Atención', 'Ingrese un número de documento válido.', 'warning');
                return;
            }

            // 🟢 Buscar por DNI (consulta tipo Reniec)
            if (documento.length === 8) {
                $.ajax({
                    url: "{{ route('buscar.documento') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        documento: documento,
                        tipo_documento: 'dni'
                    },
                    success: function(response) {
                        if (response.nombres) {
                            $('#proveedor').val(
                                `${response.nombres} ${response.apellidoPaterno} ${response.apellidoMaterno}`
                                );
                        } else {
                            Swal.fire('Atención', 'No se encontró información para este DNI.',
                                'warning');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Hubo un problema al consultar el DNI.', 'error');
                    }
                });
            }

            // 🟡 Buscar por RUC (consulta tipo Sunat)
            else if (documento.length === 11) {
                $.ajax({
                    url: "{{ route('autocompbyruc.proveedor') }}",
                    type: 'GET',
                    data: {
                        ruc: documento
                    },
                    success: function(response) {
                        if (response) {
                            $('#proveedor').val(response.razon_social ?? '');
                            $('#telefono').val(response.telefono ?? '');
                        } else {
                            Swal.fire('Atención', 'No se encontró el proveedor con ese RUC.',
                            'warning');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Hubo un problema al consultar el RUC.', 'error');
                    }
                });
            }

            // ❌ Documento inválido
            else {
                Swal.fire('Atención', 'El documento debe tener 8 (DNI) o 11 (RUC) dígitos.', 'warning');
            }
        });
    </script>
@endsection
