<?php

namespace App\Exports;

use App\Models\TsIngresoCuenta;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TsIngresoCuentaExport implements FromCollection, WithHeadings, WithMapping
{


    protected $cuenta_id;
    protected $motivo_id;
    protected $tipo_comprobante_id;
    protected $start_date;
    protected $end_date;




    public function __construct($cuenta_id=null, $motivo_id=null, $tipo_comprobante_id=null, $start_date=null, $end_date=null )
    {
        $this->cuenta_id = $cuenta_id;
        $this->motivo_id = $motivo_id;
        $this->tipo_comprobante_id = $tipo_comprobante_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }




    public function collection()
    {
        $query = TsIngresoCuenta::query();

        if ($this->cuenta_id){
            $query->where('cuenta_id', $this->cuenta_id);
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
            'CUENTA',
            'MOTIVO',
            'TIPO DE COMPROBANTE',
            'CORRELATIVO DEL COMPROBANTE',
            'DESCRIPCIÓN',
            'FECHA DE CREACION',

        ];
    }




    public function map($ingresocuenta):array
    {
        return[
            $ingresocuenta->id,
            $ingresocuenta->monto,
            optional($ingresocuenta->cuenta)->nombre ?? '-', 
            optional($ingresocuenta->motivo)->nombre ?? '-', 
            optional($ingresocuenta->tipocomprobante)->nombre ?? '-', 

            $ingresocuenta->comprobante_correlativo,
            $ingresocuenta->descripcion,


            $ingresocuenta->created_at,
        ];
    }




}
