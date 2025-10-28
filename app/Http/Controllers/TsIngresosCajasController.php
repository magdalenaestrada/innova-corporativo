<?php

namespace App\Http\Controllers;

use App\Models\TsBeneficiario;
use App\Models\TsCaja;
use App\Models\TsIngresoCaja;
use App\Models\TsReposicioncaja;
use Illuminate\Http\Request;

class TsIngresosCajasController extends Controller
{
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
        try {

            //SE CREA UN OBJETO LLAMANDO A LA CAJA SOBRE LA QUE SE VA A TRABAJAR
            $caja = TsCaja::findOrFail($request->caja_id);
            $lastReposicion = TsReposicioncaja::where('caja_id', $caja->id)
                ->orderBy('created_at', 'desc') // or use 'id' if it's incrementing
                ->first();


            if ($lastReposicion) {
            } else {
                throw new \Exception('Su caja no ha sido aperturada aún.');
            }


            $request->validate([
                'monto' => 'required|numeric|min:0',
                'tipo_comprobante_id' => 'nullable',
                'comprobante_correlativo' => 'nullable',
                'caja_id' => 'required',
                'motivo_id' => 'required',
                'descripcion' => 'nullable',
                'fecha_comprobante' => 'nullable',



            ]);




            //CREAR LA SALIDA
            $salida_caja = TsIngresoCaja::create([
                'monto' => $request->monto,
                'tipo_comprobante_id' => $request->tipo_comprobante_id,
                'comprobante_correlativo' => $request->comprobante_correlativo,
                'descripcion' => $request->descripcion,
                'caja_id' => $request->caja_id,
                'motivo_id' => $request->motivo_id,
                'creador_id' => auth()->id(),
                'reposicion_id' => $lastReposicion->id,
                'fecha_comprobante' => $request->fecha_comprobante,

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
            $caja->balance += $request->monto;
            $caja->save();


            return redirect()->route('tsmiscajas.index')->with('status', 'Ingreso a la caja efectuado con éxito.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $ingresocaja = TsIngresoCaja::findOrFail($id);
            $ingresocaja->caja->balance += $ingresocaja->monto;
            $ingresocaja->caja->save();
            $ingresocaja->delete();

            return redirect()->route('tsmiscajas.ingresos')->with('status', 'Ingreso a la caja eliminado con éxito.');
        } catch (QueryException $e) {

            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
