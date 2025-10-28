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
            <img style="width: 90px; margin-top: -1%" src="{{ asset('images/agrotrac.jpeg') }}" alt="">
        </div>

        <div class="text-center" style="margin-top: -8%;">
            <h2>CLIENTES LIQUIDACIONES</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;">




        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>RECIBO:</strong> 002</h5>
            <h5 class="fs-6"><strong>LIQUIDACIÓN:</strong> AF-{{ $liquidacion->id }}</h5>
            <div style="width: 200px">
                @php
                    if ($liquidacion->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                        $coin_simbol = '$';
                    } else {
                        $coin_simbol = 's/';
                    }

                @endphp


                @if ($liquidacion->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ number_format($liquidacion->salidacuenta->monto,2    ) }}">
                @else
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ number_format(round($liquidacion->salidacuenta->monto / $liquidacion->tipo_cambio, 2),2) }}">
                @endif
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            $amountInWords = $formatter->format(floor($liquidacion->salidacuenta->monto));
            $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

            $fractionalPart = ($liquidacion->salidacuenta->monto - floor($liquidacion->salidacuenta->monto)) * 100;
            $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
            $fractinwords = "{$fractionalPart}/100";

        @endphp

        @php
            if ($liquidacion->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                $total_monto_soles = $liquidacion->tipo_cambio * $liquidacion->salidacuenta->monto;
            } else {
                $total_monto_soles = $liquidacion->salidacuenta->monto;
            }
        @endphp




        <div class="row" style="margin: -10px; font-size: 12px">

            <div class="col-md-6">
                <p style="font-size: 12px"><strong>RECIBÍ DE: </strong>{{ $liquidacion->creador->name }}</p>
            </div>
            @if ($liquidacion->tipo_cambio && $coin_simbol != '$')
                <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px"
                        type="text" value="TIPO CAMBIO: s/{{ number_format($liquidacion->tipo_cambio,2) }}">

                </div>
            @endif

            <div class="col-md-6">
                <p><strong>SOCIEDAD: </strong>{{ strtoupper($liquidacion->sociedad->nombre) }}</p>
            </div>
            @if ($total_monto_soles != 0 && $coin_simbol != '$')
                <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px"
                        type="text" value="CONVERSIÓN: s/{{ number_format($total_monto_soles,2) }}">
                </div>
            @endif



            <div class="col-md-6" style="margin-top: -10px">
                @if ($liquidacion->salidacuenta->motivo)
                    <p><strong>MOTIVO: </strong>{{ $liquidacion->salidacuenta->motivo->nombre }}</p>
                @endif
            </div>



            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>LA CANTIDAD DE: </strong>{{ strtoupper($amountInWords) }}
                     CON {{ $fractinwords }} {{ strtoupper($liquidacion->salidacuenta->cuenta->tipomoneda->nombre) }}
                </p>
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($liquidacion->salidacuenta->tipocomprobante)
                    <p><strong>TIPO COMPROBANTE: </strong>{{ $liquidacion->salidacuenta->tipocomprobante->nombre }}</p>
                @endif


            </div>

            <div class="col-md-6" style="margin-top: -10px">

                @if ($liquidacion->salidacuenta->comprobante_correlativo)
                    <p><strong>COMPROBANTE CORRELATIVO:
                        </strong>{{ strtoupper($liquidacion->salidacuenta->comprobante_correlativo) }}</p>
                @endif
            </div>



            <div class="col-md-12" style="margin-top: -10px">
                @if ($liquidacion->salidacuenta->descripcion)
                    <p><strong>DESCRIPCIÓN: </strong>{{ strtoupper($liquidacion->salidacuenta->descripcion) }}</p>
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
                <p style="font-size: 12px">Nasca, {{ $liquidacion->created_at->day }} de
                    {{ \Illuminate\Support\Str::ucfirst($liquidacion->created_at->translatedFormat('F')) }} del
                    {{ $liquidacion->created_at->year }}
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong>
                    {{ $liquidacion->representante_cliente_nombre }}</p>
            </div>

            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{ $liquidacion->representante_cliente_documento }}
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
            <img style="width: 90px; margin-top: -1%" src="{{ asset('images/agrotrac.jpeg') }}" alt="">
        </div>

        <div class="text-center" style="margin-top: -8%;">
            <h2>CLIENTES LIQUIDACIONES</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;">




        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>RECIBO:</strong> 002</h5>
            <h5 class="fs-6"><strong>LIQUIDACIÓN:</strong> AF-{{ $liquidacion->id }}</h5>
            <div style="width: 200px">
                @php
                    if ($liquidacion->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                        $coin_simbol = '$';
                    } else {
                        $coin_simbol = 's/';
                    }

                @endphp


                @if ($liquidacion->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ number_format($liquidacion->salidacuenta->monto,2    ) }}">
                @else
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ number_format(round($liquidacion->salidacuenta->monto / $liquidacion->tipo_cambio, 2),2) }}">
                @endif
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            $amountInWords = $formatter->format(floor($liquidacion->salidacuenta->monto));
            $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

            $fractionalPart = ($liquidacion->salidacuenta->monto - floor($liquidacion->salidacuenta->monto)) * 100;
            $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
            $fractinwords = "{$fractionalPart}/100";

        @endphp

        @php
            if ($liquidacion->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                $total_monto_soles = $liquidacion->tipo_cambio * $liquidacion->salidacuenta->monto;
            } else {
                $total_monto_soles = $liquidacion->salidacuenta->monto;
            }
        @endphp




        <div class="row" style="margin: -10px; font-size: 12px">

            <div class="col-md-6">
                <p style="font-size: 12px"><strong>RECIBÍ DE: </strong>{{ $liquidacion->creador->name }}</p>
            </div>
            @if ($liquidacion->tipo_cambio && $coin_simbol != '$')
                <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px"
                        type="text" value="TIPO CAMBIO: s/{{ number_format($liquidacion->tipo_cambio,2) }}">

                </div>
            @endif

            <div class="col-md-6">
                <p><strong>SOCIEDAD: </strong>{{ strtoupper($liquidacion->sociedad->nombre) }}</p>
            </div>
            @if ($total_monto_soles != 0 && $coin_simbol != '$')
                <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px"
                        type="text" value="CONVERSIÓN: s/{{ number_format($total_monto_soles,2) }}">
                </div>
            @endif



            <div class="col-md-6" style="margin-top: -10px">
                @if ($liquidacion->salidacuenta->motivo)
                    <p><strong>MOTIVO: </strong>{{ $liquidacion->salidacuenta->motivo->nombre }}</p>
                @endif
            </div>



            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>LA CANTIDAD DE: </strong>{{ strtoupper($amountInWords) }}
                     CON {{ $fractinwords }} {{ strtoupper($liquidacion->salidacuenta->cuenta->tipomoneda->nombre) }}
                </p>
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($liquidacion->salidacuenta->tipocomprobante)
                    <p><strong>TIPO COMPROBANTE: </strong>{{ $liquidacion->salidacuenta->tipocomprobante->nombre }}</p>
                @endif


            </div>

            <div class="col-md-6" style="margin-top: -10px">

                @if ($liquidacion->salidacuenta->comprobante_correlativo)
                    <p><strong>COMPROBANTE CORRELATIVO:
                        </strong>{{ strtoupper($liquidacion->salidacuenta->comprobante_correlativo) }}</p>
                @endif
            </div>



            <div class="col-md-12" style="margin-top: -10px">
                @if ($liquidacion->salidacuenta->descripcion)
                    <p><strong>DESCRIPCIÓN: </strong>{{ strtoupper($liquidacion->salidacuenta->descripcion) }}</p>
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
                <p style="font-size: 12px">Nasca, {{ $liquidacion->created_at->day }} de
                    {{ \Illuminate\Support\Str::ucfirst($liquidacion->created_at->translatedFormat('F')) }} del
                    {{ $liquidacion->created_at->year }}
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong>
                    {{ $liquidacion->representante_cliente_nombre }}</p>
            </div>

            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{ $liquidacion->representante_cliente_documento }}
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
