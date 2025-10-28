<?php

namespace App\Http\Controllers;

use App\Exports\TsSalidaCajaExport;
use App\Models\TipoComprobante;
use App\Models\TsBeneficiario;
use App\Models\TsCaja;
use App\Models\TsMotivo;
use App\Models\TsReposicioncaja;
use App\Models\TsSalidacaja;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Excel;

class TsSalidacajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function __construct()
    {
        $this->middleware('permission:use cuenta', ['only' => ['index', 'show']]);
        $this->middleware('permission:use caja', ['only' => ['create', 'store', 'destroy', 'update']]);
    }



    public function index()
    {
        $salidascajas = TsSalidacaja::orderBy('created_at', 'desc')->paginate(30);
        $tiposcomprobantes = TipoComprobante::orderBy('created_at', 'desc')->get();

        $cajas = TsCaja::orderBy('created_at', 'desc')->paginate(30);
        $motivos = TsMotivo::orderBy('created_at', 'desc')->get();

        return view('tesoreria.salidascajas.index', compact('salidascajas', 'tiposcomprobantes', 'cajas', 'motivos'));
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

            //SE CREA UN OBJETO LLAMANDO A LA CAJA SOBRE LA QUE SE VA A TRABAJAR
            $caja = TsCaja::findOrFail($request->caja_id);
            $lastReposicion = TsReposicioncaja::where('caja_id', $caja->id)
                ->orderBy('created_at', 'desc') // or use 'id' if it's incrementing
                ->first();

            $request->validate([
                'monto' => 'required|numeric|min:0',
                'tipo_comprobante_id' => 'nullable',
                'comprobante_correlativo' => 'nullable',
                'caja_id' => 'required',
                'motivo_id' => 'required',
                'descripcion' => 'nullable',
                'fecha_comprobante' => 'nullable',



            ]);


            if ($caja->balance < $request->monto) {
                throw new \Exception('No tienes suficiente saldo para ejecutar esta salida.');
            }





            //CREAR LA SALIDA
            $salida_caja = TsSalidaCaja::create([
                'monto' => $request->monto,
                'tipo_comprobante_id' => $request->tipo_comprobante_id,
                'comprobante_correlativo' => $request->comprobante_correlativo,
                'descripcion' => $request->descripcion,
                'caja_id' => $request->caja_id,
                'motivo_id' => $request->motivo_id,
                'creador_id' => auth()->id(),
                'reposicion_id' => $lastReposicion->id,
                'fecha_comprobante' => $request->fecha_comprobante,
                'empresa_id' => $request->empresa_id,


            ]);


            if ($request->nombre && $request->documento) {
                $beneficiario = TsBeneficiario::updateOrCreate(
                    ['nombre' => $request->nombre],
                    [
                        'documento' => $request->documento,
                    ]
                );

                $salida_caja->beneficiario_id = $beneficiario->id;
                $salida_caja->save();
            }

            //ACTUALIZAR EL BALANCE DE LA CAJA DESPUÉS DE LA SALIDA
            $caja->balance -= $request->monto;
            $caja->save();

            if ($request->fecha) {
                $salida_caja->fecha = $request->fecha;
            } else {
                $salida_caja->fecha = $salida_caja->created_at;
            }
            $salida_caja->save();


            return redirect()->route('tsmiscajas.index')->with('status', 'Salida de la caja efectuada con éxito.');
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

            $salidacaja = TsSalidacaja::findOrFail($id);

            $salidacaja->descripcion = $request->descripcion;





            //UPDATE THE BALANCE

            $caja = TsCaja::findOrFail($salidacaja->caja->id);
            $caja->balance = $caja->balance - ($request->monto - $salidacaja->monto);
            $caja->save();

            $salidacaja->monto = $request->monto;



            $salidacaja->save();


            return redirect()->route('tsmiscajas.salidas')->with('status', 'Salida de la cuenta actualizada con éxito.');
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
        try 
        {
            $salidacaja = TsSalidacaja::findOrFail($id);
            $salidacaja->caja->balance += $salidacaja->monto;
            $salidacaja->caja->save();
            $salidacaja->delete();

            return redirect()->route('tsmiscajas.salidas')->with('status', 'Salida de la caja eliminada con éxito.');

        } 
        catch (QueryException $e) 
        {

            return redirect()->back()->with('error', 'Error desconocido');
        } 
        catch (\Exception $e) 
        {

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



        return Excel::download(new TsSalidaCajaExport($caja_id, $motivo_id, $tipo_comprobante_id, $start_date, $end_date), 'salidascajas.xlsx');
    }



    #SEARCH
    public function searchSalidaCaja(Request $request)
    {
        $salidascajas = TsSalidacaja::where('descripcion', 'like', '%' . $request->search_string . '%')

            ->orderBy('created_at', 'desc')->paginate(100);

        return view('tesoreria.salidascajas.search-results', compact(var_name: 'salidascajas'));
    }
}
