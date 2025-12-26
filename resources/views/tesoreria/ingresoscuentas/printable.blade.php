<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IMPRIMIR INGRESO A LA CUENTA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container pt-2">
        <br>
        <div class="text-end">
            <img  style="width: 90px; margin-top: -1%" src="{{asset('images/Innova.png')}}" alt="">
        </div>

        <div class="text-center" style="margin-top: -8%;">
            <h2>INGRESO {{strtoupper($ingresocuenta->cuenta->nombre)}}</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;" >




        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>SERIE:</strong> 004</h5>
            <h5 class="fs-6"><strong>RECIBO:</strong>AF-{{ $ingresocuenta->id }}</h5>
            <div style="width: 200px">
                @php
                if($ingresocuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                {
                    $coin_simbol = '$';
                }
                else
                {
                    $coin_simbol = 's/';
                }


                @endphp




                <input class="form-control text-center fs-6"  type="text" value="{{$coin_simbol}}{{$ingresocuenta->monto }}">
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
        $amountInWords = $formatter->format(floor($ingresocuenta->monto));
        $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

        $fractionalPart = ($ingresocuenta->monto - floor($ingresocuenta->monto)) * 100;
        $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
        $fractinwords = "{$fractionalPart}/100";

        @endphp

        @php
        $total_monto_soles = $ingresocuenta->tipo_cambio * $ingresocuenta->monto;
        @endphp
        



        <div class="row" style="margin: -10px; font-size: 12px" >
            @if($ingresocuenta->cliente)
            <div class="col-md-6">
                <p style="font-size: 12px"><strong>Recibí de: </strong>{{ $ingresocuenta->cliente->nombre }}</p>
            </div>
            @endif
            @if ($ingresocuenta->tipo_cambio)

            <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px" type="text" value="Tipo cambio: s/{{ $ingresocuenta->tipo_cambio }}">
                    
            </div>
            @endif

            
            @if ($total_monto_soles != 0)

            <div class="col-md-6 row justify-content-end">
                <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px" type="text" value="Conversión: s/{{ $total_monto_soles }}">
            </div>
            @endif
        
        
        
            <div class="col-md-6"  >
                @if($ingresocuenta->motivo)
                    <p><strong>Motivo: </strong>{{ $ingresocuenta->motivo->nombre }}</p>
                @endif
            </div>
        
            
        
            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>La cantidad de: </strong>{{ $amountInWords }} {{ strtolower($ingresocuenta->cuenta->tipomoneda->nombre) }} con {{ $fractinwords }} </p>
            </div>
        
            <div class="col-md-6" style="margin-top: -10px">
                @if($ingresocuenta->tipocomprobante)
                    <p><strong>Tipo comprobante: </strong>{{ $ingresocuenta->tipocomprobante->nombre }}</p>
                @endif
            
            
            </div>

            <div class="col-md-6" style="margin-top: -10px">

                @if($ingresocuenta->comprobante_correlativo)
                <p><strong>Comprobante correlativo: </strong>{{ $ingresocuenta->comprobante_correlativo }}</p>
                @endif
            </div>

        
        
            <div class="col-md-12" style="margin-top: -10px">
                @if($ingresocuenta->descripcion)
                    <p><strong>Descripción: </strong>{{ $ingresocuenta->descripcion }}</p>
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
                <p style="font-size: 12px">Nasca, {{ $ingresocuenta->created_at->day }} de {{ \Illuminate\Support\Str::ucfirst($ingresocuenta->created_at->translatedFormat('F')) }} del {{ $ingresocuenta->created_at->year }}
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$ingresocuenta->creador->name}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$ingresocuenta->creador->empleado->documento}}</p>
            </div> 
        </div>


        <div class="mt-5 d-flex justify-content-between align-items-center" >
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">ENTREGUÉ CONFORME</p>
            </div> 
            
            <div>
               
            </div>
        </div>



        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                @if($ingresocuenta->cliente)
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$ingresocuenta->cliente->nombre}}</p>
                @endif
            </div> 
            
            <div class="text-center">
                @if($ingresocuenta->cliente)
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$ingresocuenta->cliente->documento}}</p>
                @endif
            </div> 
        </div>

    

        <hr style="margin-top: -5px;">
    </div>




    <br>
    <hr style="border-top: 1px dashed #000000;">
        


    <div class="container pt-2">
        <br>
        <div class="text-end">
            <img  style="width: 90px; margin-top: -1%" src="{{asset('images/Innova.png')}}" alt="">
        </div>

        <div class="text-center" style="margin-top: -8%;">
            <h2>INGRESO {{strtoupper($ingresocuenta->cuenta->nombre)}}</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;" >




        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>SERIE:</strong> 004</h5>
            <h5 class="fs-6"><strong>RECIBO:</strong>AF-{{ $ingresocuenta->id }}</h5>
            <div style="width: 200px">
                @php
                if($ingresocuenta->cuenta->tipomoneda->nombre == 'DOLARES')
                {
                    $coin_simbol = '$';
                }
                else
                {
                    $coin_simbol = 's/';
                }


                @endphp




                <input class="form-control text-center fs-6"  type="text" value="{{$coin_simbol}}{{$ingresocuenta->monto }}">
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
        $amountInWords = $formatter->format(floor($ingresocuenta->monto));
        $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

        $fractionalPart = ($ingresocuenta->monto - floor($ingresocuenta->monto)) * 100;
        $fractionalPart = str_pad(floor($fractionalPart), 2, '0', STR_PAD_LEFT); // Ensure two digits
        $fractinwords = "{$fractionalPart}/100";

        @endphp

        @php
        $total_monto_soles = $ingresocuenta->tipo_cambio * $ingresocuenta->monto;
        @endphp
        



        <div class="row" style="margin: -10px; font-size: 12px" >
            @if($ingresocuenta->cliente)
            <div class="col-md-6">
                <p style="font-size: 12px"><strong>Recibí de: </strong>{{ $ingresocuenta->cliente->nombre }}</p>
            </div>
            @endif
            @if ($ingresocuenta->tipo_cambio)

            <div class="col-md-6 row justify-content-end">
                    <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px" type="text" value="Tipo cambio: s/{{ $ingresocuenta->tipo_cambio }}">
                    
            </div>
            @endif

            
            @if ($total_monto_soles != 0)

            <div class="col-md-6 row justify-content-end">
                <input class="form-control text-center " style="width: 300px;font-size: 14px; margin-right:-15px" type="text" value="Conversión: s/{{ $total_monto_soles }}">
            </div>
            @endif
        
        
        
            <div class="col-md-6"  >
                @if($ingresocuenta->motivo)
                    <p><strong>Motivo: </strong>{{ $ingresocuenta->motivo->nombre }}</p>
                @endif
            </div>
        
            
        
            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>La cantidad de: </strong>{{ $amountInWords }} {{ strtolower($ingresocuenta->cuenta->tipomoneda->nombre) }} con {{ $fractinwords }} </p>
            </div>
        
            <div class="col-md-6" style="margin-top: -10px">
                @if($ingresocuenta->tipocomprobante)
                    <p><strong>Tipo comprobante: </strong>{{ $ingresocuenta->tipocomprobante->nombre }}</p>
                @endif
            
            
            </div>

            <div class="col-md-6" style="margin-top: -10px">

                @if($ingresocuenta->comprobante_correlativo)
                <p><strong>Comprobante correlativo: </strong>{{ $ingresocuenta->comprobante_correlativo }}</p>
                @endif
            </div>

        
        
            <div class="col-md-12" style="margin-top: -10px">
                @if($ingresocuenta->descripcion)
                    <p><strong>Descripción: </strong>{{ $ingresocuenta->descripcion }}</p>
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
                <p style="font-size: 12px">Nasca, {{ $ingresocuenta->created_at->day }} de {{ \Illuminate\Support\Str::ucfirst($ingresocuenta->created_at->translatedFormat('F')) }} del {{ $ingresocuenta->created_at->year }}
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$ingresocuenta->creador->name}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$ingresocuenta->creador->empleado->documento}}</p>
            </div> 
        </div>


        <div class="mt-5 d-flex justify-content-between align-items-center" >
            <div class="text-center">
                <p style="margin-bottom: 0; font-size: 12px;">_____________________________________________</p>
                <p style="margin-top: -3px; font-size: 12px;">ENTREGUÉ CONFORME</p>
            </div> 
            
            <div>
               
            </div>
        </div>



        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                @if($ingresocuenta->cliente)
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$ingresocuenta->cliente->nombre}}</p>
                @endif
            </div> 
            
            <div class="text-center">
                @if($ingresocuenta->cliente)
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$ingresocuenta->cliente->documento}}</p>
                @endif
            </div> 
        </div>

    

        <hr style="margin-top: -5px;">
    </div>
    




        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
