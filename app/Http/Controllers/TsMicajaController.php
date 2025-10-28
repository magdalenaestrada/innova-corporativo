<?php

namespace App\Http\Controllers;

use App\Exports\TsMicajaExport;
use Illuminate\Http\Request;

use App\Models\TsCaja;
use App\Models\Empleado;
use App\Models\TipoComprobante;
use App\Models\TsIngresoCaja;
use App\Models\TsMotivo;
use App\Models\TsEmpresa;
use App\Models\TsReposicioncaja;
use App\Models\TsSalidacaja;
use Illuminate\Support\Facades\Auth;
use Excel;

class TsMicajaController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:use caja');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleado = Auth::user()->empleado;
        $empresas = TsEmpresa::all();
        $tiposcomprobantes = TipoComprobante::all();
        $cajas = TsCaja::whereHas('encargados', function ($query) use ($empleado) {
            $query->where('encargado_id', $empleado->id);
        })->orderBy('created_at', 'desc')->paginate(30);
        $motivos = TsMotivo::all();
        return view('tesoreria.miscajas.index', compact('cajas', 'empleado', 'tiposcomprobantes', 'motivos', 'empresas'));
    }

    public function indexsalidas()
    {
        $empleado = Auth::user()->empleado;
        $cajaIds = TsCaja::whereHas('encargados', function ($query) use ($empleado) {
            $query->where('encargado_id', $empleado->id);
        })->pluck('id');

        $startOfToday = \Carbon\Carbon::today()->startOfDay(); // Equivalent to 12:00 AM today
        $endOfToday = \Carbon\Carbon::today()->endOfDay(); // Equivalent to 12:00 AM today



        $salidascajas = TsSalidacaja::whereIn('caja_id', $cajaIds)->whereBetween('fecha', [$startOfToday, $endOfToday])->orderBy('created_at', 'desc')->get();

        return view('tesoreria.miscajas.salidasindex', compact('salidascajas'));
    }




    public function indexingresos()
    {
        $empleado = Auth::user()->empleado;
        $cajas = TsCaja::whereHas('encargados', function ($query) use ($empleado) {
            $query->where('encargado_id', $empleado->id);
        })->paginate(15);
        $cajaIds = $cajas->pluck('id');
        // devuelve las salidascajas que estan relacionadas a las cajas
        $ingresoscajas = TsIngresoCaja::whereIn('caja_id', $cajaIds)->orderBy('created_at', 'desc')->paginate(30);

        return view('tesoreria.miscajas.ingresosindex', compact('ingresoscajas'));
    }

    public function indexreposiciones()
    {
        $empleado = Auth::user()->empleado;
        $cajas = TsCaja::whereHas('encargados', function ($query) use ($empleado) {
            $query->where('encargado_id', $empleado->id);
        })->paginate(30);
        $cajaIds = $cajas->pluck('id');
        // devuelve las salidascajas que estan relacionadas a las cajas
        $reposicionescajas = TsReposicioncaja::whereIn('caja_id', $cajaIds)->paginate();
        $motivos = TsMotivo::all();
        return view('tesoreria.miscajas.reposicionesindex', compact('reposicionescajas'));
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
    public function show(string $id)
    {
        //
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


    public function printdocsalida(string $id)
    {

        $salidacaja = TsSalidacaja::findOrFail($id);


        return view('tesoreria.miscajas.salidaprintticket', compact('salidacaja'));
    }




    public function export_excel(Request $request)
    {

        $reposicion_id = $request->input('reposicion_id');


        return Excel::download(new TsMicajaExport($reposicion_id), 'reportecaja.xlsx');
    }

    public function searchSalidasMisCajas(Request $request)
    {
        $searchString = $request->input('search_string', '');


        $empleado = Auth::user()->empleado;
        $cajaIds = TsCaja::whereHas('encargados', function ($query) use ($empleado) {
            $query->where('encargado_id', $empleado->id);
        })->pluck('id');

        $desdeDate = \Carbon\Carbon::parse($request->input('desde'))->startOfDay();
        $hastaDate = \Carbon\Carbon::parse($request->input('hasta'))->endOfDay();


        $salidascajas = TsSalidaCaja::whereIn('caja_id', $cajaIds)
            ->whereBetween('fecha', [$desdeDate, $hastaDate])
            ->where(function ($query) use ($searchString) {
                // Apply search filter if search string is provided
                if ($searchString) {
                    $query->where('descripcion', 'like', '%' . $searchString . '%')
                        ->orWhere('comprobante_correlativo', 'like', '%' . $searchString . '%');
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();  // Consider using pagination if dataset is large



        return view('tesoreria.miscajas.search-resultssalidas', compact('salidascajas'));
    }
}
