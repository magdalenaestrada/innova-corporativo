@php
    $coin_simbol = $cuenta->tipomoneda->nombre == 'DOLARES' ? '$' : 'S/.';

@endphp
@if ($ingresoscuentas)
    @if (count($ingresoscuentas) > 0)
        @foreach ($ingresoscuentas as $ingreso)
            <tr class="table-success text-center">

                <td scope="row">
                    {{ $ingreso->id }}
                </td>
                <td scope="row">
                    {{ $ingreso->fecha->format('d/m/Y') }}
                </td>
                <td>
                    <span class="badge bg-success">INGRESO</span>
                </td>

                <td>-</td>
                <td>-</td>
                <td scope="row">
                    @if ($ingreso->tipocomprobante)
                        {{ strtoupper($ingreso->tipocomprobante->nombre) }}
                    @else
                        -
                    @endif
                </td>
                <td scope="row">
                    @if ($ingreso->comprobante_correlativo)
                        {{ strtoupper($ingreso->comprobante_correlativo) }}
                    @else
                        -
                    @endif
                </td>
                <td scope="row">
                    @if ($ingreso->motivo)
                        {{ strtoupper($ingreso->motivo->nombre) }}
                    @else
                        -
                    @endif
                </td>
                <td scope="row">
                    @if ($ingreso->descripcion)
                        {{ strtoupper($ingreso->descripcion) }}
                    @else
                        -
                    @endif
                </td>
                <td scope="row">
                    <div class="d-flex justify-content-between">
                        <p>{{ $coin_simbol }}</p>
                        @if ($ingreso->monto)
                            <p> {{ number_format($ingreso->monto, 2) }}</p>
                        @else
                            0
                        @endif
                    </div>
                    
                </td>
                <td scope="row">
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="14" class="text-center text-muted">
                {{ __('No hay ingresos') }}
            </td>
        </tr>
    @endif
@else
    <tr>
        <td colspan="14" class="text-center text-muted">
            {{ __('No hay ingresos') }}
        </td>
    </tr>
@endif
@if ($salidascuentas)
    @if (count($salidascuentas) > 0)
        @foreach ($salidascuentas as $salida)
            <tr class="table-danger text-center">
                <td>
                    {{ $salida->id }}

                </td>
                <td scope="row">
                    {{ $salida->fecha->format('d/m/Y') }}
                </td>
                <td>
                    <span class="badge bg-danger">{{ strtoupper('egreso') }}</span>
                    @if ($salida->reposicioncaja)
                        <span class="badge bg-warning">{{ strtoupper('reposicion') }}</span>
                    @endif

                    @if ($salida->liquidacion)
                        <span class="badge bg-navy">{{ strtoupper('liquidación') }}</span>
                    @endif

                    @if ($salida->adelanto)
                        <span class="badge bg-light">{{ strtoupper('adelanto') }}</span>
                    @endif
                </td>

                <td>
                    @if ($salida->reposicioncaja)
                        {{ strtoupper($salida->reposicioncaja->caja->nombre) }}
                    @else
                        -
                    @endif
                </td>

                <td>
                    @if ($salida->adelanto)
                        {{ strtoupper($salida->adelanto->sociedad->nombre) }}
                    @elseif ($salida->liquidacion)
                        {{ strtoupper($salida->liquidacion->sociedad->nombre) }}
                    @else
                        -
                    @endif
                </td>



                <td scope="row">
                    @if ($salida->tipocomprobante)
                        {{ strtoupper($salida->tipocomprobante->nombre) }}
                    @else
                        -
                    @endif

                </td>

                <td scope="row">
                    @if ($salida->comprobante_correlativo)
                        {{ strtoupper($salida->comprobante_correlativo) }}
                    @else
                        -
                    @endif

                </td>

                <td scope="row">
                    @if ($salida->motivo)
                        {{ strtoupper($salida->motivo->nombre) }}
                    @else
                        -
                    @endif

                </td>



                <td scope="row">
                    @if ($salida->descripcion)
                        {{ strtoupper($salida->descripcion) }}
                    @else
                        -
                    @endif

                </td>




                <td scope="row">


                    <div class="d-flex justify-content-between">
                        <p>{{ $coin_simbol }}</p>
                        @if ($salida->monto)
                            <p> {{ number_format($salida->monto, 2) }}</p>
                        @else
                            0
                        @endif

                    </div>

              
                </td>


                <td>
                    <div style="display: flex; justify-content: center">
                        @if ($salida->reposicioncaja)
                            <a href="#" data-toggle="modal"
                                data-target="#ModalShow{{ $salida->reposicioncaja->id }}">
                                <button class="button-reporte-detalle">
                                    <svg viewBox="0 0 384 512" class="svgIcon">
                                        <path
                                            d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z">
                                        </path>
                                    </svg>
                                </button>
                            </a>
                        @endif
                    </div>

                </td>






            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="14" class="text-center text-muted">
                {{ __('No hay salidas') }}
            </td>
        </tr>
    @endif
@else
    <tr>
        <td colspan="14" class="text-center text-muted">
            {{ __('No hay salidas') }}
        </td>
    </tr>
@endif
