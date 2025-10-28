<?php

namespace App\Exports;

use App\Models\TsSalidaCuenta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TsSalidaCuentaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{


    protected $string;
    protected $desde;
    protected $hasta;
    protected $start_date;
    protected $end_date;


    public function __construct($string = null, $desde = null, $hasta = null)
    {
        $this->string = $string;
        $this->desde = $desde;
        $this->hasta = $hasta;
    }



    public function collection()
    {
        // Get date range from request with default values
        $desdeDate = Carbon::parse($this->desde)->startOfDay();
        $hastaDate = Carbon::parse($this->hasta)->endOfDay();

        // Query with filters applied
        $salidascuentas = TsSalidaCuenta::whereBetween('fecha', [$desdeDate, $hastaDate])
            ->where(function ($query) {
                // Assuming $this->search_string is available in the context
                $searchString = $this->string;

                $query->where('descripcion', 'like', '%' . $searchString . '%')
                    ->orWhere('comprobante_correlativo', 'like', '%' . $searchString . '%')
                    ->orWhereHas('tipocomprobante', function ($subQuery) use ($searchString) {
                        $subQuery->where('nombre', 'like', '%' . $searchString . '%');
                    })
                    ->orWhereHas('motivo', function ($subQuery) use ($searchString) {
                        $subQuery->where('nombre', 'like', '%' . $searchString . '%');
                    })
                    ->orWhereHas('beneficiario', function ($subQuery) use ($searchString) {
                        $subQuery->where('nombre', 'like', '%' . $searchString . '%');
                    })
                    ->orWhere('monto', 'like', '%' . $searchString . '%');
            })
            ->orderBy('fecha', 'desc')
            ->get();

        return $salidascuentas;
    }




    public function headings(): array
    {
        return [
            'ID',
            'FECHA',

            'TIPO',
            'CLASE',
            'TIPO COMPROBANTE',
            'NRO COMPROBANTE',
            'CUENTA',
            'MOTIVO',
            'DESCRIPCIÓN',
            'NOMBRE BENEFICIARIO',
            'RESPONSABLE',
            'MONTO',

        ];
    }



    public function map($salidacuenta): array
    {
        $clase = '-';

        if ($salidacuenta->reposicioncaja) {
            $clase = 'REPOSICION';
        } elseif ($salidacuenta->liquidacion) {
            $clase = 'LIQUIDACION';
        } elseif ($salidacuenta->adelanto) {
            $clase = 'ADELANTO';
        }

        $beneficiario= '-';

        if ($salidacuenta->beneficiario) {
            $parts = explode(' ', $salidacuenta->beneficiario->nombre);
            $beneficiario = isset($parts[2]) ? $parts[0] . ' ' . $parts[2] : $parts[0];
            
        }


        return [
            $salidacuenta->id,
            $salidacuenta->fecha->format('d/m/Y'),
            'EGRESO',
            $clase,

            $salidacuenta->tipocomprobante ? $salidacuenta->tipocomprobante->nombre : '-',
            $salidacuenta->comprobante_correlativo ? $salidacuenta->comprobante_correlativo : '-',
            $salidacuenta->cuenta->nombre,
            $salidacuenta->motivo->nombre,
            $salidacuenta->descripcion ? $salidacuenta->descripcion : '-',
            $beneficiario,

            $salidacuenta->creador ? $salidacuenta->creador->name : '-',
            $salidacuenta->monto,




        ];
    }



    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(10); // Title row styling
        $sheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:L1')->getFill()->getStartColor()->setARGB('D9E7DC'); // Set background color





        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('center');
        $mergedCellsRanges = ['A1:L1'];
        foreach ($mergedCellsRanges as $range) {
            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        }




        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(10.3);
        $sheet->getColumnDimension('C')->setWidth(8);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(15.1);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(13);
        $sheet->getColumnDimension('I')->setWidth(27);
        $sheet->getColumnDimension('J')->setWidth(23);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(12);
        $sheet->getColumnDimension('M')->setWidth(12);
        $sheet->getColumnDimension('N')->setWidth(9);


        $sheet->getStyle('A1:Z500')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Z700')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:Z700')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:L700')->getFont()->setSize(9);
    }
}
