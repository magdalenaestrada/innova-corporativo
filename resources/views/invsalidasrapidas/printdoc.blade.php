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
            <img style="width: 90px" src="{{asset('images/agrotrac.jpeg')}}" alt="">
        </div>

        <div class="text-center" style="margin-top: -10%">
            <h1>SALIDA DE ALMACEN</h1>
          
        </div>
        <hr class="mt-5">
        @if ($invsalidarapida->estado   == 'ANULADO')
            <p class="h2" style="color:red">SALIDA ANULADA</p>
        @endif
        <h5><strong>SALIDA:</strong> AF-{{ $invsalidarapida->id }}</h5>
        <hr>
        <br>

        <p><strong>Fecha de creación de la salida:</strong> {{ $invsalidarapida->created_at }}</p>
        <p><strong>Empresa: </strong>GRUPO INNOVA CORPORATIVO S.A.C.</p>
        <p><strong>Ruc: </strong>20613573691 </p>

        <p><strong>Solicitante: </strong>{{ $invsalidarapida->nombre_solicitante }}</p>
        <p><strong>Dni del solicitante: </strong>{{ $invsalidarapida->documento_solicitante }}</p>
        <p><strong>Destino: </strong>{{ $invsalidarapida->destino }}</p>

      


        <hr>

        <div class="mt-2">
            @if (count($invsalidarapida->productos) > 0)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center" style="font-size: 14px">

                            <th scope="col">
                                {{ __('PRODUCTO DE LA SALIDA') }}
                            </th>
                            <th scope="col">
                                {{ __('CANTIDAD') }}
                            </th>
                              
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invsalidarapida->productos as $producto)
                            <tr class="text-center" style="font-size: 14px">
                                <td scope="row">
                                    {{ $producto->nombre_producto }}
                                </td>
                                <td scope="row">
                                    {{ $producto->pivot->cantidad }}
                                </td>
                                                                                          
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <hr>
            @endif
        
        </div>
               
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
