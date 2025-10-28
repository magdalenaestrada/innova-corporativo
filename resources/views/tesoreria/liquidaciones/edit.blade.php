@extends('admin.layout')
@section('content')
    <div class="container">
        <br>
        <div class="card">


            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h6 class="mt-2">
                            {{ __('LIQUIDACIÓN') }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-right">
                        <a type="button" class="btn btn-sm btn-danger" href="{{ route('lqliquidaciones.index') }}">
                            VOLVER
                        </a>

                    </div>

                </div>
            </div>

            <div class="card-body">

                <form class="editar-salidacuenta" action="{{ route('lqliquidaciones.update', $liquidacion->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">


                        <div style="margin-top: -1.5%" class=" col-md-12 text-center mb-3">

                            <h5 class="fs-6"><strong>LIQUIDACIÓN:</strong> IN-{{ $liquidacion->id }}</h5>

                        </div>

                        @if ($liquidacion->cliente)
                            <div class="col-md-12 text-right" style="font-size: 13px; margin-top: -2%">
                                <p>RUC: {{ $liquidacion->cliente->documento }} </p><br>
                                <p style=" margin-top: -3%">RAZÓN SOCIAL: {{ $liquidacion->cliente->nombre }}</p>
                            </div>
                        @endif


                        
                        <div style=" margin-top: -2%" class="form-group col-md-5 g-3">
                            <label for="inventarioingreso_fin" class="text-sm">
                                {{ __('CUENTA') }}
                            </label>
                            <input class="form-control form-control-sm" value="{{ $liquidacion->salidacuenta->cuenta->nombre }}" disabled>
                        </div>


                        <div style=" margin-top: -2%" class="form-group col-md-5 g-3">
                            <label for="inventarioingreso_fin" class="text-sm">
                                {{ __('MOTIVO') }}
                            </label>
                            <input class="form-control form-control-sm" value="{{ $liquidacion->salidacuenta->motivo->nombre }}" disabled>
                        </div>



                        <div style=" margin-top: -2%" class="form-group col-md-2 g-3">
                            <label for="inventarioingreso_fin" class="text-sm">
                                {{ __('FECHA') }}
                            </label>
                            <input name="fecha" id="fecha" placeholder="Ingrese la fecha" class="form-control form-control-sm" value="{{ $liquidacion->fecha ? \Carbon\Carbon::parse($liquidacion->fecha)->format('Y-m-d') : '' }}" type="date">
                        </div>



                        @if ($liquidacion->salidacuenta)
                            <div class="form-group col-md-4 g-3">
                                <label for="inventarioingreso_fin" class="text-sm">
                                    {{ __('TIPO COMPROBANTE') }}
                                </label>

                                <input class="form-control form-control-sm" value="{{ $liquidacion->salidacuenta->tipocomprobante ? $liquidacion->salidacuenta->tipocomprobante->nombre : '' }}" placeholder="Tipo comprobante..."
                                    disabled>

                            </div>
                        @endif


                        <div class="form-group col-md-4 g-3">
                            <label for="inventarioingreso_fin" class="text-sm">
                                {{ __('NRO. COMPROBANTE') }}
                            </label>

                            <input class="form-control form-control-sm" value="{{ $liquidacion->salidacuenta->comprobante_correlativo }}" placeholder="Nro comprobante..."
                                disabled>

                        </div>


                        <div class="form-group col-md-4 g-3">
                            <label for="inventarioingreso_fin" class="text-sm">
                                {{ __('RAZÓN SOCIAL DE LA FACTURA') }}
                            </label>

                            <input class="form-control form-control-sm" value="{{ $liquidacion->cliente ? $liquidacion->cliente->nombre : '' }}" placeholder="Tipo comprobante..."
                                disabled>

                        </div>


                        <div class="form-group col-md-4 g-3">
                            <label for="inventarioingreso_fin" class="text-sm">
                                {{ __('DOCUMENTO REPRESENTANTE CLIENTE') }}
                            </label>

                            <input class="form-control form-control-sm" value="{{ $liquidacion->representante_cliente_documento ? $liquidacion->representante_cliente_documento : '' }}" placeholder="Documento representante..."
                                disabled>

                        </div>

                        <div class="form-group col-md-8 g-3">
                            <label for="inventarioingreso_fin" class="text-sm">
                                {{ __('NOMBRE REPRESENTANTE CLIENTE') }}
                            </label>

                            <input class="form-control form-control-sm" value="{{ $liquidacion->representante_cliente_nombre ? $liquidacion->representante_cliente_nombre : '' }}" placeholder="Documento representante..."
                                disabled>

                        </div>



                        @if ($liquidacion->sociedad)
                            <div class="form-group col-md-3 g-3">
                                <label for="inventarioingreso_fin" class="text-sm">
                                    {{ __('SOCIEDAD CÓDIGO') }}
                                </label>

                                <input class="form-control form-control-sm" value="{{ $liquidacion->sociedad->codigo }}"
                                    disabled>

                            </div>
                        @endif



                        @if ($liquidacion->sociedad)
                            <div class="form-group col-md-5 g-3">
                                <label for="inventarioingreso_fin" class="text-sm">
                                    {{ __('SOCIEDAD NOMBRE') }}
                                </label>

                                <input class="form-control form-control-sm" value="{{ $liquidacion->sociedad->nombre }}"
                                    disabled>

                            </div>
                        @endif


                        @if ($liquidacion->creador)
                            <div class="form-group col-md-4 g-3 ">
                                <label for="inventarioingreso_fin" class="text-sm">
                                    {{ __('CREADOR DE LA LIQUIDACIÓN') }}
                                </label>
                                <input class="form-control form-control-sm" value="{{ $liquidacion->creador->name }}"
                                    disabled>
                            </div>
                        @endif



                        @if ($liquidacion->salidacuenta)
                            <div class="form-group col-md-12 g-3">
                                <label for="descripcion" class="text-sm">
                                    {{ __('DESCRIPCION') }}
                                </label>
                                <textarea class="form-control form-control-sm" name="descripcion">{{ $liquidacion->salidacuenta->descripcion ? $liquidacion->salidacuenta->descripcion : 'No hay descripción' }}</textarea>
                            </div>
                        @endif







                        <div class="form-group col-md-12 g-3 text-center">
                            @php
                                if ($liquidacion->salidacuenta->cuenta->tipomoneda->nombre == 'SOLES') {
                                    $coin_simbol = 'S/.   ';
                                } else {
                                    $coin_simbol = '$   ';
                                }

                            @endphp
                            <p class="h5"><strong>LIQUIDACIÓN:</strong>

                                {{ $coin_simbol . '   ' }}
                                {{ number_format($liquidacion->total, 2) ? number_format($liquidacion->total, 2) : 'No hay descripción' }}
                            </p>
                        </div>




                        <div class=" table-responsive text-center" style="margin-top:-10px">

                            @if (count($liquidacion->adelantos) > 0)
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr style="font-size: 14px">
                                            <th scope="col">
                                                {{ __('FECHA') }}
                                            </th>

                                            <th scope="col">
                                                {{ __('TIPO') }}
                                            </th>

                                            <th scope="col">
                                                {{ __('TIPO COMPROBANTE') }}
                                            </th>

                                            <th>
                                                {{ __('COMPROBANTE CORRELALTIVO') }}
                                            </th>


                                            <th scope="col">
                                                {{ __('CUENTA') }}
                                            </th>

                                            <th scope="col">
                                                {{ __('CÓDIGO CLIENTE') }}
                                            </th>




                                            <th scope="col">
                                                {{ __('MOTIVO') }}
                                            </th>

                                            <th scope="col">
                                                {{ __('DESCRIPCIÓN') }}
                                            </th>


                                            <th scope="col">
                                                {{ __('NOMBRE CLIENTE') }}
                                            </th>



                                            <th scope="col">
                                                {{ __('RESPONSABLE') }}
                                            </th>


                                            <th scope="col">
                                                {{ __('MONTO') }}
                                            </th>

                                            <th scope="col">
                                                {{ __('ACCIÓN') }}
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody style="font-size: 13px">
                                        @if (count($liquidacion->adelantos) > 0)
                                            @foreach ($liquidacion->adelantos as $adelanto)
                                                <tr>
                                                    <td scope="row">
                                                        {{ $adelanto->created_at->format('d/m/Y') }}
                                                    </td>

                                                    <td scope="row">
                                                        EGRESO
                                                    </td>

                                                    <td scope="row">
                                                        @if ($adelanto->salidacuenta->tipocomprobante)
                                                            {{ $adelanto->salidacuenta->tipocomprobante->nombre }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td scope="row">
                                                        @if ($adelanto->comprobante_correlativo)
                                                            {{ $adelanto->salidacuenta->cuenta->nombre }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>


                                                    <td scope="row">
                                                        @if ($adelanto->salidacuenta->cuenta)
                                                            {{ $adelanto->salidacuenta->cuenta->nombre }}
                                                        @endif
                                                    </td>


                                                    <td scope="row">
                                                        @if ($adelanto->sociedad)
                                                            {{ $adelanto->sociedad->codigo }}
                                                        @else
                                                            -
                                                        @endif

                                                    </td>

                                                    <td scope="row">
                                                        @if ($adelanto->salidacuenta->motivo)
                                                            {{ $adelanto->salidacuenta->motivo->nombre }}
                                                        @else
                                                            -
                                                        @endif

                                                    </td>


                                                    <td scope="row">
                                                        @if ($adelanto->salidacuenta->descripcion)
                                                            {{ $adelanto->salidacuenta->descripcion }}
                                                        @else
                                                            -
                                                        @endif

                                                    </td>

                                                    <td scope="row">
                                                        @if ($adelanto->sociedad)
                                                            {{ $adelanto->sociedad->nombre }}
                                                        @else
                                                            -
                                                        @endif

                                                    </td>

                                                    <td>
                                                        {{ $adelanto->creador->name }}
                                                    </td>




                                                    <td scope="row">
                                                        @php
                                                            if (
                                                                $adelanto->salidacuenta->cuenta->tipomoneda->nombre ==
                                                                'DOLARES'
                                                            ) {
                                                                $coin_simbol = '$';
                                                            } else {
                                                                $coin_simbol = 's/';
                                                            }

                                                        @endphp

                                                        @if ($adelanto->salidacuenta)
                                                            {{ $coin_simbol }}{{ $adelanto->salidacuenta->monto }}
                                                        @else
                                                            -
                                                        @endif

                                                    </td>


                                                    <td class="btn-group align-items-center">

                                                        <a href="{{ route('lqadelantos.printdoc', $adelanto->id) }}"
                                                            class="btnprn" style="margin-left: 5px;">

                                                            <div class="printer">
                                                                <div class="paper">

                                                                    <svg viewBox="0 0 8 8" class="svg">
                                                                        <path fill="#0077FF"
                                                                            d="M6.28951 1.3867C6.91292 0.809799 7.00842 0 7.00842 0C7.00842 0 6.45246 0.602112 5.54326 0.602112C4.82505 0.602112 4.27655 0.596787 4.07703 0.595012L3.99644 0.594302C1.94904 0.594302 0.290039 2.25224 0.290039 4.29715C0.290039 6.34206 1.94975 8 3.99644 8C6.04312 8 7.70284 6.34206 7.70284 4.29715C7.70347 3.73662 7.57647 3.18331 7.33147 2.67916C7.08647 2.17502 6.7299 1.73327 6.2888 1.38741L6.28951 1.3867ZM3.99679 6.532C2.76133 6.532 1.75875 5.53084 1.75875 4.29609C1.75875 3.06133 2.76097 2.06018 3.99679 2.06018C4.06423 2.06014 4.13163 2.06311 4.1988 2.06905L4.2414 2.07367C4.25028 2.07438 4.26057 2.0758 4.27406 2.07651C4.81533 2.1436 5.31342 2.40616 5.67465 2.81479C6.03589 3.22342 6.23536 3.74997 6.23554 4.29538C6.23554 5.53084 5.23439 6.532 3.9975 6.532H3.99679Z">
                                                                        </path>
                                                                        <path fill="#0055BB"
                                                                            d="M6.756 1.82386C6.19293 2.09 5.58359 2.24445 4.96173 2.27864C4.74513 2.17453 4.51296 2.10653 4.27441 2.07734C4.4718 2.09225 5.16906 2.07947 5.90892 1.66374C6.04642 1.58672 6.1743 1.49364 6.28986 1.38647C6.45751 1.51849 6.61346 1.6647 6.756 1.8235V1.82386Z">
                                                                        </path>
                                                                    </svg>

                                                                </div>
                                                                <div class="dot"></div>
                                                                <div class="output">
                                                                    <div class="paper-out"></div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </td>



                                                </tr>
                                            @endforeach

                                            <tr class="table-warning">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>TOTAL</td>
                                                <td>DESCUENTOS</td>
                                                <td>POR</td>
                                                <td> ADELANTOS: </td>
                                                <td>{{ $coin_simbol }}{{ $liquidacion->descuento }}</td>
                                                <td></td>

                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="15" class="text-center text-muted">
                                                    {{ __('No hay datos disponibles') }}
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            @endif
                        </div>



                    </div>

                    <div class="row">
                        <div class="form-group mt-1 col-md-6 g-3">
                            <label for="otros_descuentos" class="text-sm">
                                {{ __('OTROS DESCUENTOS') }}
                            </label>
                            <input type="text" class="form-control form-control-sm" id="otros_descuentos" disabled
                                value="{{ $coin_simbol . '   ' }}{{ $liquidacion->otros_descuentos ? number_format($liquidacion->otros_descuentos, 2) : '0.00' }}">
                        </div>




                        <div class="form-group mt-1 col-md-6 g-3">
                            <label for="otros_descuentos" class="text-sm">
                                {{ __('MONTO PAGADO') }}
                            </label>
                            <input name="monto" type="text" class="form-control form-control-sm" id="monto"
                                value="{{ $liquidacion->salidacuenta->monto }}">
                        </div>


                        <div class="form-group mt-1 col-md-6 g-3">
                            <label for="otros_descuentos" class="text-sm">
                                {{ __('TIPO DE CAMBIO') }}
                            </label>
                            <input name="tipo_cambio" type="text" class="form-control form-control-sm"
                                id="tipo_cambio" value="{{ $liquidacion->tipo_cambio }}">
                        </div>


                        <div class="col-md-12 text-right g-3">
                            <button type="submit" class="btn btn-secondary btn-sm">
                                {{ __('Guardar') }}
                            </button>
                        </div>





                    </div>


            </div>




            </form>


        </div>

    </div>
    </div>
@stop
