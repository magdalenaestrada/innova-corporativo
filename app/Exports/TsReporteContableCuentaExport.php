<?php

namespace App\Exports;

use App\Models\TsCuenta;
use App\Models\TsIngresoCuenta;
use App\Models\TsSalidaCuenta;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class TsReporteContableCuentaExport implements FromCollection, WithTitle, WithStyles
{
    protected $desde;
    protected $hasta;
    protected $cuenta_id;

    public function __construct($desde = null, $hasta = null, $cuenta_id = null)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->cuenta_id = $cuenta_id;
    }

    public function collection()
    {
        $cuenta = TsCuenta::find($this->cuenta_id);

        $titleData = [['REPORTE CONTABLE']];
        $infoCuenta = $cuenta ? $this->getInformacionCuenta($cuenta) : [['Cuenta no disponible'], []];

        $saldoAnterior = $this->calculateSaldoAnterior($cuenta);
        $saldoAnteriorRow = [['', '', '', '', '', '', '', '', 'SALDO ','ANTERIOR:',$saldoAnterior,$saldoAnterior,'', '']];

        $transactionData = $this->getTransactionData($cuenta, $saldoAnterior);
        $balanceRow = [['', '', '', '', '', '', '', '', '', 'BALANCE:', $transactionData['balance'], '','',$transactionData['balance']]];

        $headings = $this->getHeadings();

        // Combine title, summary, headings, and main data for the export
        return (new Collection($titleData))
            ->merge($infoCuenta)
            ->merge([$headings])
            ->merge([$saldoAnteriorRow])
            ->merge($transactionData['rows'])
            ->merge([$balanceRow]);
    }

    private function getHeadings()
    {
        return ['ID', 'FECHA', 'TIPO', 'CLASE', 'CAJA REPUESTA', 'CLIENTE', 'COMPROB.', 'NRO', 'MOTIVO', 'DESCRIPCION', 'MOVIMIENTOS', 'DEBE', 'HABER', 'SALDOS'];
    }

    private function getTransactionData($cuenta, $saldoAnterior)
    {
        $rows = [];
        $currentSaldo = $saldoAnterior;

        // Process ingresos
        $ingresoData = $this->getIngresoData();
        foreach ($ingresoData as $item) {
            $currentSaldo += $item['monto'];
            $rows[] = array_merge($item, [
                'debe' => $item['monto'],
                'haber' => '',
                'saldo' => $currentSaldo
            ]);
        }

        // Process salidas
        $salidaData = $this->getSalidaData();
        foreach ($salidaData as $item) {
            $currentSaldo -= $item['monto'];
            $rows[] = array_merge($item, [
                'debe' => '',
                'haber' => $item['monto'],
                'saldo' => $currentSaldo
            ]);
        }

        // Sort rows by date and ID
        usort($rows, function ($a, $b) {
            return strcmp($a['fecha'], $b['fecha']) ?: ($a['id'] <=> $b['id']);
        });

        return ['rows' => $rows, 'balance' => $currentSaldo];
    }

    private function getIngresoData()
    {
        $query = TsIngresoCuenta::query()->where('cuenta_id', '=', $this->cuenta_id);

        $desdeDate = Carbon::parse($this->desde)->startOfDay();
        $hastaDate = Carbon::parse($this->hasta)->endOfDay();


        if ($this->desde && $this->hasta) {
            $query->whereBetween('fecha', [$desdeDate, $hastaDate]);
        }
       

        return $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'fecha' => $item->fecha->format('d/m/Y'),
                'tipo' => 'INGRESO',
                'clase' => '-',
                'caja_repuesta' => '-',
                'cliente' => '-',
                'comprob' => $item->tipocomprobante ? strtoupper($item->tipocomprobante->nombre) : '-',
                'nro' => $item->comprobante_correlativo ? strtoupper($item->comprobante_correlativo) : '-',
                'motivo' => $item->motivo ? strtoupper($item->motivo->nombre) : '-',
                'descripcion' => $item->descripcion ? strtoupper($item->descripcion) : '-',
                'monto' => $item->monto,
            ];
        })->toArray();
    }

    private function getSalidaData()
    {
        $query = TsSalidaCuenta::query()->where('cuenta_id', '=', $this->cuenta_id);

        $desdeDate = Carbon::parse($this->desde)->startOfDay();
        $hastaDate = Carbon::parse($this->hasta)->endOfDay();


        if ($this->desde && $this->hasta) {
            $query->whereBetween('fecha', [$desdeDate, $hastaDate]);
        }
       
        return $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'fecha' => $item->fecha->format('d/m/Y'),
                'tipo' => 'EGRESO',
                'clase' => $item->reposicioncaja ? 'REPOSICION' : ($item->liquidacion ? 'LIQUIDACION' : ($item->adelanto ? 'ADELANTO' : '-')),
                'caja_repuesta' => $item->reposicioncaja ? strtoupper($item->reposicioncaja->caja->nombre) : '-',
                'cliente' => $item->adelanto ? strtoupper($item->adelanto->sociedad->nombre) : '-',
                'comprob' => $item->tipocomprobante ? strtoupper($item->tipocomprobante->nombre) : '-',
                'nro' => $item->comprobante_correlativo ? strtoupper($item->comprobante_correlativo) : '-',
                'motivo' => $item->motivo ? strtoupper($item->motivo->nombre) : '-',
                'descripcion' => $item->descripcion ? strtoupper($item->descripcion) : '-',
                'monto' => $item->monto,
            ];
        })->toArray();
    }

    private function getInformacionCuenta($cuenta)
    {
        return [
            ['CUENTA:', '', $cuenta->nombre, '', '', 'DESDE', Carbon::parse($this->desde)->format('d/m/Y')],
            ['MONEDA:', '', $cuenta->tipomoneda->nombre, '', '', 'HASTA', Carbon::parse($this->hasta)->format('d/m/Y')],
            ['']
        ];
    }

    private function calculateSaldoAnterior($cuenta)
    {
        if (!$cuenta) {
            return 0;
        }

        $desdeDate = Carbon::parse($this->desde)->startOfDay();

        $ingresosAnteriores = $cuenta->ingresos->where('fecha', '<',  $desdeDate)->sum('monto');
        $salidasAnteriores = $cuenta->salidas->where('fecha', '<',  $desdeDate)->sum('monto');

        return $ingresosAnteriores - $salidasAnteriores;
    }

    public function title(): string
    {
        return 'REPORTE DE CUENTAS';
    }

    public function styles(Worksheet $sheet)
    {




        
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15); // Title row styling
        $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('D9E7DC'); // Set background color
        $sheet->getStyle('A2:A3')->getFont()->setBold(true)->setItalic(true)->setSize(12); // "Información general" styling
        $sheet->getStyle('F2:F3')->getFont()->setBold(true)->setItalic(true)->setSize(12); // "Información general" styling
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal('center');
        $mergedCellsRanges = ['A1:G3'];
        foreach ($mergedCellsRanges as $range) {
            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        }


        
        $sheet->mergeCells('A1:G1'); // Merging for the main title
        $sheet->mergeCells('A2:B2'); // Merging for "Información general"
        $sheet->mergeCells('A3:B3'); // Merging for "Información general"
        $sheet->mergeCells('C2:E2'); // Merging for "Información general"
        $sheet->mergeCells('C3:E3'); // Merging for "Información general"


        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(8);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(11);
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(13.5);
        $sheet->getColumnDimension('L')->setWidth(13);
        $sheet->getColumnDimension('M')->setWidth(13);
        $sheet->getColumnDimension('N')->setWidth(13);


        
        $sheet->getStyle('E7:E500')->getAlignment()->setWrapText(true);
        $sheet->getStyle('F7:F500')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Z500')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Z700')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:Z700')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A6:Z700')->getFont()->setSize(9);
    }
}
