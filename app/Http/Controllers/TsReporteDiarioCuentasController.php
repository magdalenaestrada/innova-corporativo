<?php

namespace App\Http\Controllers;

use App\Exports\TsReportecuentaExport;
use App\Exports\TsReporteContableCuentaExport;
use App\Models\TsCierreCuentaDiario;
use App\Models\TsCuenta;
use App\Models\TsSalidaCuenta;
use Illuminate\Http\Request;
use Excel;

class TsReporteDiarioCuentasController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:use cuenta');
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $cuenta = TsCuenta::findOrFail($id);
        $cierres_diarios = 0;
        $user = auth()->user();
        $ultimo_cierre = 0;

        // Get today's start time (12:00 AM)
        $startOfToday = \Carbon\Carbon::today()->startOfDay(); // Equivalent to 12:00 AM today
        $endOfToday = \Carbon\Carbon::today()->endOfDay(); // Equivalent to 12:00 AM today

        // Calculate saldo_anterior (sum of montos before today's start time)
        $ingresos_anteriores = $cuenta->ingresos()->where('fecha', '<', $startOfToday)->sum('monto');
        $salidas_anteriores = $cuenta->salidas()->where('fecha', '<', $startOfToday)->sum('monto');
        $saldo_anterior = $ingresos_anteriores - $salidas_anteriores;


        $ingresos = $cuenta->ingresos()
            ->whereBetween('fecha', [$startOfToday, $endOfToday])
            ->orderBy('fecha', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $salidas = $cuenta->salidas()
            ->whereBetween('fecha', [$startOfToday, $endOfToday])
            ->orderBy('fecha', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();


        // Filter ingresos and salidas to only show records from today 12:00 AM onwards
        $cuenta->ingresos = $ingresos;
        $cuenta->salidas = $salidas;

        $cuenta_general = TsCuenta::findOrFail($id);

        return view('tesoreria.cuentas.reportes.show', compact('cuenta_general', 'cuenta', 'cierres_diarios', 'user', 'ultimo_cierre', 'saldo_anterior'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function filter(Request $request, string $id)
    {
        $cuenta = TsCuenta::findOrFail($id);
        $cierres_diarios = 0;
        $user = auth()->user();

        // Get the date range from the request
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        // Initialize saldo_anterior to 0
        $saldo_anterior = 0;

        if ($desde && $hasta) {
            // Parse the 'desde' and 'hasta' date
            $desdeDate = \Carbon\Carbon::parse($desde)->startOfDay();
            $hastaDate = \Carbon\Carbon::parse($hasta)->endOfDay(); // Add 1 day to 'hasta'

            // Filter ingresos and salidas based on the date range

            $ingresos = $cuenta->ingresos()
                ->whereBetween('fecha', [$desdeDate, $hastaDate])
                ->orderBy('fecha', 'asc')
                ->orderBy('created_at', 'asc')
                ->get();

            $salidas = $cuenta->salidas()
                ->whereBetween('fecha', [$desdeDate, $hastaDate])
                ->orderBy('fecha', 'asc')
                ->orderBy('created_at', 'asc')
                ->get();

            $cuenta->ingresos = $ingresos;
            $cuenta->salidas = $salidas;


            // Calculate saldo_anterior
            $ingresos_anteriores = $cuenta->ingresos()->where('fecha', '<', $desdeDate)->sum('monto');
            $salidas_anteriores = $cuenta->salidas()->where('fecha', '<', $desdeDate)->sum('monto');

            $cuenta_general = TsCuenta::findOrFail($id);
            $saldo_anterior = $ingresos_anteriores - $salidas_anteriores;
        }

        return view('tesoreria.cuentas.reportes.show', compact('cuenta_general', 'cuenta', 'user', 'saldo_anterior'));
    }






    public function searchReportesCuentas(Request $request, $id)
    {
        $cuenta = TsCuenta::findOrFail($id);

        // Initialize queries for salidas and ingresos
        $salidascuentasQuery = $cuenta->salidas();
        $ingresoscuentasQuery = $cuenta->ingresos();

        // Get and sanitize search string
        $searchString = $request->input('search_string', '');

        // Filter by description if search string is provided
        if (!empty($searchString)) {
            $salidascuentasQuery->where('descripcion', 'like', '%' . $searchString . '%')
                ->orWhere('monto', 'like', '%' . $searchString . '%');
            $ingresoscuentasQuery->where('descripcion', 'like', '%' . $searchString . '%')
                ->orWhere('monto', 'like', '%' . $searchString . '%');
        }

        // Get date range from request with default values
        $desdeDate = \Carbon\Carbon::parse($request->input('desde'))->startOfDay();
        $hastaDate = \Carbon\Carbon::parse($request->input('hasta'))->endOfDay();


        // Filter by date range
        $salidascuentasQuery->whereBetween('fecha', [$desdeDate, $hastaDate]);
        $ingresoscuentasQuery->whereBetween('fecha', [$desdeDate, $hastaDate]);

        // Order and paginate results
        $salidascuentas = $salidascuentasQuery->orderBy('fecha', 'asc')->get();
        $ingresoscuentas = $ingresoscuentasQuery->orderBy('fecha', 'asc')->get();

        // Check if request expects an AJAX response (for partial rendering)
        if ($request->ajax()) {
            return view('tesoreria.cuentas.reportes.search-results', compact('salidascuentas', 'ingresoscuentas', 'cuenta'))->render();
        }

        // Otherwise, return the full view
        return view('tesoreria.cuentas.reportes.search-results', compact('salidascuentas', 'ingresoscuentas', 'cuenta'));
    }


    public function export_excel(Request $request)
    {


        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $cuenta_id = $request->input('cuenta_id');



        return Excel::download(new TsReportecuentaExport($desde, $hasta, $cuenta_id), 'reportecuentas.xlsx');
    }


    public function export_excel_contable(Request $request)
    {


        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $cuenta_id = $request->input('cuenta_id');



        return Excel::download(new TsReporteContableCuentaExport($desde, $hasta, $cuenta_id), 'reportecontable.xlsx');
    }
}
