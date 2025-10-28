<?php

namespace App\Exports;

use App\Models\LqAdelanto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class LqAdelantoExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{


    protected $string;

    public function __construct($string = null)
    {
        $this->string = $string;
    }


    public function collection()
    {

        $query = LqAdelanto::query();

        $query->where(function ($subQuery) {
            $subQuery->whereHas('sociedad', function ($query) {
                $query->where('nombre', 'like', '%' . $this->string . '%')
                    ->orWhere('codigo', 'like', '%' . $this->string . '%');
            })->orWhereHas('salidacuenta', function ($query) {
                $query->where('monto', 'like', '%' . $this->string . '%');
            })->orWhere('descripcion', 'like', '%' . $this->string . '%')
                ->orWhere('total_sin_detraccion', 'like', '%' . $this->string . '%');
        });

        $query->orderBy('fecha', 'desc');

        return $query->get();
    }






    public function headings(): array
    {
        return [
            'ID',
            'FECHA',
            'CLASE',
            'TIPO COMPROB.',
            'NRO COMPROB.',
            'CUENTA',
            'CÓDIGO CLIENTE',
            'MOTIVO',
            'DESCRIPCIÓN',
            'NOMBRE CLIENTE',
            'RESPONSABLE',
            'SIN DETRACCIÓN',
            'MONTO',
            'MONEDA',
            'CERRADO',
            

        ];
    }



    public function map($adelanto): array
    {
        $creatorName = optional($adelanto->creador)->name ?? '-';
            if ($creatorName !== '-') {
                $parts = explode(' ', $creatorName);
                $creatorName = isset($parts[2]) ? $parts[0] . ' ' . $parts[2] : $parts[0];
            }
        return [
            $adelanto->id,

            


            $adelanto->fecha->format('d/m/Y'),
            'ADELANTO',

            optional(value: $adelanto->salidacuenta->tipocomprobante)->nombre ?? '-',
            optional(value: $adelanto->salidacuenta)->comprobante_correlativo ?? '-',
            optional(value: $adelanto->salidacuenta->cuenta)->nombre ?? '-',
            
            optional(value: $adelanto->sociedad)->codigo ?? '-',
            optional($adelanto->salidacuenta->motivo)->nombre ?? '-',
            optional($adelanto->salidacuenta)->descripcion ?? '-',
            optional(value: $adelanto->sociedad)->nombre ?? '-',
            $creatorName,


            optional(value: $adelanto)->total_sin_detraccion ?? '-',
            optional(value: $adelanto->salidacuenta)->monto ?? '-',


            optional($adelanto->salidacuenta->cuenta->tipomoneda)->nombre ?? '-',
            
            $adelanto->cerrado ? 'SI' : 'NO',



        ];
    }




    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:O1')->getFont()->setBold(true)->setSize(10); // Title row styling
        $sheet->getStyle('A1:O1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:O1')->getFill()->getStartColor()->setARGB('D9E7DC'); // Set background color
        
        
        
        
        
        $sheet->getStyle('A1:O1')->getAlignment()->setHorizontal('center');
        $mergedCellsRanges = ['A1:O1'];
        foreach ($mergedCellsRanges as $range) {
            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        }


  

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(10.3);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(15.1);
        $sheet->getColumnDimension('G')->setWidth(8);
        $sheet->getColumnDimension('H')->setWidth(10.3);
        $sheet->getColumnDimension('I')->setWidth(27);
        $sheet->getColumnDimension('J')->setWidth(23);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(12);
        $sheet->getColumnDimension('M')->setWidth(12);
        $sheet->getColumnDimension('N')->setWidth(9);

   
        $sheet->getStyle('A1:Z500')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Z700')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:Z700')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:O700')->getFont()->setSize(9);
    }
}
