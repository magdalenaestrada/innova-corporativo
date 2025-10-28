<?php

namespace App\Exports;

use App\Models\TsSalidacaja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TsSalidaCajaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $caja_id;
    protected $motivo_id;
    protected $tipo_comprobante_id;
    protected $start_date;
    protected $end_date;
    public function __construct($caja_id=null, $motivo_id=null, $tipo_comprobante_id=null, $start_date=null, $end_date=null )
    {
        $this->caja_id = $caja_id;
        $this->motivo_id = $motivo_id;
        $this->tipo_comprobante_id = $tipo_comprobante_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }



    public function collection()
    {
        $query = TsSalidacaja::query();

        if ($this->caja_id){
            $query->where('caja_id', $this->caja_id);
        }

        if ($this->motivo_id){
            $query->where('motivo_id', $this->motivo_id);
        }

        if ($this->tipo_comprobante_id){
            $query->where('tipo_comprobante_id', $this->tipo_comprobante_id);
        }


        if ($this->start_date) {
            $query->where('created_at', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->where('created_at', '<=', $this->end_date);
        }




        return $query->get();
    }




    public function headings():array{
        return[
            'ID',
            'MONTO',
            'CAJA',
            'MOTIVO',
            'TIPO DE COMPROBANTE',
            'CORRELATIVO DEL COMPROBANTE',
            'DESCRIPCIÓN',
            'FECHA DE CREACION',

        ];
    }

    public function map($salidacaja):array
    {
        return[
            $salidacaja->id,
            $salidacaja->monto,
            optional($salidacaja->caja)->nombre ?? '-', 
            optional($salidacaja->motivo)->nombre ?? '-', 
            optional($salidacaja->tipocomprobante)->nombre ?? '-', 

            $salidacaja->comprobante_correlativo,
            $salidacaja->descripcion,


            $salidacaja->created_at,
        ];
    }


}
