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
            <img style="width: 90px" src="{{asset('images/Innova.png')}}" alt="">
        </div>

        <div class="text-center" style="margin-top: -10%">
            <h1>SALIDA COMO PRESTAMO</h1>
            <br>
        </div>
        <hr style="margin-top: -0.2%">
        <h6><strong>SALIDA:</strong> AF-{{ $inventarioprestamosalida->id }}</h6>
        <hr>
      

        <p><strong>Fecha de creación del prestamo como salida:</strong> {{ $inventarioprestamosalida->created_at }}</p>
        <p><strong>Creador del prestamo: </strong> {{ $inventarioprestamosalida->usuario_creador }}</p>
        <p><strong>Documento del responsable del transporte: </strong> {{ $inventarioprestamosalida->documento_responsable }}</p>
        <p><strong>Nombre del responsable del transporte: </strong> {{ $inventarioprestamosalida->nombre_responsable }}</p>




        <hr>

        <div class="mt-2">
            @if (count($inventarioprestamosalida->productos) > 0)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center" style="font-size: 14px">

                            <th scope="col">
                                {{ __('PRODUCTO DEL REQUERIMIENTO') }}
                            </th>
                            <th scope="col">
                                {{ __('CANTIDAD') }}
                            </th>
                            <th scope="col">
                                {{ __('VALOR UNITARIO') }}
                            </th>
                          


                            


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventarioprestamosalida->productos as $producto)
                            <tr class="text-center" style="font-size: 12px">
                                <td scope="row">
                                    {{ $producto->nombre_producto }}
                                </td>
                                <td scope="row">
                                    {{ $producto->pivot->cantidad }}
                                </td>
                                <td scope="row">
                                    {{ $producto->pivot->ultimoprecio }}
                                </td>
                               
                               

                              






                            </tr>
                        @endforeach
                    </tbody>



                </table>
                <hr>
            @endif

           
        </div>

        <p><strong>Observación</strong> {{ $inventarioprestamosalida->observacion }}</p>



        


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
