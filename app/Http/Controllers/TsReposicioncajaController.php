<?php

namespace App\Http\Controllers;

use App\Exports\TsReposicionCajaExport;
use App\Models\TipoComprobante;
use App\Models\TsCaja;
use App\Models\TsCuenta;
use App\Models\TsMotivo;
use App\Models\TsReposicioncaja;
use Illuminate\Http\Request;
use App\Http\Controllers\TsSalidacuentaController;
use App\Models\TsSalidaCuenta;
use Excel;

use App\Exports\TsMicajaExport;

use Illuminate\Support\Facades\DB;

class TsReposicioncajaController extends Controller
{

    //variable que almacenará al controlador externo
    protected $salidacuentaController;


    //Asignando el controlador a la variable
    public function __construct(TsSalidacuentaController $salidacuentaController)
    {
        $this->salidacuentaController = $salidacuentaController;
        $this->middleware('permission:use cuenta');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reposicionescajas = TsReposicioncaja::orderBy('created_at', 'desc')->paginate(30);
        $tiposcomprobantes = TipoComprobante::orderBy('created_at', 'desc')->paginate(30);
        $cajas = TsCaja::orderBy('created_at', 'desc')->paginate(30);
        $cuentas = TsCuenta::orderBy('created_at', 'desc')->paginate(30);
        $motivos = TsMotivo::orderBy('created_at', 'desc')->paginate(30);


        return view('tesoreria.reposicionescajas.index', compact('reposicionescajas', 'tiposcomprobantes', 'cajas', 'motivos', 'cuentas'));
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
        try {

            $request->validate([
                'monto' => 'required|numeric|min:0',
                'tipo_comprobante_id' => 'nullable',
                'comprobante_correlativo' => 'nullable',
                'descripcion' => 'nullable',
                'caja_id' => 'required',
                'motivo_id' => 'required',
                'cuenta_procedencia_id' => 'required',


            ]);


            //CREAR LA SALIDA DE LA CUENTA
            $salida_cuenta = TsSalidaCuenta::create([
                'monto' => $request->monto,
                'tipo_comprobante_id' => $request->tipo_comprobante_id,
                'comprobante_correlativo' => $request->comprobante_correlativo,
                'descripcion' => $request->descripcion,
                'cuenta_id' => $request->cuenta_procedencia_id,
                'motivo_id' => $request->motivo_id,
                'creador_id' => auth()->id(),
            ]);

            //SE CREA UN OBJETO LLAMANDO A LA CUENTA DE PROCEDENCIA
            $cuenta = TsCuenta::findOrFail($request->cuenta_procedencia_id);

            //VALIDAR QUE EL BALANCE NO QUEDE NEGATIVO EN LA CUENTA DE PROCEDENCIA ANTES DE LA REPOSICIÓN
            if ($cuenta->balance < $request->monto) {
                throw new \Exception('No tienes suficiente en tu cuenta para realizar esta reposición.');
            }

            $reposicion_caja = TsReposicioncaja::create([
                'monto' => $request->monto,
                'tipo_comprobante_id' => $request->tipo_comprobante_id,
                'comprobante_correlativo' => $request->comprobante_correlativo,
                'descripcion' => $request->descripcion,
                'ultimo_balance_caja' => 0,
                'caja_id' => $request->caja_id,
                'motivo_id' => $request->motivo_id,
                'cuenta_procedencia_id' => $request->cuenta_procedencia_id,
                'salida_cuenta_id' => $salida_cuenta->id,
                'creador_id' => auth()->id(),
            ]);



            $salida_cuenta->fecha = $reposicion_caja->created_at;
            $salida_cuenta->save();

            //ACTUALIZAR EL BALANCE DE LA CUENTA DE PROCEDENCIA DEL DINERO DE LA REPOSICIÓN DE LA CAJA
            $cuenta->balance -= $request->monto;
            $cuenta->save();

            $caja = TsCaja::findOrFail($request->caja_id);

            //PRIMERO REGISTRAMOS EL ÚLTIMO BALANCE DE LA CAJA PREVIO A LA REPOSICIÓN
            $reposicion_caja->ultimo_balance_caja = $caja->balance;
            $reposicion_caja->save();

            //ACTUALIZAR EL BALANCE DE LA CAJA BENEFICIADA POR LA REPOSICIÓN
            $caja->balance += $request->monto;
            $caja->save();

            return redirect()->route('tsreposicionescajas.index')->with('status', 'Reposición de la caja registrada con éxito.');
        } catch (QueryException $e) {

            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
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
        try {
            $request->validate([
                'descripcion' => 'nullable|string|max:255',
                'monto' => 'nullable|numeric|min:0',

            ]);

            $reposicioncaja = TsReposicioncaja::findOrFail($id);
            $reposicioncaja->salidacuenta->descripcion = $request->descripcion;
            $reposicioncaja->salidacuenta->fecha = $request->fecha;
            $reposicioncaja->descripcion = $request->descripcion;


            //UPDATE THE BALANCE
            $caja = TsCaja::findOrFail($reposicioncaja->caja->id);
            $caja->balance = $caja->balance +  ($request->monto - $reposicioncaja->monto);
            $caja->save();

            $reposicioncaja->salidacuenta->cuenta->balance = $reposicioncaja->salidacuenta->cuenta->balance -  ($request->monto - $reposicioncaja->monto);

            $reposicioncaja->salidacuenta->cuenta->save();

            $reposicioncaja->monto = $request->monto;
            $reposicioncaja->salidacuenta->monto = $request->monto;


            $reposicioncaja->salidacuenta->save();
            $reposicioncaja->save();


            return redirect()->route('tsreposicionescajas.index')->with('status', 'Reposición actualizada con éxito.');
        } catch (QueryException $e) {

            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            DB::beginTransaction();

            $reposicion = TsReposicioncaja::findOrFail($id);

            $reposicion->salidacuenta->cuenta->balance += $reposicion->salidacuenta->monto;
            $reposicion->salidacuenta->cuenta->save();



            $reposicion->delete();
            $reposicion->salidacuenta->delete();


            DB::commit();
            return redirect()->route('tsreposicionescajas.index')->with('status', 'Reposición eliminada con éxito.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }



    public function export_excel(Request $request)
    {

        $caja_id = $request->input('caja_id');
        $motivo_id = $request->input('motivo_id');
        $tipo_comprobante_id = $request->input('tipo_comprobante_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        return Excel::download(new TsReposicionCajaExport($caja_id, $motivo_id, $tipo_comprobante_id, $start_date, $end_date), 'reposicionescajas.xlsx');
    }


    //PRINT

    public function printdoc(string $id)
    {

        $reposicioncaja = TsReposicioncaja::findOrFail($id);


        return view('tesoreria.reposicionescajas.printable', compact('reposicioncaja'));
    }


    public function searchReposicionesCajas(Request $request)
    {
        $reposicionescajas = TsReposicioncaja::where('descripcion', 'like', '%' . $request->search_string . '%')
            ->orWhereHas('salidacuenta', function ($query) use ($request) {
                $query->where('monto', 'like', '%' . $request->search_string . '%');
            })
            ->orderBy('created_at', 'desc')->paginate(20);
        return view('tesoreria.reposicionescajas.search-results', compact(var_name: 'reposicionescajas'));
    }











    public function export_excel_otra(string $id)
    {

        $reposicion_id = $id;
       

        return Excel::download(new TsMicajaExport($reposicion_id), 'reportecaja.xlsx');
    }
}
