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
                                <input type="text" name="dni" class="form-control modern-input" maxlength="9"
                                    inputmode="numeric" pattern="\d*" required>
                                <button class="btn btn-success" type="button" id="buscar_dni_btn">Buscar</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="proveedor" class="form-label">Conductor</label>
                            <input type="text" name="proveedor" id="nombre" class="form-control" required
                                placeholder="Nombre del conductor">

                        </div>
                        <div class="col-md-3">
                            <label for="placa_vehiculo" class="form-label">Placa</label>
                            <input type="text" name="placa_vehiculo" class="form-control modern-input"
                                pattern="^[A-Za-z]{3}-\d{3,4}$" placeholder="No olvides incluir el guión medio"
                                title="Formato válido: ABC-123 o ABC-1234" maxlength="8" required>
                        </div>
                        <div class="col-md-2">
                            <label for="kilometraje" class="form-label">Kilometraje
                            </label>
                            <input type="number" name="kilometraje" class="form-control modern-input">
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
                            <input type="number" name="telefono" id="telefono" class="form-control">
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

        $(document).ready(function() {
            $("#buscar_dni_btn").on("click", function() {
                const documento = $("input[name='dni']").val().trim();

                if (documento === "") {
                    alert("Por favor, ingrese un DNI.");
                    return;
                }

                $.ajax({
                    url: "{{ route('buscar.documento') }}",
                    type: "POST",
                    data: {
                        documento: documento,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.nombres) {
                            $("#nombre").val(response.nombres + " " + response.apellidoPaterno +
                                " " + response.apellidoMaterno);
                        } else if (response.razonSocial) {
                            $("#nombre").val(response.razonSocial);
                        } else {
                            alert("No se encontraron datos.");
                        }
                    },
                    error: function() {
                        alert("Ocurrió un error al consultar el documento.");
                    },
                });
            });
        });
    </script>
@endsection
