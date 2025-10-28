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

class TsReportecuentaExport implements FromCollection, WithTitle, WithStyles
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

    /**
     * Fetches and formats data for the export collection.
     */
    public function collection()
    {
        $cuenta = TsCuenta::find($this->cuenta_id);

        $ingresoData = $this->getIngresoData();
        $salidaData = $this->getSalidaData();

        $titleData = [['REPORTE DE CUENTAS']];
        $infoCuenta = $cuenta ? $this->getInformacionCuenta($cuenta) : [['Cuenta no disponible'], []];

        $saldoAnterior = $this->calculateSaldoAnterior($cuenta) ? $this->calculateSaldoAnterior($cuenta) : '0';
        $reportetotal = $this->calculateReporteTotal($cuenta);

        $saldoAnteriorRow = [['', '', '', '', '', '', '', '', 'SALDO', 'ANTERIOR:', $saldoAnterior]];
        $balanceRow = [['', '', '', '', '', '', '', '', '', 'BALANCE:', $reportetotal]];

        // Combine title, summary, headings, and main data for the export
        return (new Collection($titleData))
            ->merge($infoCuenta)
            ->merge($this->getHeadings())
            ->merge($saldoAnteriorRow)
            ->merge($ingresoData)
            ->merge($salidaData)
            ->merge($balanceRow);
    }

    /**
     * Returns headings row.
     */
    private function getHeadings()
    {
        return [
            ['ID', 'FECHA', 'TIPO', 'CLASE', 'CAJA REPUESTA', 'CLIENTE', 'COMPROB.', 'NRO', 'MOTIVO', 'DESCRIPCION', 'MONTO']
        ];
    }

    /**
     * Fetches and formats data for "Ingreso" records.
     */
    private function getIngresoData()
    {
        $query = TsIngresoCuenta::query()->where('cuenta_id', '=', $this->cuenta_id);

        if ($this->desde) {
            $query->where('fecha', '>=', Carbon::parse($this->desde)->startOfDay());
        }
        if ($this->hasta) {
            $query->where('fecha', '<=', Carbon::parse($this->hasta)->endOfDay());
        }

        return $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'fecha' => $item->fecha->format('d/m/Y'),
                'tipo' => 'INGRESO',
                'clase' => '-',
                'caja repuesta' => '-',
                'cliente' => '-',
                'tipo_compr' => $item->tipocomprobante ? strtoupper($item->tipocomprobante->nombre) : '-',
                'nro_compr' => $item->comprobante_correlativo ? strtoupper($item->comprobante_correlativo) : '-',
                'motivo' => $item->motivo ? strtoupper($item->motivo->nombre) : '-',
                'descripcion' => $item->descripcion ? strtoupper($item->descripcion) : '-',
                'monto' => $item->monto,
            ];
        });
    }

    /**
     * Fetches and formats data for "Salida" records.
     */
    private function getSalidaData()
    {
        $query = TsSalidaCuenta::query()->where('cuenta_id', '=', $this->cuenta_id);

        if ($this->desde) {
            $query->where('fecha', '>=', Carbon::parse($this->desde)->startOfDay());
        }
        if ($this->hasta) {
            $query->where('fecha', '<=', Carbon::parse($this->hasta)->endOfDay());
        }

        return $query->get()->map(function ($item) {
            $clase = '-';
            $sociedad = '-';

            if ($item->reposicioncaja) {
                $clase = 'REPOSICION';
            } elseif ($item->liquidacion) {
                $clase = 'LIQUIDACION';
                $sociedad = strtoupper($item->liquidacion->sociedad->nombre);
            } elseif ($item->adelanto) {
                $clase = 'ADELANTO';
                $sociedad = strtoupper($item->adelanto->sociedad->nombre);
            }

            return [
                'id' => $item->id,
                'fecha' => $item->fecha->format('d/m/Y'),
                'tipo' => 'EGRESO',
                'clase' => $clase,
                'reposicion_caja' => $item->reposicioncaja ? strtoupper($item->reposicioncaja->caja->nombre) : '-',
                'sociedad' => $sociedad,
                'tipo_compr' => $item->tipocomprobante ? strtoupper($item->tipocomprobante->nombre) : '-',
                'nro_compr' => $item->comprobante_correlativo ? strtoupper($item->comprobante_correlativo) : '-',
                'motivo' => $item->motivo ? strtoupper($item->motivo->nombre) : '-',
                'descripcion' => $item->descripcion ? strtoupper($item->descripcion) : '-',
                'monto' => $item->monto ? -$item->monto : '-',
            ];
        });
    }

    /**
     * Retrieves information about the account.
     */
    private function getInformacionCuenta($cuenta)
    {

        $desdeDate = is_string($this->desde) ? Carbon::parse($this->desde) : $this->desde;
        $hastaDate = is_string($this->hasta) ? Carbon::parse($this->hasta) : $this->hasta;
        return [

            [
                'CUENTA:',
                '',
                $cuenta->nombre,
                '',
                '', 
                'DESDE',
                $desdeDate->format('d/m/Y')
            ],
            [
                'MONEDA:',
                '',
                $cuenta->tipomoneda->nombre,
                '',
                '',
                'HASTA',
                $hastaDate->format('d/m/Y')
            ],

            ['']
        ];
    }

    /**
     * Calculates the previous balance for the account.
     */
    private function calculateSaldoAnterior($cuenta)
    {
        if (!$cuenta) {
            return 0;
        }

        $desdeDate = Carbon::parse($this->desde)->startOfDay();


        $ingresosAnteriores = $cuenta->ingresos->where('fecha', '<', $desdeDate);
        $salidasAnteriores = $cuenta->salidas->where('fecha', '<', $desdeDate);

        // Calculate the sum only if there are records
        $sumIngresos = $ingresosAnteriores->isEmpty() ? 0 : $ingresosAnteriores->sum('monto');
        $sumSalidas = $salidasAnteriores->isEmpty() ? 0 : $salidasAnteriores->sum('monto');

        return $sumIngresos - $sumSalidas;
    }

    /**
     * Calculates the total report balance for the account.
     */
    private function calculateReporteTotal($cuenta)
    {
        if (!$cuenta) {
            return 0;
        }

        $ingresoCompleto = $cuenta->ingresos->where('fecha', '<=', Carbon::parse($this->hasta)->endOfDay())->sum('monto');
        $salidaCompleta = $cuenta->salidas->where('fecha', '<=', Carbon::parse($this->hasta)->endOfDay())->sum('monto');

        return $ingresoCompleto - $salidaCompleta;
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



        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(10.3);
        $sheet->getColumnDimension('C')->setWidth(8);
        $sheet->getColumnDimension('D')->setWidth(12.5);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(10.3);
        $sheet->getColumnDimension('H')->setWidth(10.3);
        $sheet->getColumnDimension('I')->setWidth(15.9);
        $sheet->getColumnDimension('J')->setWidth(19);
        $sheet->getRowDimension('2')->setRowHeight(15);
        $sheet->getRowDimension('3')->setRowHeight(15);

        $sheet->getStyle('E7:E500')->getAlignment()->setWrapText(true);
        $sheet->getStyle('F7:F500')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Z500')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Z700')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:Z700')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A6:Z700')->getFont()->setSize(9);
    }
}
