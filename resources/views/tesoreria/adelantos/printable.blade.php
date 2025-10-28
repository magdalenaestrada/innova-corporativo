<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IMPRIMIR ADELANTO CLIENTE</title>
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
            <h2>{{ strtoupper('CLIENTES ADELANTOS') }}</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;">

        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>{{ strtoupper('RECIBO:') }}</strong> 001</h5>
            <h5 class="fs-6"><strong>{{ strtoupper('ADELANTO:') }}</strong> AF-{{ $adelanto->id }}</h5>
            <div style="width: 200px">
                @php
                    if ($adelanto->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                        $coin_simbol = '$';
                    } else {
                        $coin_simbol = 's/';
                    }
                @endphp

                @if ($adelanto->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ $adelanto->salidacuenta->monto }}">
                @else
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ round($adelanto->salidacuenta->monto / $adelanto->tipo_cambio, 2) }}">
                @endif
            </div>
        </div>

        <hr style="margin-top: 5px;">

        @php
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            $amountInWords = $formatter->format(floor($adelanto->salidacuenta->monto));
            $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

            $fractionalPart = ($adelanto->salidacuenta->monto - floor($adelanto->salidacuenta->monto)) * 100;
            $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
            $fractinwords = "{$fractionalPart}/100";
        @endphp

        @php
            if ($adelanto->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                $total_monto_soles = $adelanto->tipo_cambio * $adelanto->salidacuenta->monto;
            } else {
                $total_monto_soles = $adelanto->salidacuenta->monto;
            }
        @endphp

        <div class="row" style="margin: -10px; font-size: 12px">
            <div class="col-md-6">
                <p style="font-size: 12px"><strong>{{ strtoupper('Recibí de:') }}</strong>
                    {{ strtoupper($adelanto->creador->name) }}</p>
            </div>
            @if ($adelanto->tipo_cambio && $coin_simbol != '$')
                <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px"
                        type="text" value="{{ strtoupper('Tipo cambio: s/') }}{{ $adelanto->tipo_cambio }}">
                </div>
            @endif

            <div class="col-md-6">
                <p><strong>{{ strtoupper('Sociedad:') }}</strong> {{ strtoupper($adelanto->sociedad->nombre) }}</p>
            </div>
            @if ($total_monto_soles != 0 && $coin_simbol != '$')
                <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px"
                        type="text" value="{{ strtoupper('Conversión: s/') }}{{ $total_monto_soles }}">
                </div>
            @endif

            <div class="col-md-6" style="margin-top: -10px">
                @if ($adelanto->salidacuenta->motivo)
                    <p><strong>{{ strtoupper('Motivo:') }}</strong>
                        {{ strtoupper($adelanto->salidacuenta->motivo->nombre) }}</p>
                @endif
            </div>

            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>{{ strtoupper('La cantidad de:') }}</strong> {{ strtoupper($amountInWords) }} CON
                    {{ strtoupper($fractinwords) }}
                    {{ strtoupper($adelanto->salidacuenta->cuenta->tipomoneda->nombre) }}</p>
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($adelanto->salidacuenta->tipocomprobante)
                    <p><strong>{{ strtoupper('Tipo comprobante:') }}</strong>
                        {{ strtoupper($adelanto->salidacuenta->tipocomprobante->nombre) }}</p>
                @endif
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($adelanto->salidacuenta->comprobante_correlativo)
                    <p><strong>{{ strtoupper('Comprobante correlativo:') }}</strong>
                        {{ strtoupper($adelanto->salidacuenta->comprobante_correlativo) }}</p>
                @endif
            </div>

            <div class="col-md-12" style="margin-top: -10px">
                @if ($adelanto->descripcion)
                    <p><strong>{{ strtoupper('Descripción:') }}</strong> {{ strtoupper($adelanto->descripcion) }}</p>
                @endif
            </div>
        </div>

        <hr style="margin-top: -1%;">

        <div class="mt-5 d-flex justify-content-between align-items-center">
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">{{ strtoupper('RECIBÍ CONFORME') }}</p>
            </div>

            <div>
                <p style="font-size: 12px">{{ 'Nasca' }} {{ $adelanto->fecha->day }}
                    {{ 'de' }}
                    {{ \Illuminate\Support\Str::ucfirst($adelanto->fecha->translatedFormat('F')) }}
                    {{ 'del' }} {{ $adelanto->fecha->year }}</p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>{{ strtoupper('Nombres y Apellidos:') }}</strong>
                    {{ strtoupper($adelanto->representante_cliente_nombre) }}</p>
            </div>

            <div class="text-center">
                <p style="font-size: 12px;"><strong>{{ strtoupper('DNI:') }}</strong>
                    {{ strtoupper($adelanto->representante_cliente_documento) }}</p>
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
            <h2>{{ strtoupper('CLIENTES ADELANTOS') }}</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;">

        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>{{ strtoupper('RECIBO:') }}</strong> 001</h5>
            <h5 class="fs-6"><strong>{{ strtoupper('ADELANTO:') }}</strong> AF-{{ $adelanto->id }}</h5>
            <div style="width: 200px">
                @php
                    if ($adelanto->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                        $coin_simbol = '$';
                    } else {
                        $coin_simbol = 's/';
                    }
                @endphp

                @if ($adelanto->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ $adelanto->salidacuenta->monto }}">
                @else
                    <input class="form-control text-center fs-6" type="text"
                        value="${{ round($adelanto->salidacuenta->monto / $adelanto->tipo_cambio, 2) }}">
                @endif
            </div>
        </div>

        <hr style="margin-top: 5px;">

        @php
            $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
            $amountInWords = $formatter->format(floor($adelanto->salidacuenta->monto));
            $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

            $fractionalPart = ($adelanto->salidacuenta->monto - floor($adelanto->salidacuenta->monto)) * 100;
            $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
            $fractinwords = "{$fractionalPart}/100";
        @endphp

        @php
            if ($adelanto->salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES') {
                $total_monto_soles = $adelanto->tipo_cambio * $adelanto->salidacuenta->monto;
            } else {
                $total_monto_soles = $adelanto->salidacuenta->monto;
            }
        @endphp

        <div class="row" style="margin: -10px; font-size: 12px">
            <div class="col-md-6">
                <p style="font-size: 12px"><strong>{{ strtoupper('Recibí de:') }}</strong>
                    {{ strtoupper($adelanto->creador->name) }}</p>
            </div>
            @if ($adelanto->tipo_cambio && $coin_simbol != '$')
                <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px"
                        type="text" value="{{ strtoupper('Tipo cambio: s/') }}{{ $adelanto->tipo_cambio }}">
                </div>
            @endif

            <div class="col-md-6">
                <p><strong>{{ strtoupper('Sociedad:') }}</strong> {{ strtoupper($adelanto->sociedad->nombre) }}</p>
            </div>
            @if ($total_monto_soles != 0 && $coin_simbol != '$')
                <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px"
                        type="text" value="{{ strtoupper('Conversión: s/') }}{{ $total_monto_soles }}">
                </div>
            @endif

            <div class="col-md-6" style="margin-top: -10px">
                @if ($adelanto->salidacuenta->motivo)
                    <p><strong>{{ strtoupper('Motivo:') }}</strong>
                        {{ strtoupper($adelanto->salidacuenta->motivo->nombre) }}</p>
                @endif
            </div>

            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>{{ strtoupper('La cantidad de:') }}</strong> {{ strtoupper($amountInWords) }} CON
                    {{ strtoupper($fractinwords) }}
                    {{ strtoupper($adelanto->salidacuenta->cuenta->tipomoneda->nombre) }}</p>
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($adelanto->salidacuenta->tipocomprobante)
                    <p><strong>{{ strtoupper('Tipo comprobante:') }}</strong>
                        {{ strtoupper($adelanto->salidacuenta->tipocomprobante->nombre) }}</p>
                @endif
            </div>

            <div class="col-md-6" style="margin-top: -10px">
                @if ($adelanto->salidacuenta->comprobante_correlativo)
                    <p><strong>{{ strtoupper('Comprobante correlativo:') }}</strong>
                        {{ strtoupper($adelanto->salidacuenta->comprobante_correlativo) }}</p>
                @endif
            </div>

            <div class="col-md-12" style="margin-top: -10px">
                @if ($adelanto->descripcion)
                    <p><strong>{{ strtoupper('Descripción:') }}</strong> {{ strtoupper($adelanto->descripcion) }}</p>
                @endif
            </div>
        </div>

        <hr style="margin-top: -1%;">

        <div class="mt-5 d-flex justify-content-between align-items-center">
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">{{ strtoupper('RECIBÍ CONFORME') }}</p>
            </div>

            <div>
                <p style="font-size: 12px">{{ 'Nasca' }} {{ $adelanto->fecha->day }}
                    {{ 'de' }}
                    {{ \Illuminate\Support\Str::ucfirst($adelanto->fecha->translatedFormat('F')) }}
                    {{ 'del' }} {{ $adelanto->fecha->year }}</p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>{{ strtoupper('Nombres y Apellidos:') }}</strong>
                    {{ strtoupper($adelanto->representante_cliente_nombre) }}</p>
            </div>

            <div class="text-center">
                <p style="font-size: 12px;"><strong>{{ strtoupper('DNI:') }}</strong>
                    {{ strtoupper($adelanto->representante_cliente_documento) }}</p>
            </div>
        </div>

        <hr style="margin-top: -5px;">
    </div>









    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
