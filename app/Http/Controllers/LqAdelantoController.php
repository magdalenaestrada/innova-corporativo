<?php

namespace App\Http\Controllers;

use App\Exports\LqAdelantoExport;
use App\Models\LqAdelanto;
use App\Models\LqCliente;
use App\Models\LqSociedad;
use App\Models\Rancho;
use App\Models\Chat;
use App\Models\TipoComprobante;
use App\Models\TsCuenta;
use App\Models\TsIngresoCuenta;
use App\Models\TsBeneficiario;
use App\Models\TsMotivo;
use App\Models\TsSalidaCuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Excel;

class LqAdelantoController extends Controller
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



        $adelantos = LqAdelanto::orderBy('fecha', 'desc')->orderBy('created_at', 'desc')->paginate(30);
        $tiposcomprobantes = TipoComprobante::orderBy('nombre', 'asc')->get();
        $cuentas = TsCuenta::orderBy('nombre', 'asc')->get();
        $motivos = TsMotivo::orderBy('nombre', 'asc')->get();
        $sociedades = LqSociedad::orderBy('created_at', direction: 'asc')->get();
        $clientes = LqCliente::orderBy('created_at', direction: 'asc')->get();

        return view('tesoreria.adelantos.index', compact('adelantos', 'tiposcomprobantes', 'cuentas', 'motivos', 'sociedades', 'clientes', 'chats'));
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

        DB::beginTransaction();
        try {
            $request->validate([
                'monto' => 'required|numeric|min:0',
                'tipo_comprobante_id' => 'nullable',
                'comprobante_correlativo' => 'nullable',
                'cuenta_id' => 'required',
                'motivo_id' => 'required',
                'sociedad_id' => 'required',
                'tipo_cambio' => 'nullable',
                'descripcion' => 'nullable',
                'documento' => 'nullable',
                'nombre' => 'nullable',
                'cliente_id' => 'nullable'

            ]);

            //SE CREA UN OBJETO LLAMANDO A LA CUENTA SOBRE LA QUE SE VA A TRABAJAR

            $cuenta = TsCuenta::findOrFail($request->cuenta_id);

            if ($cuenta->tipomoneda->nombre == 'DOLARES') {

                //VALIDAR SI DESPUÉS DE LA SALIDA EL BALANCE TODAVÍA ES POSITIVO
                if ($cuenta->balance < $request->monto) {
                    throw new \Exception('No tienes suficiente saldo para hacer este adelanto.');
                }

                $salida_cuenta = TsSalidaCuenta::create([
                    'monto' => $request->monto,
                    'tipo_comprobante_id' => $request->tipo_comprobante_id,
                    'comprobante_correlativo' => $request->comprobante_correlativo,
                    'cuenta_id' => $request->cuenta_id,
                    'motivo_id' => $request->motivo_id,
                    'descripcion' => $request->descripcion,
                    'creador_id' => auth()->id(),
                    'nro_operacion' => $request->nro_operacion
                ]);


                $cuenta->balance -= $request->monto;
                $cuenta->save();
            } else {

                //VALIDAR SI DESPUÉS DE LA SALIDA EL BALANCE TODAVÍA ES POSITIVO
                if ($cuenta->balance < $request->total) {
                    throw new \Exception('No tienes suficiente saldo para ejecutar esta salida.');
                }
                $salida_cuenta = TsSalidaCuenta::create([
                    'monto' => $request->total,
                    'tipo_comprobante_id' => $request->tipo_comprobante_id,
                    'comprobante_correlativo' => $request->comprobante_correlativo,
                    'cuenta_id' => $request->cuenta_id,
                    'motivo_id' => $request->motivo_id,
                    'descripcion' => $request->descripcion,
                    'creador_id' => auth()->id(),
                    'nro_operacion' => $request->nro_operacion
                ]);

                $cuenta->balance -= $request->total;
                $cuenta->save();
            }

            if ($request->fecha) {
                $salida_cuenta->fecha = $request->fecha;
            } else {
                $salida_cuenta->fecha = $salida_cuenta->created_at;
            }
            $salida_cuenta->save();


            $adelanto = LqAdelanto::create([
                'cerrado' => false,
                'sociedad_id' => $request->sociedad_id,
                'salida_cuenta_id' => $salida_cuenta->id,
                'tipo_cambio' => $request->tipo_cambio,
                'creador_id' => auth()->id(),
                'descripcion' => $request->descripcion,
                'representante_cliente_documento' => $request->documento,
                'representante_cliente_nombre' => $request->nombre,
                'abierto' => true,
                'cliente_id' => $request->cliente_id,
            ]);

            if ($request->has('detraccion_checked')) {
                if ($cuenta->tipomoneda->nombre == 'DOLARES') {
                    $adelanto->total_sin_detraccion = $request->total_sin_detraccion_dolares;
                } else {
                    $adelanto->total_sin_detraccion = $request->total_sin_detraccion_dolares;
                }
            } else {
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
                $adelanto->fecha = $request->fecha;
            } else {
                $adelanto->fecha = $adelanto->created_at;
            }
            $adelanto->save();

            //ACTUALIZAR EL BALANCE DE LA CUENTA DESPUÉS DE LA SALIDA
            DB::commit();
            return redirect()->route('lqadelantos.index')->with('status', 'Salida de la cuenta efectuada con éxito.');
        } catch (QueryException $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {

            DB::rollBack();

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

        DB::beginTransaction();
        try {
            $request->validate([
                'monto' => 'nullable|numeric|min:0',
                'tipo_cambio' => 'nullable',
                'descripcion' => 'nullable',


            ]);

            //SE CREA UN OBJETO LLAMANDO A LA CUENTA SOBRE LA QUE SE VA A TRABAJAR

            $adelanto = LqAdelanto::findOrFail($id);


            $adelanto->salidacuenta->cuenta->balance -= ($request->monto - $adelanto->salidacuenta->monto);
            $adelanto->salidacuenta->descripcion = $request->descripcion;
            $adelanto->salidacuenta->fecha = $request->fecha;

            $adelanto->salidacuenta->monto = $request->monto;
            $adelanto->tipo_cambio = $request->tipo_cambio;
            $adelanto->fecha = $request->fecha;
            $adelanto->sociedad_id = $request->sociedad_id;




            $adelanto->salidacuenta->cuenta_id = $request->cuenta_id;




            $adelanto->save();
            $adelanto->salidacuenta->save();
            $adelanto->salidacuenta->cuenta->save();








            //ACTUALIZAR EL BALANCE DE LA CUENTA DESPUÉS DE LA SALIDA
            DB::commit();
            return redirect()->route('lqadelantos.index')->with('status', 'Adelanto actualizado con éxito.');
        } catch (QueryException $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {

            DB::rollBack();

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

            $adelanto = LqAdelanto::findOrFail($id);

            $adelanto->salidacuenta->cuenta->balance += $adelanto->salidacuenta->monto;
            $adelanto->salidacuenta->cuenta->save();



            $adelanto->delete();
            $adelanto->salidacuenta->delete();


            DB::commit();
            return redirect()->route('lqadelantos.index')->with('status', 'Adelanto eliminado con éxito.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    //FOR AJAX
    public function getSociedadByCode($sociedad)
    {
        $sociedad = LqSociedad::find($sociedad);


        if ($sociedad) {
            return response()->json(['success' => true, 'sociedad' => $sociedad]);
        } else {
            return response()->json(['success' => false, 'message' => 'Sociedad no encontrada']);
        }
    }



    //PRINT

    public function printdoc(string $id)
    {

        $adelanto = LqAdelanto::findOrFail($id);


        return view('tesoreria.adelantos.printable', compact('adelanto'));
    }


    public function export_excel(Request $request)
    {

        $string = $request->input('string');
    



        return Excel::download(new LqAdelantoExport($string), 'adelantos.xlsx');
    }



    #SEARCH
    public function searchAdelanto(Request $request)
    {
        $adelantos = LqAdelanto::whereHas('sociedad', function ($query) use ($request) {
            $query->where('nombre', 'like', '%' . $request->search_string . '%');
        })
            ->orWhereHas('sociedad', function ($query) use ($request) {
                $query->where('codigo', 'like', '%' . $request->search_string . '%');
            })
            ->orWhereHas('salidacuenta', function ($query) use ($request) {
                $query->where('monto', 'like', '%' . $request->search_string . '%');
            })
            ->orWhere('descripcion', 'like', '%' . $request->search_string . '%')
            ->orWhere('total_sin_detraccion', 'like', '%' . $request->search_string . '%')

            ->orderBy('created_at', 'desc')
            ->paginate(30);


            $tiposcomprobantes = TipoComprobante::orderBy('nombre', 'asc')->get();
            $cuentas = TsCuenta::orderBy('nombre', 'asc')->get();
            $motivos = TsMotivo::orderBy('nombre', 'asc')->get();
            $sociedades = LqSociedad::orderBy('created_at', direction: 'asc')->get();
            $clientes = LqCliente::orderBy('created_at', direction: 'asc')->get();
        return view('tesoreria.adelantos.search-results', compact('adelantos', 'tiposcomprobantes', 'cuentas', 'motivos', 'sociedades'));
    }





    public function findRepresentante(Request $request)
    {
        $adelanto = LqAdelanto::where('representante_cliente_nombre', '=', $request->search_string)->firstOrFail();
        
        
        return response()->json(['documento' => $adelanto->representante_cliente_documento]);
    }


    


    
    public function devolver(string $id)
    {
        $adelanto = LqAdelanto::findOrFail($id);
        $chats = Chat::where(function ($query) {
            $query->where('user_id', auth()->id())
                ->orWhere('recipient_id', auth()->id());
        })
            ->with(['messages' => function ($query) {
                // Get the messages, ordered by the latest
                $query->orderBy('created_at', 'desc');
            }])
            ->get();


            $tiposcomprobantes = TipoComprobante::orderBy('nombre', 'asc')->get();
            $cuentas = TsCuenta::orderBy('created_at', 'desc')->get();
            $motivos = TsMotivo::orderBy('nombre', 'asc')->get();
    


        return view('tesoreria.adelantos.devolver', compact('adelanto', 'chats', 'tiposcomprobantes', 'cuentas', 'motivos'));
    }


    public function updatedevolver(Request $request, string $id)
    {
        try {
            $request->validate([
                'guiaingresoalmacen' => 'required',
            ]);

            $inventarioingreso = Inventarioingreso::findOrFail($id);
            if ($inventarioingreso->estado == 'POR RECOGER') {
                $closing = true;

                $productos = $inventarioingreso->productos;
                foreach ($productos as $index => $producto) { // Modified line: Added $index for proper indexing

                    if (in_array($index, $request->input('selected_products', []))) { // Modified line: Changed $producto->id to $index
                        $cantidad_recepcionada = $request->input('qty_arrived.' . $index); // Modified line: Changed $producto->id to $index
                        if ($producto->pivot->cantidad < $producto->pivot->cantidad_ingresada + $cantidad_recepcionada) {
                            throw new HttpException(403, 'NO PUEDES INGRESAR MÁS PRODUCTOS DE LOS QUE HAY POR RECIBIR.');
                        }

                        $producto->pivot->cantidad_ingresada += $cantidad_recepcionada;
                        $producto->stock += $cantidad_recepcionada;

                        // GUIA REMISION BY INGRESO
                        $producto->pivot->guiaingresoalmacen = $request->input('guiaingresoalmacen');

                        // FILLING THE LOGDETALLESINVENTARIOINGRESO TABLE
                        $logdetallesinvingreso = new Logdetallesinvingreso;
                        $logdetallesinvingreso->detalleinventarioingreso_id = $producto->pivot->id;
                        $logdetallesinvingreso->usuario = auth()->user()->name;
                        $logdetallesinvingreso->cantidad_ingresada = $cantidad_recepcionada;
                        $logdetallesinvingreso->guiaingresoalmacen = $request->input('guiaingresoalmacen');

                        $logdetallesinvingreso->save();
                        if ($inventarioingreso->tipomoneda == 'SOLES') {
                            $producto->ultimoprecio = $producto->pivot->precio;
                        } else {
                            $producto->ultimoprecio = $producto->pivot->precio * $inventarioingreso->cambio_dolar_precio_venta;
                        }
                        $producto->pivot->save();
                        $producto->save();

                        // logic to calculate the mean in for cardex
                        // RETRIEVE ALL THE HISTORIC DETALLES
                        $detallesinvetarioingresodeesteproducto = Detalleinventarioingreso::where('producto_id', $producto->id)->get();
                        $sum = 0;
                        $cantidad = 0;

                        foreach ($detallesinvetarioingresodeesteproducto as $productodetallehistorico) {
                            // MAKES CONVERSION IF NECESSARY
                            if ($productodetallehistorico->inventarioingreso->tipomoneda == 'SOLES') {
                                $sum += ($productodetallehistorico->precio * $productodetallehistorico->cantidad_ingresada);
                            } else {
                                $sum += ($productodetallehistorico->precio * $productodetallehistorico->cantidad_ingresada * $productodetallehistorico->inventarioingreso->cambio_dolar_precio_venta);
                            }

                            $cantidad += $productodetallehistorico->cantidad_ingresada;
                        }

                        if ($cantidad != 0) {
                            $producto->precio = $sum / $cantidad;
                        } else {
                            // Handle division by zero error here if necessary
                        }
                    }

                    $producto->pivot->save();
                    $producto->save();

                    // logic to close the states of the detalles
                    if ($producto->pivot->cantidad == $producto->pivot->cantidad_ingresada) {
                        $producto->pivot->estado = 'INGRESADO';
                    }

                    // LOGIC TO MODIFY THE STATE OF THE INVENTARIOINGRESO
                    if ($producto->pivot->estado != 'INGRESADO') {
                        $closing = false;
                    }

                    $producto->pivot->save();
                }

                if ($closing == true) {
                    $inventarioingreso->estado = 'INGRESADO AL ALMACEN';
                }

                $inventarioingreso->usuario_recepcionista = auth()->user()->name;
                $inventarioingreso->save();

                return redirect()->route('inventarioingresos.index')->with('actualizar-recepcion', 'Recepción exitosa de productos.');
            }
        } catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al cancelar la orden al crédito.');
        } catch (\Exception $e) {
            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error al procesar la solicitud.' . $e->getMessage());
        }
    }










}
