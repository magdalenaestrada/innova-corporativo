@extends('admin.layout')

@section('content')
    <br>
    <div class="container mt-4">
        <div class="card shadow-sm p-4" style="max-width: 95%; margin: auto; font-size: 15px;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">EDITAR NOTA DE PEDIDO - {{ $nota->codigo }}</h5>
                <a href="{{ route('nota-pedido.index') }}" class="btn btn-secondary btn-sm">Volver</a>
            </div>

            <div class="card-body">
                <form id="formEditarOrden" action="{{ route('nota-pedido.update', $nota->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @php
                        use Carbon\Carbon;
                        $hoy = Carbon::now('America/Lima')->format('Y-m-d');
                    @endphp

                    {{-- Datos principales --}}
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Fecha de creación</label>
                            <input type="date" name="fecha_creacion" class="form-control modern-input"
                                value="{{ $nota->fecha_creacion ?? '' }}" max="{{ $hoy }}" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">DNI</label>
                            <input type="text" name="dni" class="form-control modern-input"
                                value="{{ $nota->dni ?? '' }}" maxlength="8" inputmode="numeric" pattern="\d*" required>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Conductor</label>
                            <input type="text" name="conductor" class="form-control modern-input"
                                value="{{ $nota->conductor ?? '' }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Telefono</label>
                            <input type="text" name="telefono" class="form-control modern-input"
                                value="{{ $nota->telefono ?? '' }}" maxlength="9" inputmode="numeric" pattern="\d*" >

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Placa</label>
                            <input type="text" 
                                name="placa_vehiculo" 
                                class="form-control modern-input"
                                value="{{ $nota->placa_vehiculo ?? '' }}" 
                                pattern="^[A-Za-z0-9]+-[A-Za-z0-9]+$"
                                placeholder="Ejemplo: ABC-123"
                                title="Debe contener letras y números separados por un guion medio (Ejemplo: ABC-123)"
                                maxlength="10" 
                                required
                                oninput="this.value = this.value.toUpperCase();">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Kilometraje</label>
                            <input type="number" 
                                name="kilometraje" 
                                class="form-control modern-input"
                                value="{{ $nota->kilometraje ?? '' }}" 
                                step="0.01" 
                                min="0" 
                                placeholder="Ejemplo: 125.75">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Encargado</label>
                            <select name="encargado_id" class="form-control modern-input" required>
                                <option value="">-- Seleccione encargado --</option>
                                @foreach ($encargados as $encargado)
                                    <option value="{{ $encargado->id }}"
                                        {{ $nota->encargado_id == $encargado->id ? 'selected' : '' }}>
                                        {{ $encargado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

            </div>

            <hr>

            {{-- Tabla de productos --}}
            <h6 class="mb-3">Detalles del pedido</h6>
            <div class="d-flex justify-content-end align-items-center mt-3">
                <button type="button" id="agregarFila" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Agregar producto
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tablaDetalles">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 60%">Producto</th>
                            <th style="width: 20%">Cantidad</th>
                            <th style="width: 10%">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nota->detalles as $detalle)
                            <tr>
                                <td>
                                    <select class="form-control modern-input producto_id" required>
                                        <option value="">-- Seleccione producto --</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}"
                                                {{ $detalle->producto_id == $producto->id ? 'selected' : '' }}>
                                                {{ $producto->nombre_producto }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control modern-input cantidad text-center"
                                        min="1" step="0.01" value="{{ $detalle->cantidad }}" required>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger eliminarFila">X</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end align-items-center mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
            </div>

            <input type="hidden" name="detalles" id="detalles">

            </form>

        </div>
    </div>
    </div>

    {{-- Scripts --}}
    <script>
        document.getElementById('agregarFila').addEventListener('click', function() {
            const tbody = document.querySelector('#tablaDetalles tbody');

            // Obtener los productos ya seleccionados
            const seleccionados = Array.from(document.querySelectorAll('.producto_id'))
                .map(select => select.value)
                .filter(v => v !== '');

            // Construir las opciones filtradas
            let opciones = `<option value="">-- Seleccione producto --</option>`;
            @foreach ($productos as $producto)
                if (!seleccionados.includes("{{ $producto->id }}")) {
                    opciones += `<option value="{{ $producto->id }}">{{ $producto->nombre_producto }}</option>`;
                }
            @endforeach

            // Si ya están todos los productos seleccionados
            if (opciones === `<option value="">-- Seleccione producto --</option>`) {
                alert('Ya se han agregado todos los productos disponibles.');
                return;
            }

            // Crear la nueva fila solo con los productos no seleccionados
            const nuevaFila = document.createElement('tr');
            nuevaFila.innerHTML = `
        <td>
            <select class="form-control modern-input producto_id" required>
                ${opciones}
            </select>
        </td>
        <td>
            <input type="number" class="form-control modern-input cantidad text-center" min="1" step="1" value="1" required>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger eliminarFila">🗑️</button>
        </td>
    `;
            tbody.appendChild(nuevaFila);
        });

        // Eliminar fila
        document.addEventListener('click', function(e) {
            if (e.target.closest('.eliminarFila')) {
                e.target.closest('tr').remove();
            }
        });

        document.getElementById('formEditarOrden').addEventListener('submit', function(e) {
            const detalles = [];
            document.querySelectorAll('#tablaDetalles tbody tr').forEach(fila => {
                const producto_id = fila.querySelector('.producto_id').value;
                const cantidad = fila.querySelector('.cantidad').value;
                if (producto_id && cantidad > 0) {
                    detalles.push({
                        producto_id,
                        cantidad
                    });
                }
            });

            if (detalles.length === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un producto antes de guardar.');
                return;
            }

            document.getElementById('detalles').value = JSON.stringify({
                detalles
            });
        });
    </script>
@endsection
