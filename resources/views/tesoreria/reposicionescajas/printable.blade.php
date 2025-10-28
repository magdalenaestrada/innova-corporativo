<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IMPRIMIR REPOSICIÓN DE LA CAJA</title>
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
            <h2>REPOSICIÓN DE CAJA</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;" >




        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>SERIE:</strong> 003</h5>
            <h5 class="fs-6"><strong>RECIBO:</strong> AF-{{ $reposicioncaja->id }}</h5>
            <div style="width: 200px">
                




                <input class="form-control text-center fs-6"  type="text" value="s/{{$reposicioncaja->monto }}">
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
        $amountInWords = $formatter->format(floor($reposicioncaja->monto));
        $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

        $fractionalPart = ($reposicioncaja->monto - floor($reposicioncaja->monto)) * 100;
        $fractinwords = $formatter->format( floor($fractionalPart));

        @endphp

        @php
        $total_monto_soles = $reposicioncaja->tipo_cambio * $reposicioncaja->monto;
        @endphp
        


   
        <div class="row" style="margin: -10px; font-size: 12px" >
            
            <div class="col-md-6">
                <p style="font-size: 12px"><strong>Recibí de: </strong>{{ $reposicioncaja->creador->name }}</p>
            </div>
            

            
            
        
           
        
            <div class="col-md-6" style="" >
                @if($reposicioncaja->motivo)
                    <p><strong>Motivo: </strong>{{ $reposicioncaja->motivo->nombre }}</p>
                @endif
            </div>
        
            
        
            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>La cantidad de: </strong>{{ $amountInWords }} soles con {{ $fractinwords }} centavos</p>
            </div>
        
            

        
           
            <div class="col-md-12" style="margin-top: -10px">
                @if($reposicioncaja->descripcion)
                    <p><strong>Descripción: </strong>{{ $reposicioncaja->descripcion }}</p>
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
                <p style="font-size: 12px">Nasca, {{ $reposicioncaja->created_at->day }} de {{ \Illuminate\Support\Str::ucfirst($reposicioncaja->created_at->translatedFormat('F')) }} del {{ $reposicioncaja->created_at->year }}
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$reposicioncaja->caja->encargados[0]->nombre}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$reposicioncaja->caja->encargados[0]->documento}}</p>
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
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$reposicioncaja->creador->name}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$reposicioncaja->creador->empleado->documento}}</p>
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
            <h2>REPOSICIÓN DE CAJA</h2>
            <br>
        </div>
        <hr style="margin-top:-0.5%;" >




        <div style="margin-top: -1.5%;" class="d-flex justify-content-between align-items-center">
            <h5 class="fs-6"><strong>SERIE:</strong> 003</h5>
            <h5 class="fs-6"><strong>RECIBO:</strong> AF-{{ $reposicioncaja->id }}</h5>
            <div style="width: 200px">
                




                <input class="form-control text-center fs-6"  type="text" value="s/{{$reposicioncaja->monto }}">
            </div>
        </div>


        <hr style="margin-top: 5px;">

        @php
        $formatter = new \NumberFormatter('es', \NumberFormatter::SPELLOUT);
        $amountInWords = $formatter->format(floor($reposicioncaja->monto));
        $amountInWords = ucfirst($amountInWords); // Capitaliza la primera letra

        $fractionalPart = ($reposicioncaja->monto - floor($reposicioncaja->monto)) * 100;
        $fractinwords = $formatter->format( floor($fractionalPart));

        @endphp

        @php
        $total_monto_soles = $reposicioncaja->tipo_cambio * $reposicioncaja->monto;
        @endphp
        


   
        <div class="row" style="margin: -10px; font-size: 12px" >
            
            <div class="col-md-6">
                <p style="font-size: 12px"><strong>Recibí de: </strong>{{ $reposicioncaja->creador->name }}</p>
            </div>
            

            
            
        
           
        
            <div class="col-md-6" style="" >
                @if($reposicioncaja->motivo)
                    <p><strong>Motivo: </strong>{{ $reposicioncaja->motivo->nombre }}</p>
                @endif
            </div>
        
            
        
            <div class="col-md-12" style="margin-top: -10px">
                <p><strong>La cantidad de: </strong>{{ $amountInWords }} soles con {{ $fractinwords }} centavos</p>
            </div>
        
            

        
           
            <div class="col-md-12" style="margin-top: -10px">
                @if($reposicioncaja->descripcion)
                    <p><strong>Descripción: </strong>{{ $reposicioncaja->descripcion }}</p>
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
                <p style="font-size: 12px">Nasca, {{ $reposicioncaja->created_at->day }} de {{ \Illuminate\Support\Str::ucfirst($reposicioncaja->created_at->translatedFormat('F')) }} del {{ $reposicioncaja->created_at->year }}
                </p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: -10px;">
            <div class="text-center">
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$reposicioncaja->caja->encargados[0]->nombre}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$reposicioncaja->caja->encargados[0]->documento}}</p>
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
                <p style="font-size: 12px;"><strong>Nombres y Apellidos:</strong> {{$reposicioncaja->creador->name}}</p>
            </div> 
            
            <div class="text-center">
                <p style="font-size: 12px;"><strong>DNI: </strong>{{$reposicioncaja->creador->empleado->documento}}</p>
            </div> 
        </div>

       

        <hr style="margin-top: -5px;">
    </div>

   
    

    




        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
