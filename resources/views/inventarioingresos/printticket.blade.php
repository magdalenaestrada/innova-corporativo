<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Orden de compra #AF-{{ $inventarioingreso->id }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{
      --txt:#1f2937; --muted:#6b7280; --line:#e5e7eb; --head:#111827; --thead:#f3f4f6; --chip:#eef6ff;
      --radius:12px;
    }
    @page{ size:A4; margin:18mm; }
    @media print{ body{-webkit-print-color-adjust:exact; print-color-adjust:exact; } }
    html,body{ font-family:ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Arial; color:var(--txt); font-size:12px; }
    .doc{ position:relative; }

    /* Marca de agua */
    .watermark{
      position:fixed; top:50%; left:50%; transform:translate(-50%,-50%);
      opacity:.06; z-index:0; pointer-events:none; width:70%; max-width:520px;
    }
    .watermark img{ width:100%; }

    /* Header */
    .doc-header{
      position:relative; z-index:1; margin-bottom:10px;
      display:grid; grid-template-columns:1fr auto; align-items:center; gap:8px;
    }
    .brand{ display:flex; align-items:center; gap:10px; }
    .brand img{ width:56px; height:auto; object-fit:contain; }
    .doc-title{ text-align:center; grid-column:1/-1; font-weight:700; color:var(--head); margin-top:-6px; letter-spacing:.5px; }
    .muted{ color:var(--muted); }
    hr{ border:none; border-top:1px solid var(--line); margin:8px 0; }

    /* Tarjetas */
    .grid-2{ display:grid; grid-template-columns:1fr 1fr; gap:12px; position:relative; z-index:1; }
    .card{
      border:1px solid var(--line); border-radius:var(--radius); padding:12px; background:#fff;
      box-shadow:0 1px 0 rgba(0,0,0,.02);
    }
    .card h4{ margin:0 0 8px 0; font-size:12px; color:var(--head); letter-spacing:.3px }
    .kv{ display:grid; grid-template-columns:1.2fr 2.2fr; gap:6px; padding:6px 0; align-items:center; }
    .kv+.kv{ border-top:1px dashed #eee; }
    .label{ color:var(--muted); }
    .value{ font-weight:600; }

    /* Tabla de items */
    table.items{ width:100%; border-collapse:collapse; margin-top:12px; position:relative; z-index:1; }
    table.items thead th{ background:var(--thead); font-weight:600; border:1px solid var(--line); padding:8px; text-align:center; }
    table.items tbody td{ border:1px solid var(--line); padding:8px; vertical-align:middle; }
    .text-right{text-align:right} .text-center{text-align:center}

    /* Totales */
    .totals{ width:50%; margin-left:auto; margin-top:8px; border-collapse:collapse; position:relative; z-index:1; }
    .totals td{ padding:6px 8px; border:1px solid var(--line); }
    .totals tr td:first-child{ background:var(--thead); font-weight:600; }
    .grand{ font-weight:800; font-size:13px; }

    /* Tabla de pagos/adelantos */
    table.slim{ width:100%; border-collapse:collapse; margin-top:12px; }
    table.slim thead th{ background:var(--thead); font-weight:600; border:1px solid var(--line); padding:8px; text-align:center; }
    table.slim tbody td{ border:1px solid var(--line); padding:8px; vertical-align:middle; }
  </style>
</head>
<body>
  <!-- Marca de agua AGROTRAC -->
  <div class="watermark">
    <img src="{{ asset('images/Innova.png') }}" alt="Marca de agua Agrotrac">
  </div>

  <div class="doc">
    <!-- Header -->
    <div class="doc-header">
      <div class="brand">
        <img src="{{ asset('images/Innova.png') }}" alt="Logo Innova">
        <div>
          <div style="font-weight:700">GRUPO INNOVA CORPORATIVO S.A.C.</div>
          <div class="muted" style="font-size:11px">RUC 20613573691</div>
        </div>
      </div>
      <div class="text-end">
        <div><span class="muted">Orden:</span> <strong>AF-{{ $inventarioingreso->id }}</strong></div>
        <div>Nasca, {{ $inventarioingreso->created_at->day }}
          de {{ \Illuminate\Support\Str::ucfirst($inventarioingreso->created_at->translatedFormat('F')) }}
          del {{ $inventarioingreso->created_at->year }}</div>
      </div>
      <h3 class="doc-title">ORDEN DE COMPRA</h3>
    </div>

    <hr>

    <!-- Tarjetas -->
    <div class="grid-2">
      <div class="card">
        <h4>Datos del Cliente</h4>
        <div class="kv"><div class="label">Razón Social</div><div class="value"> S.A.C</div></div>
        <div class="kv"><div class="label">RUC</div><div class="value">20613573691</div></div>
        <div class="kv"><div class="label">Estado</div><div class="value">{{ $inventarioingreso->estado }}</div></div>
        <div class="kv"><div class="label">Cotización</div><div class="value">{{ $inventarioingreso->cotizacion }}</div></div>
      </div>

      <div class="card">
        <h4>Datos del Proveedor</h4>
        @if ($inventarioingreso->proveedor)
          <div class="kv"><div class="label">Razón Social</div><div class="value">{{ $inventarioingreso->proveedor->razon_social }}</div></div>
          <div class="kv"><div class="label">RUC</div><div class="value">{{ $inventarioingreso->proveedor->ruc }}</div></div>
          <div class="kv"><div class="label">Teléfono</div><div class="value">{{ $inventarioingreso->proveedor->telefono ?? '-' }}</div></div>
          <div class="kv"><div class="label">Dirección</div><div class="value">{{ $inventarioingreso->proveedor->direccion ?? '-' }}</div></div>
        @else
          <div class="kv"><div class="label">Proveedor</div><div class="value">—</div></div>
        @endif
      </div>
    </div>

    <!-- Tabla de productos -->
    @if ($inventarioingreso->productos->count())
      <table class="items">
        <thead>
          <tr>
            <th>PRODUCTO DEL REQUERIMIENTO</th>
            <th style="width:100px">CANTIDAD</th>
            <th style="width:140px">VALOR UNITARIO</th>
            <th style="width:140px">SUBTOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($inventarioingreso->productos as $producto)
            <tr>
              <td>{{ $producto->nombre_producto }}</td>
              <td class="text-center">{{ number_format($producto->pivot->cantidad, 0) }}</td>
              <td class="text-right">{{ number_format($producto->pivot->precio, 2) }}</td>
              <td class="text-right">{{ number_format($producto->pivot->subtotal, 2) }}</td>
            </tr>
          @endforeach
          <tr>
            <td colspan="3" class="text-right"><strong>SUMA</strong></td>
            <td class="text-right">
              {{ $inventarioingreso->suma > 0
                ? number_format($inventarioingreso->suma, 2)
                : number_format($inventarioingreso->subtotal, 2) }}
            </td>
          </tr>
        </tbody>
      </table>
    @endif

    <!-- Totales -->
    @php
      $mon = strtoupper($inventarioingreso->tipomoneda);
      $igv = round($inventarioingreso->subtotal * 0.18, 2);
    @endphp
    <table class="totals">
      <tr><td>DESCUENTO</td><td class="text-right">{{ number_format($inventarioingreso->descuento, 2) }} {{ $mon }}</td></tr>
      <tr><td>SUBTOTAL</td><td class="text-right">{{ number_format($inventarioingreso->subtotal, 2) }} {{ $mon }}</td></tr>
      <tr><td>IGV (18%)</td><td class="text-right">{{ number_format($igv, 2) }} {{ $mon }}</td></tr>
      <tr class="grand"><td>PRECIO TOTAL</td><td class="text-right">{{ number_format($inventarioingreso->total, 2) }} {{ $mon }}</td></tr>
    </table>

    <!-- Pagos a cuenta / Adelantos -->
    @if ($inventarioingreso->pagosacuenta && $inventarioingreso->pagosacuenta->count())
      <div class="card" style="margin-top:12px; position:relative; z-index:1;">
        <h4>Pagos a cuenta / Adelantos</h4>
        <table class="slim">
          <thead>
            <tr>
              <th style="width:180px">FECHA DE PAGO</th>
              <th style="width:140px">MONTO</th>
              <th>COMPROBANTE / CORRELATIVO</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($inventarioingreso->pagosacuenta as $pago)
              <tr>
                <td class="text-center">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                <td class="text-right">{{ number_format($pago->monto,2) }} {{ $mon }}</td>
                <td class="text-center">{{ $pago->comprobante_correlativo }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  {{-- <script>window.print()</script> --}}
</body>
</html>
