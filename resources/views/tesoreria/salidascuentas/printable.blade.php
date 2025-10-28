<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IMPRIMIR SALIDA DE LA CUENTA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container pt-2">
        <br>
        <div class="text-end">
            <img  style="width: 90px; margin-top: -1%" src="{{asset('images/agrotrac.jpeg')}}" alt="">
        </div>

        <div class="text-center" style="margin-top: -8%;">
            <h2>SALIDA {{strtoupper($salidacuenta->cuenta->nombre)}}</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;" >


        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>SERIE:</strong> 005</h5>
            <h5 class="fs-6"><strong>RECIBO:</strong> AF-{{ $salidacuenta->id }}</h5>
            <div style="width: 200px">
                @php
                if($salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                {
                    $coin_simbol = '$';
                }
                else
                {
                    $coin_simbol = 'S/. ';
                }


                @endphp




                <input class="form-control text-center fs-6"  type="text" value="{{$coin_simbol}}{{ number_format($salidacuenta->monto,2) }}">
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
        $amountInWords = $formatter->format(floor($salidacuenta->monto));
        $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

        $fractionalPart = ($salidacuenta->monto - floor($salidacuenta->monto)) * 100;
        $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
        $fractinwords = "{$fractionalPart}/100";

        @endphp

        @php
        $total_monto_soles = $salidacuenta->tipo_cambio * $salidacuenta->monto;
        @endphp
        


   
        <div class="row" style="margin: -10px; font-size: 12px" >
            @if($salidacuenta->creador)
            <div class="col-md-6">
                <p style="font-size: 12px"><strong>RECIBÍ DE: </strong>{{ $salidacuenta->creador->name }}</p>
            </div>
            @endif
            @if ($salidacuenta->tipo_cambio)

            <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px" type="text" value="Tipo cambio: s/{{ $salidacuenta->tipo_cambio }}">
                    
            </div>
            @endif

            
            @if ($total_monto_soles != 0)

            <div class="col-md-6 row justify-content-end">
                <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px" type="text" value="Conversión: s/{{ $total_monto_soles }}">
            </div>
            @endif
        
           
        
            <div class="col-md-6"  >
                @if($salidacuenta->motivo)
                    <p><strong>MOTIVO: </strong>{{ $salidacuenta->motivo->nombre }}</p>
                @endif
            </div>
        
            
        
            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>LA CANTIDAD DE: </strong>{{ $amountInWords }} {{ strtolower($salidacuenta->cuenta->tipomoneda->nombre) }} con {{ $fractinwords }} </p>
            </div>
        
            <div class="col-md-6" style="margin-top: -10px">
                @if($salidacuenta->tipocomprobante)
                    <p><strong>TIPO COMPROBANTE: </strong>{{ $salidacuenta->tipocomprobante->nombre }}</p>
                @endif
            
               
            </div>

            <div class="col-md-6" style="margin-top: -10px">

                @if($salidacuenta->comprobante_correlativo)
                <p><strong>COMPROBANTE CORRELATIVO: </strong>{{ $salidacuenta->comprobante_correlativo }}</p>
                @endif
            </div>

        
           
            <div class="col-md-12" style="margin-top: -10px">
                @if($salidacuenta->descripcion)
                    <p><strong>DESCRIPPCIÓN: </strong>{{ $salidacuenta->descripcion }}</p>
                @endif
            </div>
        </div>
        

        

        <hr style="margin-top: -1%;" >

        <div class="mt-5 d-flex justify-content-between align-items-center" >
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">RECIBÍ CONFORME</p>
            </div> 
            
            <div>
                <p style="font-size: 12px">Nasca, {{ $salidacuenta->created_at->day }} de {{ \Illuminate\Support\Str::ucfirst($salidacuenta->created_at->translatedFormat('F')) }} del {{ $salidacuenta->created_at->year }}
                </p>
            </div>
        </div>

        


        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>NOMBRES Y APELLIDOS:</strong> {{optional($salidacuenta->beneficiario)->nombre}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{optional($salidacuenta->beneficiario)->documento}}</p>
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
            <img  style="width: 90px; margin-top: -1%" src="{{asset('images/agrotrac.jpeg')}}" alt="">
        </div>

        <div class="text-center" style="margin-top: -8%;">
            <h2>SALIDA {{strtoupper($salidacuenta->cuenta->nombre)}}</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;" >


        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>SERIE:</strong> 005</h5>
            <h5 class="fs-6"><strong>RECIBO:</strong> AF-{{ $salidacuenta->id }}</h5>
            <div style="width: 200px">
                @php
                if($salidacuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                {
                    $coin_simbol = '$';
                }
                else
                {
                    $coin_simbol = 'S/. ';
                }


                @endphp


                <input class="form-control text-center fs-6"  type="text" value="{{$coin_simbol}}{{ number_format($salidacuenta->monto,2) }}">
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
        $amountInWords = $formatter->format(floor($salidacuenta->monto));
        $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

        $fractionalPart = ($salidacuenta->monto - floor($salidacuenta->monto)) * 100;
        $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
        $fractinwords = "{$fractionalPart}/100";

        @endphp

        @php
        $total_monto_soles = $salidacuenta->tipo_cambio * $salidacuenta->monto;
        @endphp
        

   
        <div class="row" style="margin: -10px; font-size: 12px" >
            @if($salidacuenta->creador)
            <div class="col-md-6">
                <p style="font-size: 12px"><strong>RECIBÍ DE: </strong>{{ $salidacuenta->creador->name }}</p>
            </div>
            @endif
            @if ($salidacuenta->tipo_cambio)

            <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px" type="text" value="Tipo cambio: s/{{ $salidacuenta->tipo_cambio }}">
                    
            </div>
            @endif

            
            @if ($total_monto_soles != 0)

            <div class="col-md-6 row justify-content-end">
                <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px" type="text" value="Conversión: s/{{ $total_monto_soles }}">
            </div>
            @endif
        
           
        
            <div class="col-md-6"  >
                @if($salidacuenta->motivo)
                    <p><strong>MOTIVO: </strong>{{ $salidacuenta->motivo->nombre }}</p>
                @endif
            </div>
        
            
        
            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>LA CANTIDAD DE: </strong>{{ $amountInWords }} {{ strtolower($salidacuenta->cuenta->tipomoneda->nombre) }} con {{ $fractinwords }} </p>
            </div>
        
            <div class="col-md-6" style="margin-top: -10px">
                @if($salidacuenta->tipocomprobante)
                    <p><strong>TIPO COMPROBANTE: </strong>{{ $salidacuenta->tipocomprobante->nombre }}</p>
                @endif
            
               
            </div>

            <div class="col-md-6" style="margin-top: -10px">

                @if($salidacuenta->comprobante_correlativo)
                <p><strong>COMPROBANTE CORRELATIVO: </strong>{{ $salidacuenta->comprobante_correlativo }}</p>
                @endif
            </div>

           
            <div class="col-md-12" style="margin-top: -10px">
                @if($salidacuenta->descripcion)
                    <p><strong>DESCRIPPCIÓN: </strong>{{ $salidacuenta->descripcion }}</p>
                @endif
            </div>
        </div>
        

        

        <hr style="margin-top: -1%;" >

        <div class="mt-5 d-flex justify-content-between align-items-center" >
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">RECIBÍ CONFORME</p>
            </div> 
            
            <div>
                <p style="font-size: 12px">Nasca, {{ $salidacuenta->created_at->day }} de {{ \Illuminate\Support\Str::ucfirst($salidacuenta->created_at->translatedFormat('F')) }} del {{ $salidacuenta->created_at->year }}
                </p>
            </div>
        </div>

        


        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>NOMBRES Y APELLIDOS:</strong> {{optional($salidacuenta->beneficiario)->nombre}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{optional($salidacuenta->beneficiario)->documento}}</p>
            </div> 
        </div>

       

        <hr style="margin-top: -5px;">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
