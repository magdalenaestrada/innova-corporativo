<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IMPRIMIR SALIDA DE LA CAJA "{{$salidacaja->caja->nombre}}"</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

        <div class="container pt-2">
            <br>
            <div class="text-end">
                <img style="width: 80px; margin-top: -1%" src="{{ asset('images/Innova.png') }}" alt="">
            </div>

            <div class="text-center" style="margin-top: -8%;">
                <h4 style="text-transform: uppercase;">SALIDA DE CAJA - {{$salidacaja->caja->nombre}}</h4>
                <br>
            </div>
            <hr style="margin-top:-0.5%;">

            <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
                <h5 class="fs-6"><strong>RECIBO:</strong> 009</h5>
                <h5 class="fs-6"><strong>SALIDA DE LA CAJA:</strong> IN-{{ $salidacaja->id }}</h5>
                <div style="width: 200px">
                    <input class="form-control text-center fs-6" type="text" value="S/.    {{ $salidacaja->monto }}"
                        style="text-transform: uppercase;">
                </div>
            </div>

            <hr style="margin-top: 5px;">

            @php
                $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
                $amountInWords = $formatter->format(floor($salidacaja->monto));
                $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

                $fractionalPart = ($salidacaja->monto - floor($salidacaja->monto)) * 100;
                $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
                $fractinwords = "{$fractionalPart}/100";
            @endphp

            @php
                $total_monto_soles = $salidacaja->monto;
            @endphp

            <div class="row" style="margin: -10px; font-size: 12px; text-transform: uppercase;">

                <div class="col-md-6">
                    <p style="font-size: 12px"><strong>RECIBÍ DE: </strong>{{ $salidacaja->creador->name }}</p>
                </div>

                <div class="col-md-6">
                    @if ($salidacaja->motivo)
                        <p><strong>MOTIVO: </strong>{{ $salidacaja->motivo->nombre }}</p>
                    @endif
                </div>

                <div class="col-md-12" style="margin-top: -10px">
                    <p><strong>LA CANTIDAD DE: </strong>{{ $amountInWords }}
                        con {{ $fractinwords }} SOLES
                    </p>
                </div>

                <div class="col-md-6" style="margin-top: -10px">
                    @if ($salidacaja->tipocomprobante)
                        <p><strong>TIPO COMPROBANTE: </strong>{{ $salidacaja->tipocomprobante->nombre }}</p>
                    @endif
                </div>

                <div class="col-md-6" style="margin-top: -10px">
                    @if ($salidacaja->comprobante_correlativo)
                        <p><strong>NRO COMPROBANTE:</strong>{{ $salidacaja->comprobante_correlativo }}</p>
                    @endif
                </div>

                <div class="col-md-12" style="margin-top: -10px">
                    @if ($salidacaja->descripcion)
                        <p><strong>DESCRIPCIÓN: </strong>{{ $salidacaja->descripcion }}</p>
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
                    <p style="font-size: 12px">Nasca, {{ $salidacaja->created_at->day }} de
                        {{ \Illuminate\Support\Str::ucfirst($salidacaja->created_at->translatedFormat('F')) }} del
                        {{ $salidacaja->created_at->year }}
                    </p>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
                <div class="text-center">
                    <p style="font-size: 12px;"><strong>NOMBRES Y APELLIDOS:</strong>
                        {{ optional($salidacaja->beneficiario)->nombre }}</p>
                </div>
            
                <div class="text-center">
                    <p style="font-size: 12px;"><strong>DNI: </strong>{{ optional($salidacaja->beneficiario)->documento }}
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
            <img style="width: 80px; margin-top: -1%" src="{{ asset('images/Innova.png') }}" alt="">
        </div>

        <div class="text-center" style="margin-top: -8%;">
            <h4 style="text-transform: uppercase;">SALIDA DE CAJA - {{$salidacaja->caja->nombre}}</h4>
            <br>
        </div>
        <hr style="margin-top:-0.5%;">

        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>RECIBO:</strong> 009</h5>
            <h5 class="fs-6"><strong>SALIDA DE LA CAJA:</strong> IN-{{ $salidacaja->id }}</h5>
            <div style="width: 200px">
                <input class="form-control text-center fs-6" type="text" value="S/.    {{ $salidacaja->monto }}"
                    style="text-transform: uppercase;">
            </div>
        </div>

        <hr style="margin-top: 5px;">

        @php
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            $amountInWords = $formatter->format(floor($salidacaja->monto));
            $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

            $fractionalPart = ($salidacaja->monto - floor($salidacaja->monto)) * 100;
            $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
            $fractinwords = "{$fractionalPart}/100";
        @endphp

        @php
            $total_monto_soles = $salidacaja->monto;
        @endphp

        <div class="row" style="margin: -10px; font-size: 12px; text-transform: uppercase;">

            <div class="col-md-6">
                <p style="font-size: 12px"><strong>RECIBÍ DE: </strong>{{ $salidacaja->creador->name }}</p>
            </div>

            <div class="col-md-6">
                @if ($salidacaja->motivo)
                    <p><strong>MOTIVO: </strong>{{ $salidacaja->motivo->nombre }}</p>
                @endif
            </div>

            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>LA CANTIDAD DE: </strong>{{ $amountInWords }}
                    con {{ $fractinwords }} SOLES
                </p>
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($salidacaja->tipocomprobante)
                    <p><strong>TIPO COMPROBANTE: </strong>{{ $salidacaja->tipocomprobante->nombre }}</p>
                @endif
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($salidacaja->comprobante_correlativo)
                    <p><strong>NRO COMPROBANTE:</strong>{{ $salidacaja->comprobante_correlativo }}</p>
                @endif
            </div>

            <div class="col-md-12" style="margin-top: -10px">
                @if ($salidacaja->descripcion)
                    <p><strong>DESCRIPCIÓN: </strong>{{ $salidacaja->descripcion }}</p>
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
                <p style="font-size: 12px">Nasca, {{ $salidacaja->created_at->day }} de
                    {{ \Illuminate\Support\Str::ucfirst($salidacaja->created_at->translatedFormat('F')) }} del
                    {{ $salidacaja->created_at->year }}
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>NOMBRES Y APELLIDOS:</strong>
                    {{ optional($salidacaja->beneficiario)->nombre }}</p>
            </div>
        
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{ optional($salidacaja->beneficiario)->documento }}
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
