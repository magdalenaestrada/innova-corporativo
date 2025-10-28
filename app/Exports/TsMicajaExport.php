<?php

namespace App\Exports;

use App\Models\TsIngresoCaja;
use App\Models\TsSalidacaja;
use App\Models\TsReposicioncaja;
use App\Models\TsSalidaCuenta;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TsMicajaExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $reposicion_id;

    public function __construct($reposicion_id = null)
    {
        $this->reposicion_id = $reposicion_id;
    }

    public function collection()
    {
        // Base query for fetching 'TsSalidacaja' records
        $query = TsSalidacaja::query(); // Eager load the salidacuenta relationship

        if ($this->reposicion_id) {
            $query->where('reposicion_id', $this->reposicion_id);
        }

        // Get the main data
        $mainData = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'fecha' => $item->created_at->format('d/m/y h:i:s'),
                'tipo_compr' => optional($item->tipocomprobante)->nombre,
                'nro_compr' => $item->comprobante_correlativo ? $item->comprobante_correlativo : 'IN - ' . $item->id,
                'fecha_compra' => \Carbon\Carbon::parse($item->fecha_comprobante)->format('d/m/y'),
                'motivo' => $item->motivo->nombre,
                'beneficiario' => optional($item->beneficiario)->nombre,
                'descripcion' => $item->descripcion,
                'monto' => $item->monto,
            ];
        });

        // Fetch reposicion information for the summary
        $reposicion = TsReposicioncaja::find($this->reposicion_id);
        if ($reposicion) {

            $caja = $reposicion->caja;


            $sumMontoReposicionesPasadas = $caja->reposiciones()
                ->where('created_at', '<', $reposicion->created_at)
                ->with('salidacuenta') // Eager load the relationship
                ->get() // Fetch as a collection
                ->sum(function ($reposicion) {
                    return $reposicion->salidacuenta ? $reposicion->salidacuenta->monto : 0;
                });


            $sumMontoSalidasCajasPasadas = $caja->salidascajas
                ->where('created_at', '<', $reposicion->created_at)
                ->sum('monto');

            $sumMontoIngresosCajasPasados = $caja->ingresoscaja()->where('created_at', '<', $reposicion->created_at)
                ->sum('monto');



            $sumMontoSalidaSCajasThisReposicion = $caja->salidascajas()->where('reposicion_id', $reposicion->id)
                ->sum('monto');

            $sumMontoIngresosCajasThisReposicion = $caja->ingresoscaja()->where('reposicion_id', $reposicion->id)
                ->sum('monto');
        } else {
            $sumMontoReposicionesPasadas = 0;
            $sumMontoSalidasCajasPasadas = 0;
            $sumMontoIngresosCajasPasados = 0;
            $sumMontoSalidaSCajasThisReposicion = 0;
        }

        // Calculate the previous balance
        $balance_anterior = $sumMontoReposicionesPasadas + $sumMontoIngresosCajasPasados - $sumMontoSalidasCajasPasadas;
        $saldo_this_reposicion = $balance_anterior + $sumMontoIngresosCajasThisReposicion + $reposicion->salidacuenta->monto - ($sumMontoSalidaSCajasThisReposicion);
        $total_caja =  $reposicion->salidacuenta->monto + $balance_anterior;


        $salidastotal = -$sumMontoSalidaSCajasThisReposicion;
        // Title and summary data for the header section
        $titleData = [['Reporte de Caja']];
        $summaryData = $reposicion ? [
            ['Información general:',],
            ['FECHA DEL REPORTE', '', '', date('d/m/y')],
            ['CAJA', '', '', $reposicion->caja->nombre],
            ['Información de la reposición'],
            ['ID REPOSICIÓN', '', '', $reposicion->id],
            ['FECHA DE LA REPOSICIÓN', '', '', $reposicion->created_at->format('d/m/y')],
            ['Información contable'],
            ['BALANCE ANTERIOR', '', '', number_format($balance_anterior, 2)],
            ['MONTO REPOSICIÓN', '', '', number_format($reposicion->salidacuenta->monto, 2)],
            ['TOTAL CAJA', '', '', number_format($total_caja, 2)],
            ['SALIDAS EN ESTA REPOSICIÓN', '', '', number_format($salidastotal, 2)],
            ['INGRESOS EN ESTA REPOSICIÓN', '', '', number_format($sumMontoIngresosCajasThisReposicion, 2) != 0 ? number_format($sumMontoIngresosCajasThisReposicion, 2) : '0.00'],
            ['RESTANTE', '', '', number_format($saldo_this_reposicion, 2)],
            [''], // Blank row for spacing
        ] : [['Reposicion Information Not Available'], []];

        // Combine title, summary, headings, and main data
        return (new Collection($titleData))
            ->merge($summaryData)
            ->merge([['ID', 'FECHA', 'COMPROB.', 'NRO', 'FECHA COMPR.', 'MOTIVO', 'BENEFICIARIO', 'DESCRIPCION', 'MONTO']]) // Headings row
            ->merge($mainData);
    }

    public function headings(): array
    {
        // Headings are now directly inserted in `collection`, so this is not needed.
        return [];
    }

    public function title(): string
    {
        return 'Caja Report';
    }

    public function styles(Worksheet $sheet)
    {
        // Merging cells for title and headers
        $sheet->mergeCells('A1:F1'); // Merging for the main title
        $sheet->mergeCells('A2:F2'); // Merging for "Información general"
        $sheet->mergeCells('A3:C3'); // Adjust as necessary
        $sheet->mergeCells('A5:F5'); // Adjust as necessary
        $sheet->mergeCells('A4:C4'); // Adjust as necessary
        $sheet->mergeCells('A6:C6'); // Adjust as necessary
        $sheet->mergeCells('A7:C7'); // Adjust as necessary
        $sheet->mergeCells('A8:F8'); // Adjust as necessary
        $sheet->mergeCells('A9:C9'); // Adjust as necessary
        $sheet->mergeCells('A10:C10'); // Adjust as necessary
        $sheet->mergeCells('A11:C11'); // Adjust as necessary
        $sheet->mergeCells('A12:C12'); // Adjust as necessary
        $sheet->mergeCells('A13:C13'); // Adjust as necessary
        $sheet->mergeCells('A14:C14'); // Adjust as necessary
        $sheet->mergeCells('D14:F14'); // Adjust as necessary
        $sheet->mergeCells('D13:F13'); // Adjust as necessary
        $sheet->mergeCells('D12:F12'); // Adjust as necessary
        $sheet->mergeCells('D11:F11'); // Adjust as necessary
        $sheet->mergeCells('D10:F10'); // Adjust as necessary
        $sheet->mergeCells('D9:F9'); // Adjust as necessary
        $sheet->mergeCells('D7:F7'); // Adjust as necessary
        $sheet->mergeCells('D6:F6'); // Adjust as necessary
        $sheet->mergeCells('D3:F3'); // Adjust as necessary
        $sheet->mergeCells('D4:F4'); // Adjust as necessary

        // Set styles for merged cells
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(20); // Title row styling
        $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('c0d9a6'); // Set background color

        $sheet->getStyle('A11:F11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

        $sheet->getStyle('A11:F11')->getFill()->getStartColor()->setARGB('D1E7DD'); // Set background color

        $sheet->getStyle('A2')->getFont()->setBold(true)->setItalic(true)->setSize(12); // "Información general" styling
        $sheet->getStyle('A5')->getFont()->setBold(true)->setItalic(true)->setSize(12); // "Información general" styling
        $sheet->getStyle('A8')->getFont()->setBold(true)->setItalic(true)->setSize(12); // "Información general" styling

        // Center alignment for merged cells
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2:C2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A5:C5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A8:C8')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A16:I16')->getFont()->setBold(true)->setSize(10); // Title row styling

        // Set borders for merged cells
        $mergedCellsRanges = ['A1:F14'];
        foreach ($mergedCellsRanges as $range) {
            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        // Set a specific width for column A
        $sheet->getColumnDimension('A')->setWidth(4.8);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(9);

        $sheet->getColumnDimension('F')->setWidth(10.8);
        $sheet->getColumnDimension('G')->setWidth(23);
        $sheet->getColumnDimension('H')->setWidth(27);
        $sheet->getColumnDimension('I')->setWidth(7.9);

        $sheet->getStyle('D1:D14')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('C1:C14')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('A16:H500')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:T500')->getAlignment()->setVertical('center');
        $sheet->getStyle('I16')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:Z500')->getAlignment()->setWrapText(true);


        $sheet->getStyle('A17:K500')->getFont()->setSize(9);
    }
}
