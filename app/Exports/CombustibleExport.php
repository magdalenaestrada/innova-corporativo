<?php

namespace App\Exports;

use App\Models\NotaPedido;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

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
        // Filtramos por rango de fechas y (opcionalmente) placa
        $query = NotaPedido::with(['detalles.producto'])
            ->whereBetween('fecha_creacion', [$this->desde, $this->hasta])
            ->orderBy('placa_vehiculo');

        if ($this->placa) {
            $query->where('placa_vehiculo', $this->placa);
        }

        $notas = $query->get()->groupBy('placa_vehiculo');

        $data = [];

        foreach ($notas as $placa => $lista) {
            // Ordenar las notas por fecha
            $lista = $lista->sortBy('fecha_creacion');

            $km_inicial = $lista->first()->kilometraje ?? 0;
            $km_final = $lista->last()->kilometraje ?? 0;
            $km_recorrido = max(0, $km_final - $km_inicial);

            // Agrupar por producto (gasolina, petróleo, etc.)
            $productos = [];
            foreach ($lista as $nota) {
                foreach ($nota->detalles as $detalle) {
                    $producto = $detalle->producto->nombre ?? 'Sin nombre';
                    if (!isset($productos[$producto])) {
                        $productos[$producto] = 0;
                    }
                    $productos[$producto] += $detalle->cantidad;
                }
            }

            foreach ($productos as $nombre => $cantidad) {
                $consumo_por_km = $km_recorrido > 0 ? $cantidad / $km_recorrido : 0;

                $data[] = [
                    'placa' => $placa,
                    'fecha_inicio' => $this->desde,
                    'fecha_fin' => $this->hasta,
                    'km_inicial' => $km_inicial,
                    'km_final' => $km_final,
                    'km_recorridos' => $km_recorrido,
                    'producto' => $nombre,
                    'cantidad_total' => $cantidad,
                    'consumo_por_km' => round($consumo_por_km, 3),
                ];
            }
        }

        return view('notas.export', [
            'data' => $data,
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
