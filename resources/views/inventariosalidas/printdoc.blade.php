<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <br>
    <div class="container">
        <div class="text-end">
            <img style="width: 100px" src="{{asset('images/Innova.png')}}" alt="">
        </div>

        <div class="text-center" style="margin-top: -10%">
            <h1>REQUERIMIENTO</h1>
            <br>
        </div>
        <hr>
        <h5><strong>REQUERIMIENTO:</strong> AF-{{ $inventariosalida->id }}</h5>
        <hr>
        <br>

        <p><strong>Fecha de creación:</strong> {{ $inventariosalida->created_at }}</p>
        <p><strong>Creador del requerimiento</strong> {{ $inventariosalida->usuario_requerimiento }}</p>
        <p><strong>Documento del solicitante</strong> {{ $inventariosalida->documento->documento_solicitante }}</p>
        <p><strong>Nombre del solicitante</strong> {{ $inventariosalida->documento->nombre_solicitante }}</p>
        <p><strong>Area solicitante</strong> {{ $inventariosalida->documento->area_solicitante }}</p>
        
        



        <hr>

        <div class="mt-2">
            @if (count($inventariosalida->productos) > 0)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center" style="font-size: 15px">

                            <th scope="col">
                                {{ __('PRODUCTO DEL REQUERIMIENTO') }}
                            </th>
                            <th scope="col">
                                {{ __('CANTIDAD') }}
                            </th>
                            <th scope="col">
                                {{ __('UNIDAD') }}
                            </th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventariosalida->productos as $producto)
                            <tr class="text-center">
                                <td scope="row">
                                    {{ $producto->nombre_producto }}
                                </td>
                                <td scope="row">
                                    {{ $producto->pivot->cantidad }}
                                </td>
                                @if($producto->unidad)
                                <td scope="row">
                                    {{ $producto->unidad->nombre }}
                                </td>
                                @endif
                                
                               
                               

                              






                            </tr>
                        @endforeach
                    </tbody>



                </table>
                <hr>
            @endif

           
        </div>


        @if($inventariosalida->descripcion )
        <p><strong>Observación</strong> {{ $inventariosalida->descripcion }}</p>
        @endif


        


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
