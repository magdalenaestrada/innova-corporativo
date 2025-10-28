@if (count($salidascajas) > 0)
    @foreach ($salidascajas as $salidacaja)
        <tr>

            <td>{{ $salidacaja->id }}</td>

            <td scope="row">
                {{ \Carbon\Carbon::parse($salidacaja->created_at)->format('d/m/Y H:i') }}
            </td>






            <td scope="row">
                @if ($salidacaja->caja)
                    {{ strtoupper($salidacaja->caja->nombre) }}
                @endif
            </td>

            <td scope="row">
                @if ($salidacaja->tipocomprobante)
                    {{ strtoupper($salidacaja->tipocomprobante->nombre) }}
                @endif
            </td>

            <td scope="row">
                @if ($salidacaja->comprobante_correlativo)
                    {{ strtoupper($salidacaja->comprobante_correlativo) }}
                @else
                    IN-{{ $salidacaja->id }}
                @endif


            </td>

            <td scope="row">
                @if ($salidacaja->fecha_comprobante)
                    {{ \Carbon\Carbon::parse($salidacaja->fecha_comprobante)->format('d/m/Y') }}
                @endif
            </td>



            <td scope="row">
                @if ($salidacaja->motivo)
                    {{ strtoupper($salidacaja->motivo->nombre) }}
                @endif


            </td>


            <td scope="row">
                @if ($salidacaja->motivo)
                    {{ strtoupper($salidacaja->reposicion_id) }}
                @endif


            </td>



            <td scope="row">
                @if ($salidacaja->beneficiario)
                    {{ strtoupper($salidacaja->beneficiario->nombre) }}
                @endif


            </td>


            <td scope="row">
                {{ $salidacaja->descripcion }}

            </td>
            <td scope="row" style="min-width: 100px">

                <div class="d-flex justify-content-between">
                    <p>S/.</p>
                    <p> -{{ number_format($salidacaja->monto, 2) }}</p>
                </div>

            </td>



        </tr>
    @endforeach
@else
    <tr>
        <td colspan="13" class="text-center text-muted">
            {{ __('No hay datos disponibles') }}
        </td>
    </tr>
@endif
