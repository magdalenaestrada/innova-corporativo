<?php

namespace App\Exports;

use App\Models\NotaPedido;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class CombustibleExport implements FromView, WithTitle
{
    protected $placa;
    protected $desde;
    protected $hasta;

    public function __construct($placa, $desde, $hasta)
    {
        $this->placa = $placa;
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function view(): View
    {
        $query = NotaPedido::with(['detalles.producto'])
            ->whereBetween('fecha_creacion', [$this->desde, $this->hasta])
            ->where('estado', 'A')
            ->orderBy('fecha_creacion');

        if ($this->placa) {
            $query->where('placa_vehiculo', $this->placa);
        }

        $notas = $query->get()->groupBy('placa_vehiculo');
        $data = [];

        foreach ($notas as $placa => $lista) {
            if ($lista->isEmpty()) continue;

            // Ordenar por kilometraje para coherencia
            $lista = $lista->sortBy('kilometraje')->values();

            $productos = [];
            $observaciones = [];
            $total_km = 0;

            for ($i = 1; $i < $lista->count(); $i++) {
                $anterior = $lista[$i - 1];
                $actual = $lista[$i];

                $km_recorrido = $actual->kilometraje - $anterior->kilometraje;

                if ($km_recorrido <= 0) {
                    $observaciones[] = "Kilometraje irregular en {$placa} ({$actual->kilometraje} < {$anterior->kilometraje}) en {$actual->fecha_creacion}.";
                    continue;
                }

                $total_km += $km_recorrido;

                foreach ($actual->detalles as $detalle) {
                    $nombre = $detalle->producto->nombre ?? 'Sin nombre';
                    $productos[$nombre] = ($productos[$nombre] ?? 0) + $detalle->cantidad;
                }
            }

            $km_inicial = $lista->min('kilometraje');
            $km_final   = $lista->max('kilometraje');

            foreach ($productos as $nombre => $cantidad) {
                $consumo_por_km = $total_km > 0 ? round($cantidad / $total_km, 3) : 0;

                $data[] = [
                    'placa'            => $placa,
                    'fecha_inicio'     => $this->desde,
                    'fecha_fin'        => $this->hasta,
                    'km_inicial'       => $km_inicial,
                    'km_final'         => $km_final,
                    'km_recorridos'    => $total_km,
                    'producto'         => $nombre,
                    'cantidad_total'   => $cantidad,
                    'consumo_por_km'   => $consumo_por_km,
                    'observaciones'    => implode("\n", $observaciones),
                ];
            }
        }

        return view('notas.export', [
            'data'  => $data,
            'desde' => $this->desde,
            'hasta' => $this->hasta,
            'placa' => $this->placa,
        ]);
    }

    public function title(): string
    {
        return 'Reporte de Combustible';
    }
}
