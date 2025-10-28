<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Chat;
use App\Models\LqDevolucion;
use App\Models\TipoComprobante;
use App\Models\TsCuenta;
use App\Models\TsMotivo;
use App\Models\LqSociedad;
use App\Models\LqAdelanto;
use App\Models\LqCliente;
use App\Models\TsIngresoCuenta;
use App\Models\TsCliente;


class LqDevolucionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('permission:use cuenta');
    }


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



        
        

        $adelantos = LqAdelanto::with(relations: 'salidacuenta.cuenta.tipomoneda')->get();;
        $tiposcomprobantes = TipoComprobante::orderBy('nombre', 'asc')->get();
        $motivos = TsMotivo::all();
        $devoluciones = LqDevolucion::orderBy('created_at', 'desc')->paginate(30);
        $cuentas = TsCuenta::with('tipomoneda')->get();
        $sociedades = LqSociedad::orderBy('created_at', direction: 'asc')->get();
        $clientes = LqCliente::all();


        return view('tesoreria.devoluciones.index', compact('devoluciones','chats', 'tiposcomprobantes', 'cuentas', 'motivos', 'sociedades', 'adelantos', 'clientes'));
   
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
                'cuenta_id' => 'required',
                'motivo_id' => 'required',
                'sociedad_id' => 'required',
                'descripcion' => 'nullable',
                'documento' => 'nullable',
                'nombre' => 'nullable',
                'fecha' => 'nullable',

            ]);
           
            //SE CREA UN OBJETO LLAMANDO A LA CUENTA SOBRE LA QUE SE VA A TRABAJAR
            $cuenta = TsCuenta::findOrFail($request->cuenta_id);

                //VALIDAR SI DESPUÉS DE LA SALIDA EL BALANCE TODAVÍA ES POSITIVO
              
                $ingreso_cuenta = TsIngresoCuenta::create([
                    'monto' => $request->monto,
                    'tipo_comprobante_id' => $request->tipo_comprobante_id,
                    'comprobante_correlativo' => $request->comprobante_correlativo,
                    'cuenta_id' => $request->cuenta_id,
                    'motivo_id' => $request->motivo_id,
                    'descripcion' => $request->descripcion,
                    'creador_id' => auth()->id(),
                ]);

                $devolucion = LqDevolucion::create([
                    'sociedad_id' => $request->sociedad_id,
                    'ingreso_cuenta_id' => $ingreso_cuenta->id,
                    'creador_id' => auth()->id(),
                    'descripcion' => $request->descripcion,
                    'representante_cliente_documento' => $request->documento,
                    'representante_cliente_nombre' => $request->nombre,
                    'cliente_id' => $request->cliente_id,
                ]);

                if ($request->nombre && $request->documento) {
                    $cliente = TsCliente::updateOrCreate(
                        ['nombre' => $request->nombre],
                        [
                            'documento' => $request->documento,
                        ]
                    );
    
                    $ingreso_cuenta->cliente_id = $cliente->id;
                    $ingreso_cuenta->save();
                }
           

            if ($request->fecha) {
                $ingreso_cuenta->fecha = $request->fecha;
                $devolucion->fecha = $request->fecha;
            } else {
                $devolucion->fecha = $ingreso_cuenta->created_at;
                $ingreso_cuenta->fecha = $ingreso_cuenta->created_at;
            }
            $ingreso_cuenta->save();
            $devolucion->save();

            $adelantoIds = $request->input('adelantos');

            $devolucion->adelantos()->attach($adelantoIds);

            if (!empty($adelantoIds)) {
                foreach ($adelantoIds as $adelantoId) {
                    $adelanto = LqAdelanto::find($adelantoId);
                    if ($adelantoId) {
                        $adelanto->devuelto = true;
                        $adelanto->cerrado = true;
                        $adelanto->save();
                    }
                }
            }

            
          
            //ACTUALIZAR EL BALANCE DE LA CUENTA DESPUÉS DE LA SALIDA
            $cuenta->balance += $ingreso_cuenta->monto;
            $cuenta->save();

            return redirect()->route('lqdevoluciones.index')->with('status', 'Devolución creada con éxito.');
        } catch (QueryException $e) {
            return redirect()->route('lqdevoluciones.index')->with('error', 'Error desconocido');
        } catch (\Exception $e) {
            return redirect()->route('lqdevoluciones.index')->with('error', 'Error: ' . $e->getMessage());
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
        //
    }




    public function printdoc(string $id)
    {

        $devolucion = LqDevolucion::findOrFail($id);


        return view('tesoreria.devoluciones.printable', compact('devolucion'));
    }
}
