@extends('admin.layout')

@section('content')
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h6 class="mt-2">
                                    {{ __('VER PRODUCTO') }}
                                </h6>
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-danger btn-sm" href="{{ route('productos.index', ['page' => request()->page]) }}">
                                    {{ __('VOLVER') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 g-3">
                                <label for="nombre_producto" class="text-sm">
                                    {{ __('NOMBRE DEL PRODUCTO') }}
                                </label>
                                <input name="nombre_producto" id="nombre_producto" class="form-control form-control-sm" value="{{ $producto->nombre_producto }}" disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="descripcion_producto" class="text-sm">
                                    {{ __('STOCK') }}
                                </label>
                                <input name="descripcion_producto" id="descripcion_producto" class="form-control form-control-sm" value="{{ $producto->stock }}" disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="nombre_producto" class="text-sm">
                                    {{ __('VALOR PROMEDIO') }}
                                </label>
                                <input name="precio" id="precio" class="form-control form-control-sm" value="S/. {{ $producto->precio }}" disabled>
                            </div>

                            <div class="form-group col-md-4 g-3">
                                <label for="unidad" class="text-sm">
                                    {{ __('UNIDAD') }}
                                </label>
                                <input name="unidad" id="unidad" class="form-control form-control-sm" value="{{ $producto->unidad ? $producto->unidad->nombre : '' }}" disabled>
                            </div>
                            
                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion" class="text-sm">
                                    {{ __('OBSERVACIÓN DEL PRODUCTO') }}
                                </label>
                                <input name="observacion" id="observacion" class="form-control form-control-sm" value="{{ $producto->observacion ?? 'no hay observación' }}" disabled>
                            </div>

                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion_producto" class="text-sm">
                                    {{ __('DESCRICIPCIÓN DEL PRODUCTO') }}
                                </label>
                                <input name="descripcion_producto" id="descripcion_producto" class="form-control form-control-sm" value="{{ $producto->descripcion_producto ?? 'no hay descripción del producto' }}" disabled>
                            </div>

                            <div id="search-results" class="mt-4">
                                <h2>Resultados de Búsqueda de Imágenes</h2>
                                <div class="gcse-search"></div> <!-- Cuadro de búsqueda -->
                                <div id="images-container"></div>
                            </div>

                            <span class="mt-3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    /* Ocultar el texto "Enhanced by Google" */
    .gsc-control-cse .gsc-control-cse {
        display: none !important; /* Ocultar el contenedor del control de CSE */
    }
    
    /* Ocultar el placeholder "Enhanced by Google" */
    .gsc-input { 
        font-size: 0; /* Hacer el texto invisible */
    }
    
    .gsc-input::placeholder { 
        color: transparent; /* Ocultar el placeholder */
        font-size: 16px; /* Ajustar el tamaño del texto para que no ocupe espacio */
    }
</style>
@stop

@section('js')
<script async src="https://cse.google.com/cse.js?cx=85fc42cf4ae324f7a"></script> <!-- Cargar el script de CSE -->

<script>
    // Inicializar la búsqueda con el nombre del producto
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.querySelector('.gcse-search');
        
        // Establecer el nombre del producto como búsqueda inicial
        const productName = @json($producto->nombre_producto); // Convertir a JSON para usar en JS
        const nombreProductoInput = document.getElementById('nombre_producto'); // Obtener el campo de nombre_producto

        console.log('Product Name:', productName); // Debugging: Check the product name
        console.log('Nombre Producto Input:', nombreProductoInput); // Debugging: Check the input field

        // Asegurarse de que ambos campos se llenen
        if (nombreProductoInput) {
            nombreProductoInput.value = productName; // Asignar el nombre del producto al input
        } else {
            console.error('El campo de nombre_producto no se encontró.'); // Error message if the input is not found
        }

        // Esperar un momento para que el campo de búsqueda esté disponible
        setTimeout(() => {
            const searchField = document.querySelector('input.gsc-input'); // Obtener el campo de entrada del CSE
            const searchButton = document.querySelector('.gsc-search-button'); // Obtener el botón de búsqueda
            
            if (searchField) {
                searchField.value = productName; // Asignar el nombre del producto al campo de búsqueda
                searchField.dispatchEvent(new Event('input')); // Disparar el evento de entrada para CSE
                searchButton.click(); // Hacer clic en el botón de búsqueda para iniciar la búsqueda
            } else {
                console.error('El campo de búsqueda de CSE no se encontró.'); // Error message if searchField is not found
            }
        }, 330); // Espera de 1 segundo
    });
</script>
@stop
