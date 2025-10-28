<?php

namespace App\Http\Controllers;

use App\Exports\TsIngresoCuentaExport;
use Illuminate\Http\Request;

use App\Models\TsIngresoCuenta;
use App\Models\TsCuenta;
use App\Models\TsMotivo;
use App\Models\Chat;
use App\Models\TipoComprobante;
use App\Models\TsCliente;
use App\Models\TsDepositoCuenta;
use App\Models\LqSociedad;
use Illuminate\Support\Facades\DB;

use Excel;

class TsIngresocuentaController extends Controller
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

        $ingresoscuentas = TsIngresoCuenta::orderBy('fecha', 'desc')->orderBy('created_at', 'desc')->paginate(50);
        $tiposcomprobantes = TipoComprobante::orderBy('nombre', 'asc')->get();
        $cuentas = TsCuenta::orderBy('created_at', 'desc')->paginate(30);
        $motivos = TsMotivo::orderBy('nombre', 'asc')->get();

        $sociedades = LqSociedad::orderBy('created_at', direction: 'asc')->get();

        return view('tesoreria.ingresoscuentas.index', compact('ingresoscuentas', 'tiposcomprobantes', 'cuentas', 'motivos', 'chats', 'sociedades'));
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
                'descripcion' => 'nullable',
                'documento' =>  'nullable', //DOCUMENTO DEL CLIENTE 
                'nombre' =>  'nullable', //NOMBRE DEL CLIENTE

            ]);

            $ingreso_cuenta = TsIngresoCuenta::create([
                'monto' => $request->monto,
                'tipo_comprobante_id' => $request->tipo_comprobante_id,
                'comprobante_correlativo' => $request->comprobante_correlativo,
                'descripcion' => $request->descripcion,
                'cuenta_id' => $request->cuenta_id,
                'motivo_id' => $request->motivo_id,
                'creador_id' => auth()->id(),
            ]);

            $cuenta = TsCuenta::findOrFail($request->cuenta_id);
            $cuenta->balance += $request->monto;
            $cuenta->save();

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
            } else {
                $ingreso_cuenta->fecha = $ingreso_cuenta->created_at;
            }
            $ingreso_cuenta->save();


            return redirect()->route('tsingresoscuentas.index')->with('status', 'Ingreso a la cuenta creado con éxito.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back->withInput()->with('error', 'Ya existe un registro con este valor.');
            } else {
                return redirect()->back()->with('error', 'Error desconocido');
            }
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

            $ingresocuenta = TsIngresoCuenta::findOrFail($id);

            $ingresocuenta->descripcion = $request->descripcion;
            $ingresocuenta->fecha = $request->fecha;





            //UPDATE THE BALANCE

            $cuenta = TsCuenta::findOrFail($ingresocuenta->cuenta->id);
            $cuenta->balance = $cuenta->balance + ($request->monto - $ingresocuenta->monto);
            $cuenta->save();

            $ingresocuenta->monto = $request->monto;



            $ingresocuenta->save();


            return redirect()->route('tsingresoscuentas.index')->with('status', 'Ingreso a la cuenta actualizado con éxito.');
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

            $ingresocuenta = TsIngresoCuenta::findOrFail($id);
            $ingresocuenta->cuenta->balance -= $ingresocuenta->monto;
            $ingresocuenta->cuenta->save();
            if ($ingresocuenta->cuenta->balance < 0) {
                throw new \Exception('No puedes eliminar este ingreso porque tu cuenta quedará con un saldo negativo.');
            }

            $ingresocuenta->delete();


            DB::commit();
            return redirect()->route('tsingresoscuentas.index')->with('status', 'Ingreso a la cuenta eliminado con éxito.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function recepcionardeposito($request, $salida_cuenta_id)
    {
        try {

            //EN CASO DE QUE SE REALICE UN CAMBIO DE DOLARES A SOLES SE HACE UNA CONVERISÓN
            if ($request->tipo_cambio) {
                $request->monto *= $request->tipo_cambio;
            }

            $ingreso_cuenta = TsIngresoCuenta::create([
                'monto' => $request->monto,
                'tipo_comprobante_id' => $request->tipo_comprobante_id,
                'comprobante_correlativo' => $request->comprobante_correlativo,
                'tipo_cambio' => $request->tipo_cambio,
                'descripcion' => $request->descripcion,
                'cuenta_id' => $request->cuenta_beneficiaria_id,
                'motivo_id' => $request->motivo_id,
                'creador_id' => auth()->id(),
            ]);

            //ACTUALIZAR EL BALANCE DE LA CUENTA DESPUÉS DEL INGRESO DEPÓSITO
            $cuenta = TsCuenta::findOrFail($request->cuenta_beneficiaria_id);
            $cuenta->balance += $request->monto;
            $cuenta->save();


            if ($request->fecha) {
                $ingreso_cuenta->fecha = $request->fecha;
            } else {
                $ingreso_cuenta->fecha = $ingreso_cuenta->created_at;
            }
            $ingreso_cuenta->save();


            $ts_deposito_cuenta = TsDepositoCuenta::create([
                'ts_salida_cuenta_id' => $salida_cuenta_id,
                'ts_ingreso_cuenta_id' => $ingreso_cuenta->id,
                'tipo_cambio' => $request->tipo_cambio
            ]);
        } catch (QueryException $e) {

            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }



    public function export_excel(Request $request)
    {

        $cuenta_id = $request->input('cuenta_id');
        $motivo_id = $request->input('motivo_id');
        $tipo_comprobante_id = $request->input('tipo_comprobante_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        return Excel::download(new TsIngresoCuentaExport($cuenta_id, $motivo_id, $tipo_comprobante_id, $start_date, $end_date), 'ingresoscuentas.xlsx');
    }





    public function printdoc(string $id)
    {

        $ingresocuenta = TsIngresoCuenta::findOrFail($id);


        return view('tesoreria.ingresoscuentas.printable', compact('ingresocuenta'));
    }



    public function searchIngresosCuentas(Request $request)
    {
        $ingresoscuentas = TsIngresoCuenta::where('descripcion', 'like', '%' . $request->search_string . '%')
            ->orWhere('id', 'like', '%' . $request->search_string . '%')
            ->orWhere('comprobante_correlativo', 'like', '%' . $request->search_string . '%')
            ->orWhere('monto', 'like', '%' . $request->search_string . '%')
            ->orWhereRaw("DATE_FORMAT(fecha, '%d/%m/%Y') like ?", ['%' . $request->search_string . '%'])
            ->orWhereHas('tipocomprobante', function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->search_string . '%');
            })
            ->orWhereHas('cuenta', function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->search_string . '%');
            })
            ->orWhereHas('motivo', function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->search_string . '%');
            })

            ->orWhereHas('cliente', function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->search_string . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();


        return view('tesoreria.ingresoscuentas.search-results', compact('ingresoscuentas'));
    }


    public function findCliente(Request $request)
    {
        $cliente = TsCLiente::where('nombre', '=', $request->search_string)->firstOrFail();
        return response()->json(['documento' => $cliente->documento]);
    }
}
