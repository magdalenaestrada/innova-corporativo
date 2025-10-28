<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         return Producto::orderBy('nombre_producto')->get();
    }


    public function map($producto):array
    {
        return[
            $producto->id,
            $producto->nombre_producto,
            $producto->stock,
            $producto->precio,
            $producto->ultimoprecio,

            optional($producto->unidad)->nombre ?? '-', 

            $producto->created_at,
        ];
    }


    public function headings():array{
        return[
            'Id',
            'Producto',
            'Stock',
            'Valor Promedio',
            'Último precio',
            'Unidad',
            'Fecha de creación',
        ];
    }
}
