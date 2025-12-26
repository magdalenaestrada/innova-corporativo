<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IMPRIMIR LIQUIDACIÓN CLIENTE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container pt-2">
        <br>
        <div class="text-end">
            <img style="width: 90px; margin-top: -1%" src="{{ asset('images/Innova.png') }}" alt="">
        </div>

        <div class="text-center" style="margin-top: -8%;">
            <h2>CLIENTES DEVOLUCIONES</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;">




        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>RECIBO:</strong> 011</h5>
            <h5 class="fs-6"><strong>DEVOLUCIÓN:</strong> AF-{{ $devolucion->id }}</h5>
            <div style="width: 200px">
                @php
                    if ($devolucion->ingresocuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                        $coin_simbol = '$';
                    } else {
                        $coin_simbol = 's/';
                    }

                @endphp


                @if ($devolucion->ingresocuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ number_format($devolucion->ingresocuenta->monto,2    ) }}">
                @else
                    <input class="form-control text-center fs-6" type="text"
                        value="S/.{{ number_format($devolucion->ingresocuenta->monto ,2) }}">
                @endif
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            $amountInWords = $formatter->format(floor($devolucion->ingresocuenta->monto));
            $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

            $fractionalPart = ($devolucion->ingresocuenta->monto - floor($devolucion->ingresocuenta->monto)) * 100;
            $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
            $fractinwords = "{$fractionalPart}/100";

        @endphp

        @php
            if ($devolucion->ingresocuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                $total_monto_soles = $devolucion->ingresocuenta->monto;
            } else {
                $total_monto_soles = $devolucion->ingresocuenta->monto;
            }
        @endphp




        <div class="row" style="margin: -10px; font-size: 12px">

            

            <div class="col-md-6">
                <p><strong>SOCIEDAD: </strong>{{ strtoupper($devolucion->sociedad->nombre) }}</p>
            </div>
           



            <div class="col-md-6" >
                @if ($devolucion->ingresocuenta->motivo)
                    <p><strong>MOTIVO: </strong>{{ $devolucion->ingresocuenta->motivo->nombre }}</p>
                @endif
            </div>



            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>LA CANTIDAD DE: </strong>{{ strtoupper($amountInWords) }}
                     CON {{ $fractinwords }} {{ strtoupper($devolucion->ingresocuenta->cuenta->tipomoneda->nombre) }}
                </p>
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($devolucion->ingresocuenta->tipocomprobante)
                    <p><strong>TIPO COMPROBANTE: </strong>{{ $devolucion->ingresocuenta->tipocomprobante->nombre }}</p>
                @endif


            </div>

            <div class="col-md-6" style="margin-top: -10px">

                @if ($devolucion->ingresocuenta->comprobante_correlativo)
                    <p><strong>COMPROBANTE CORRELATIVO:
                        </strong>{{ strtoupper($devolucion->ingresocuenta->comprobante_correlativo) }}</p>
                @endif
            </div>



            <div class="col-md-12" style="margin-top: -10px">
                @if ($devolucion->ingresocuenta->descripcion)
                    <p><strong>DESCRIPCIÓN: </strong>{{ strtoupper($devolucion->ingresocuenta->descripcion) }}</p>
                @endif
            </div>
        </div>




        <hr style="margin-top: -1%;">







        <div class="mt-5 d-flex justify-content-between align-items-center">
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">RECIBÍ CONFORME</p>
            </div>

            <div>
                <p style="font-size: 12px">Nasca, {{ $devolucion->created_at->day }} de
                    {{ \Illuminate\Support\Str::ucfirst($devolucion->created_at->translatedFormat('F')) }} del
                    {{ $devolucion->created_at->year }}
                </p>
            </div>
        </div>


        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$devolucion->ingresocuenta->creador->name}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$devolucion->ingresocuenta->creador->empleado->documento}}</p>
            </div> 
        </div>

        


       


        <div class="mt-5 d-flex justify-content-between align-items-center" >
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">ENTREGUÉ CONFORME</p>
            </div> 
            
            <div>
                <p style="font-size: 12px">Nasca, {{ $devolucion->ingresocuenta->created_at->day }} de {{ \Illuminate\Support\Str::ucfirst($devolucion->ingresocuenta->created_at->translatedFormat('F')) }} del {{ $devolucion->ingresocuenta->created_at->year }}
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong>
                    {{ $devolucion->representante_cliente_nombre }}</p>
            </div>

            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{ $devolucion->representante_cliente_documento }}
                </p>
            </div>
        </div>


       


        <hr style="margin-top: -5px;">
    </div>





    <br>
    <br>
    <hr style="border-top: 1px dashed #000000;">


    <div class="container pt-2">
        <br>
        <div class="text-end">
            <img style="width: 90px; margin-top: -1%" src="{{ asset('images/Innova.png') }}" alt="">
        </div>

        <div class="text-center" style="margin-top: -8%;">
            <h2>CLIENTES DEVOLUCIONES</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;">




        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>RECIBO:</strong> 011</h5>
            <h5 class="fs-6"><strong>DEVOLUCIÓN:</strong> AF-{{ $devolucion->id }}</h5>
            <div style="width: 200px">
                @php
                    if ($devolucion->ingresocuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                        $coin_simbol = '$';
                    } else {
                        $coin_simbol = 's/';
                    }

                @endphp


                @if ($devolucion->ingresocuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ number_format($devolucion->ingresocuenta->monto,2    ) }}">
                @else
                    <input class="form-control text-center fs-6" type="text"
                        value="S/.{{ number_format($devolucion->ingresocuenta->monto ,2) }}">
                @endif
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            $amountInWords = $formatter->format(floor($devolucion->ingresocuenta->monto));
            $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

            $fractionalPart = ($devolucion->ingresocuenta->monto - floor($devolucion->ingresocuenta->monto)) * 100;
            $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
            $fractinwords = "{$fractionalPart}/100";

        @endphp

        @php
            if ($devolucion->ingresocuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                $total_monto_soles = $devolucion->ingresocuenta->monto;
            } else {
                $total_monto_soles = $devolucion->ingresocuenta->monto;
            }
        @endphp




        <div class="row" style="margin: -10px; font-size: 12px">

            

            <div class="col-md-6">
                <p><strong>SOCIEDAD: </strong>{{ strtoupper($devolucion->sociedad->nombre) }}</p>
            </div>
           



            <div class="col-md-6" >
                @if ($devolucion->ingresocuenta->motivo)
                    <p><strong>MOTIVO: </strong>{{ $devolucion->ingresocuenta->motivo->nombre }}</p>
                @endif
            </div>



            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>LA CANTIDAD DE: </strong>{{ strtoupper($amountInWords) }}
                     CON {{ $fractinwords }} {{ strtoupper($devolucion->ingresocuenta->cuenta->tipomoneda->nombre) }}
                </p>
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($devolucion->ingresocuenta->tipocomprobante)
                    <p><strong>TIPO COMPROBANTE: </strong>{{ $devolucion->ingresocuenta->tipocomprobante->nombre }}</p>
                @endif


            </div>

            <div class="col-md-6" style="margin-top: -10px">

                @if ($devolucion->ingresocuenta->comprobante_correlativo)
                    <p><strong>COMPROBANTE CORRELATIVO:
                        </strong>{{ strtoupper($devolucion->ingresocuenta->comprobante_correlativo) }}</p>
                @endif
            </div>



            <div class="col-md-12" style="margin-top: -10px">
                @if ($devolucion->ingresocuenta->descripcion)
                    <p><strong>DESCRIPCIÓN: </strong>{{ strtoupper($devolucion->ingresocuenta->descripcion) }}</p>
                @endif
            </div>
        </div>




        <hr style="margin-top: -1%;">







        <div class="mt-5 d-flex justify-content-between align-items-center">
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">RECIBÍ CONFORME</p>
            </div>

            <div>
                <p style="font-size: 12px">Nasca, {{ $devolucion->created_at->day }} de
                    {{ \Illuminate\Support\Str::ucfirst($devolucion->created_at->translatedFormat('F')) }} del
                    {{ $devolucion->created_at->year }}
                </p>
            </div>
        </div>


        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$devolucion->ingresocuenta->creador->name}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$devolucion->ingresocuenta->creador->empleado->documento}}</p>
            </div> 
        </div>

        


       


        <div class="mt-5 d-flex justify-content-between align-items-center" >
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">ENTREGUÉ CONFORME</p>
            </div> 
            
            <div>
                <p style="font-size: 12px">Nasca, {{ $devolucion->ingresocuenta->created_at->day }} de {{ \Illuminate\Support\Str::ucfirst($devolucion->ingresocuenta->created_at->translatedFormat('F')) }} del {{ $devolucion->ingresocuenta->created_at->year }}
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong>
                    {{ $devolucion->representante_cliente_nombre }}</p>
            </div>

            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{ $devolucion->representante_cliente_documento }}
                </p>
            </div>
        </div>


       


        <hr style="margin-top: -5px;">
    </div>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
