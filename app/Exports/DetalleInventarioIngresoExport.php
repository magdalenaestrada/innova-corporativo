<?php

namespace App\Exports;

use App\Models\Detalleinventarioingreso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DetalleInventarioIngresoExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Detalleinventarioingreso::all();
    }


    public function map($detalle):array
    {
        return[
            $detalle->inventarioingreso_id,
            optional($detalle->inventarioingreso->proveedor)->ruc ?? '-', 
            optional($detalle->inventarioingreso->proveedor)->razon_social ?? '-', 
            optional($detalle->inventarioingreso)->comprobante_correlativo ?? '-', 
            optional($detalle->producto)->nombre_producto ?? '-', 

            $detalle->precio,
            optional($detalle->inventarioingreso)->tipomoneda ?? '-', 
            $detalle->cantidad,
            $detalle->cantidad_ingresada,
            $detalle->guiaingresoalmacen,
            $detalle->estado,
            $detalle->subtotal,


            $detalle->created_at,
        ];
    }


    public function headings():array
    {
        return[
            'Orden de compra',
            'Ruc proveedor',
            'Razón social proveedor',
            'Comprobante correlativo',
            'Producto',
            'Valor Unitario',
            'Moneda',
            'Cantidad Ordenada',
            'Cantidad Ingresada',
            'Guia ingreso almacen',
            'Estado',
            'Subtotal',
            'Fecha de creación',
        ];
    }
}
