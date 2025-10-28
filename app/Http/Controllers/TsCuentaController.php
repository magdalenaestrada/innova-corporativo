<?php

namespace App\Http\Controllers;

use App\Models\TsCuenta;
use App\Models\TsBanco;
use App\Models\Empleado;
use App\Models\TipoMoneda;
use App\Models\Chat;
use App\Models\LqAdelanto;
use App\Models\LqSociedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TsCuentaController extends Controller
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


        $cuentas = TsCuenta::orderBy('created_at', 'desc')->paginate(30);
        $empleados = Empleado::orderBy('created_at', 'asc')->paginate(30);
        $bancos = TsBanco::orderBy('created_at', 'asc')->paginate(30);
        $tiposmonedas = TipoMoneda::all();






        // Sociedades with top 6 Adelantos in DOLARES
        $sociedadesDolares = LqSociedad::with(['adelantos.salidacuenta.cuenta'])
            ->get()
            ->map(function ($sociedad) {
                $adelantos = $sociedad->adelantos;

                // Log sociedad details
                \Log::info("Sociedad: {$sociedad->nombre}, Adelantos: " . json_encode($adelantos->toArray()));

                $totalMonto = $adelantos
                    ->filter(function ($adelanto) {
                        $cuentaNombre = optional($adelanto->salidacuenta->cuenta->tipomoneda)->nombre;

                        // Log filtered adelanto details
                        \Log::info("Cuenta Nombre: {$cuentaNombre}, Adelanto ID: {$adelanto->id}");
                        return $cuentaNombre === 'DOLARES'; // Filter by "DOLARES" accounts
                    })
                    ->sum(function ($adelanto) {
                        return optional($adelanto->salidacuenta)->monto ?? 0; // Sum the amounts
                    });

                return [
                    'name' => $sociedad->nombre,
                    'total' => $totalMonto,
                ];
            })
            ->sortByDesc('total') // Sort by total in descending order
            ->take(6) // Take the top 6 societies
            ->values(); // Reset the array keys



        // Sociedades with top 6 Adelantos in SOLES
        $sociedadesSoles = LqSociedad::with(['adelantos.salidacuenta.cuenta'])
            ->get()
            ->map(function ($sociedad) {
                $adelantos = $sociedad->adelantos;

                // Log sociedad details
                \Log::info("Sociedad: {$sociedad->nombre}, Adelantos: " . json_encode($adelantos->toArray()));

                $totalMonto = $adelantos
                    ->filter(function ($adelanto) {
                        $cuentaNombre = optional($adelanto->salidacuenta->cuenta->tipomoneda)->nombre;

                        // Log filtered adelanto details
                        \Log::info("Cuenta Nombre: {$cuentaNombre}, Adelanto ID: {$adelanto->id}");
                        return $cuentaNombre === 'SOLES'; // Filter by "DOLARES" accounts
                    })
                    ->sum(function ($adelanto) {
                        return optional($adelanto->salidacuenta)->monto ?? 0; // Sum the amounts
                    });

                return [
                    'name' => $sociedad->nombre,
                    'total' => $totalMonto,
                ];
            })
            ->sortByDesc('total') // Sort by total in descending order
            ->take(6) // Take the top 6 societies
            ->values(); // Reset the array keys
        



        return view('tesoreria.cuentas.index', compact(
            'sociedadesDolares',
            'sociedadesSoles',
            'cuentas',
            'empleados',
            'bancos',
            'tiposmonedas',
            'chats'
        ));
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
                'nombre' => 'required|max:255|string|unique:ts_cuentas,nombre',
                'tipo_moneda_id' => 'required',
                'banco_id' => 'nullable',
                'encargado_id' => 'nullable',

            ]);

            $cuenta = TsCuenta::create([
                'nombre' => $request->nombre,
                'tipo_moneda_id' => $request->tipo_moneda_id,
                'banco_id' => $request->banco_id,
                'encargado_id' => $request->encargado_id,
                'creador_id' => auth()->id(),
            ]);

            return redirect()->route('tscuentas.index')->with('status', 'Cuenta creada con éxito.');
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
                'nombre' => 'nullable|string|max:255',

            ]);

            $cuenta = TsCuenta::findOrFail($id);

            $cuenta->nombre = $request->nombre;
            $cuenta->save();





            //UPDATE THE BALANCE




            return redirect()->route('tscuentas.index')->with('status', 'Cuenta actualizada con éxito.');
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
        //
    }
}
