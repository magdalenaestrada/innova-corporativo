<?php

namespace App\Exports;

use App\Models\Peso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PesoExport implements FromCollection , WithHeadings

{
    protected $observacion;
    protected $producto;
    protected $startDate;
    protected $endDate;

    public function __construct($observacion = null, $producto = null, $startDate = null, $endDate = null)
    {
        $this->observacion = $observacion;
        $this->producto = $producto;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }


    
    public function collection()
    {
        $query = Peso::query();

        if ($this->observacion) {
            $query->where('Observacion', $this->observacion);
        }

        if ($this->producto) {
            $query->where('Producto', $this->producto);
        }

        if ($this->startDate) {
            $query->where('Fechas', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->where('Fechas', '<=', $this->endDate);
        }

        return $query->get();
    }



    public function headings():array{
        return[
            'NroSalida',
            'Horas',
            'Fechas',
            'Fechai',
            'Horai',
            'Pesoi',
            'Pesos',
            'Bruto',
            'Tara',
            'Neto',
            'Placa',
            'Observación',
            'Producto',
            'Conductor',
            'Transportista',
            'Razon Social',
            'Operadori',
            'Destarado',
            'Operadors',
            'Carreta',
            'Guia',
            'Guiat',
            'Pedido',
            'Entrega',
            'UM',
            'Peso Guia',
            'RUCR',
            'RUCT',
            'Destino',
            'Origen',
            'Brevete',
            'Pbmax',
            'Tipo',
            'Centro',
            'Nia',
            'Bodega',
            'Ip',
            'Anular',
            'Eje',
            'Pesaje',
        ];
    }


}
