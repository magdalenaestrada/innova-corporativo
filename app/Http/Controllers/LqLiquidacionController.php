<?php

namespace App\Http\Controllers;

use App\Models\LqAdelanto;
use App\Models\LqCliente;
use App\Models\LqLiquidacion;
use App\Models\LqSociedad;
use App\Models\TipoComprobante;
use App\Models\TsCuenta;
use App\Models\Chat;
use App\Models\TsMotivo;
use App\Models\TsSalidaCuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TsBeneficiario;

class LqLiquidacionController extends Controller
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

        
        $chats = Chat::where(function ($query) {
            $query->where('user_id', auth()->id())
                ->orWhere('recipient_id', auth()->id());
        })
            ->with(['messages' => function ($query) {
                // Get the messages, ordered by the latest
                $query->orderBy('created_at', 'desc');
            }])
            ->get();


        $liquidaciones = LqLiquidacion::orderBy('created_at', 'desc')->paginate(30);
        
        return view('tesoreria.liquidaciones.index', compact('liquidaciones','chats'));
    }

    /**
     * Show the form for creating a new resource.
     */


    public function create()
    {


        $sociedades = LqSociedad::all();
        $clientes = LqCliente::all();

        $cuentas = TsCuenta::all();
        $motivos = TsMotivo::all();
        $tiposcomprobantes = TipoComprobante::all();

        $adelantos = LqAdelanto::with(relations: 'salidacuenta.cuenta.tipomoneda')->get();;



        return view('tesoreria.liquidaciones.create', compact('tiposcomprobantes', 'sociedades', 'adelantos', 'cuentas', 'motivos', 'clientes'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'dolares' => 'required|numeric|min:0',
                'soles' => 'required|numeric|min:0',
                'tipo_cambio' => 'required',
                'tipo_comprobante_id' => 'nullable',
                'comprobante_correlativo' => 'nullable',
                'cuenta_id' => 'required',
                'motivo_id' => 'required',
                'sociedad_id' => 'required',
                'descripcion' => 'nullable',
                'documento' => 'nullable',
                'nombre' => 'nullable',
                'cliente_id' => 'nullable',
                'nro_operacion' => 'nullable'

            ]);
            $cuenta = TsCuenta::findOrFail($request->cuenta_id);

            //SE CREA UN OBJETO LLAMANDO A LA CUENTA SOBRE LA QUE SE VA A TRABAJAR

            $cuenta = TsCuenta::findOrFail($request->cuenta_id);

            if ($cuenta->tipomoneda->nombre == 'DOLARES') {

                //VALIDAR SI DESPUÉS DE LA SALIDA EL BALANCE TODAVÍA ES POSITIVO
                if ($cuenta->balance < $request->importe_total_dolares) {
                    throw new \Exception('No tienes suficiente saldo para ejecutar esta salida.');
                }
                $salida_cuenta = TsSalidaCuenta::create([
                    'monto' => $request->importe_total_dolares,
                    'tipo_comprobante_id' => $request->tipo_comprobante_id,
                    'comprobante_correlativo' => $request->comprobante_correlativo,
                    'cuenta_id' => $request->cuenta_id,
                    'motivo_id' => $request->motivo_id,
                    'descripcion' => $request->descripcion,
                    'nro_operacion' => $request->nro_operacion,
                    'creador_id' => auth()->id(),
                ]);

                $liquidacion = LqLiquidacion::create([
                    'sociedad_id' => $request->sociedad_id,
                    'salida_cuenta_id' => $salida_cuenta->id,
                    'tipo_cambio' => $request->tipo_cambio,
                    'creador_id' => auth()->id(),
                    'descripcion' => $request->descripcion,
                    'representante_cliente_documento' => $request->documento,
                    'representante_cliente_nombre' => $request->nombre,
                    'total' => $request->dolares,
                    'descuento' => $request->descuento_dolares,
                    'otros_descuentos' => $request->otros_descuentos_dolares,
                    'cliente_id' => $request->cliente_id,
                    'total_sin_detraccion' => $request->total_sin_detraccion_dolares
                ]);
            } else {
                if ($cuenta->balance < $request->importe_total_soles) {
                    throw new \Exception('No tienes suficiente saldo para ejecutar esta salida.');
                }
                $salida_cuenta = TsSalidaCuenta::create([
                    'monto' => $request->importe_total_soles,
                    'tipo_comprobante_id' => $request->tipo_comprobante_id,
                    'comprobante_correlativo' => $request->comprobante_correlativo,
                    'cuenta_id' => $request->cuenta_id,
                    'motivo_id' => $request->motivo_id,
                    'descripcion' => $request->descripcion,
                    'nro_operacion' => $request->nro_operacion,
                    'creador_id' => auth()->id(),
                ]);

                $liquidacion = LqLiquidacion::create([
                    'sociedad_id' => $request->sociedad_id,
                    'salida_cuenta_id' => $salida_cuenta->id,
                    'tipo_cambio' => $request->tipo_cambio,
                    'total' => $request->soles,
                    'descuento' => $request->descuento_soles,
                    'otros_descuentos' => $request->otros_descuentos_soles,
                    'creador_id' => auth()->id(),

                    'representante_cliente_documento' => $request->documento,
                    'representante_cliente_nombre' => $request->nombre,
                    'total_sin_detraccion' => $request->total_sin_detraccion_soles

                ]);
            }



            if ($request->nombre && $request->documento) {
                $beneficiario = TsBeneficiario::updateOrCreate(
                    ['nombre' => $request->nombre],
                    [
                        'documento' => $request->documento,
                    ]
                );

                $salida_cuenta->beneficiario_id = $beneficiario->id;
                $salida_cuenta->save();
            }




            if ($request->fecha) {
                $salida_cuenta->fecha = $request->fecha;
            } else {
                $salida_cuenta->fecha = $salida_cuenta->created_at;
            }
            $salida_cuenta->save();

            $adelantoIds = $request->input('adelantos');

            $liquidacion->adelantos()->attach($adelantoIds);

            if (!empty($adelantoIds)) {
                foreach ($adelantoIds as $adelantoId) {
                    $adelanto = LqAdelanto::find($adelantoId);
                    if ($adelantoId) {
                        $adelanto->cerrado = true;
                        $adelanto->save();
                    }
                }
            }

            if ($request->fecha) {
                $liquidacion->fecha = $request->fecha;
            } else {
                $liquidacion->fecha = $salida_cuenta->created_at;
            }
            $liquidacion->save();

            //ACTUALIZAR EL BALANCE DE LA CUENTA DESPUÉS DE LA SALIDA
            $cuenta->balance -= $salida_cuenta->monto;
            $cuenta->save();

            return redirect()->route('lqliquidaciones.index')->with('status', 'Liquidación creada con éxito.');
        } catch (QueryException $e) {
            return redirect()->route('lqliquidaciones.index')->with('error', 'Error desconocido');
        } catch (\Exception $e) {
            return redirect()->route('lqliquidaciones.index')->with('error', 'Error: ' . $e->getMessage());
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
        

        $sociedades = LqSociedad::all();
        $clientes = LqCliente::all();

        $cuentas = TsCuenta::all();
        $motivos = TsMotivo::all();
        $tiposcomprobantes = TipoComprobante::all();

        $adelantos = LqAdelanto::with(relations: 'salidacuenta.cuenta.tipomoneda')->get();;

        $liquidacion = LqLiquidacion::findOrFail($id);



        return view('tesoreria.liquidaciones.edit', compact('tiposcomprobantes', 'sociedades', 'adelantos', 'cuentas', 'motivos', 'clientes', 'liquidacion'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'tipo_cambio' => 'nullable|string|max:255',
                'monto' => 'nullable|numeric|min:0',

            ]);

            $liquidacion = LqLiquidacion::findOrFail($id);
            $liquidacion->tipo_cambio = $request->tipo_cambio;
            $liquidacion->fecha = $request->fecha;


            //UPDATE THE BALANCE
            
            $liquidacion->salidacuenta->cuenta->balance = $liquidacion->salidacuenta->cuenta->balance +  ($request->monto - $liquidacion->salidacuenta->monto);
            $liquidacion->salidacuenta->cuenta->save();

            

            $liquidacion->salidacuenta->monto = $request->monto;
            $liquidacion->salidacuenta->fecha = $request->fecha;
            $liquidacion->salidacuenta->descripcion = $request->descripcion;

            $liquidacion->salidacuenta->save();
            $liquidacion->save();

            return redirect()->route('lqliquidaciones.index')->with('status', 'Liquidación actualizada con éxito.');
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

            $liquidacion = LqLiquidacion::findOrFail($id);

            $liquidacion->salidacuenta->cuenta->balance += $liquidacion->salidacuenta->monto;
            $liquidacion->salidacuenta->cuenta->save();
            
            foreach($liquidacion->adelantos as $adelanto){
            
                $adelanto->cerrado = false;
                $adelanto->save();
            }
            
            
            $liquidacion->delete();
            $liquidacion->salidacuenta->delete();


            DB::commit();
            return redirect()->route('lqliquidaciones.index')->with('status', 'Liquidación eliminada con éxito.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function printdoc(string $id)
    {

        $liquidacion = LqLiquidacion::findOrFail($id);


        return view('tesoreria.liquidaciones.printable', compact('liquidacion'));
    }

    public function getAdelantos(Request $request)
    {
        $sociedad = LqSociedad::findOrFail($request->sociedad_id);

        $adelantos = $sociedad->adelantos_activos()->with('salidacuenta.cuenta.tipomoneda')->get();

        return response()->json($adelantos);
    }

    #SEARCH
    public function searchLiquidacion(Request $request)
    {
        $liquidaciones = LqLiquidacion::whereHas('sociedad', function ($query) use ($request) {
            $query->where('nombre', 'like', '%' . $request->search_string . '%');
        })
            ->orWhereHas('sociedad', function ($query) use ($request) {
                $query->where('codigo', 'like', '%' . $request->search_string . '%');
            })
            ->orWhereHas('salidacuenta', function ($query) use ($request) {
                $query->where('descripcion', 'like', '%' . $request->search_string . '%');
            })
            ->orWhereHas('salidacuenta', function ($query) use ($request) {
                $query->where('monto', 'like', '%' . $request->search_string . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('tesoreria.liquidaciones.search-results', compact('liquidaciones'));
    }






    public function findRepresentante(Request $request)
    {
        $liquidacion = LqLiquidacion::where('representante_cliente_nombre', '=', $request->search_string)->firstOrFail();
        return response()->json(['documento' => $liquidacion->representante_cliente_documento]);
    }
}
