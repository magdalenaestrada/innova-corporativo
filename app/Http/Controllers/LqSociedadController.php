<?php

namespace App\Http\Controllers;

use App\Models\LqCliente;
use App\Models\LqSociedad;
use App\Models\LqSociedadCliente;
use Illuminate\Http\Request;

class LqSociedadController extends Controller
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
        $sociedades = LqSociedad::orderByRaw('CAST(codigo AS DECIMAL(10,2)) DESC')->paginate(30);
        $clientes = LqCliente::all();
        $sociedadesclientes = LqSociedadCliente::orderBy('created_at', 'desc')->paginate(20);

        return view('liquidaciones.sociedades.index', compact('sociedades', 'clientes', 'sociedadesclientes'));
        
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
        // Validate the request data
        $request->validate([
            'codigo' => 'required|unique:lq_sociedades,codigo',
            'nombre' => 'required|unique:lq_sociedades,nombre',
        ]);

        // Create the society
        $sociedad = LqSociedad::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'creador_id' => auth()->id(),
        ]);

        // Handle client relationships
        if ($request->filled('clientes')) {
            $clientes = $request->input('clientes');

            // Create society-client relationships
            foreach ($clientes as $clienteId) {
                if (!empty($clienteId)) { // Ensure clienteId is not null or empty
                    LqSociedadCliente::create([
                        'sociedad_id' => $sociedad->id,
                        'cliente_id' => $clienteId,
                        'creador_id' => auth()->id(),
                    ]);
                } else {
                    // Log a warning for empty cliente_id
                    \Log::warning('Received empty cliente_id for sociedad_id: ' . $sociedad->id);
                }
            }
        }

        // Redirect to a relevant page with success message
        return redirect()->route('lqsociedades.index')->with('status', 'Sociedad creada con éxito.');

    } catch (ValidationException $e) {
        // Handle validation errors
        return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al crear la sociedad.');
    } catch (\Exception $e) {
        // Handle other unexpected errors
        return back()->withInput()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
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
                
                'nombre' => 'nullable',

            ]);

            $sociedad = LqSociedad::findOrFail($id);
            $sociedad->nombre = $request->nombre;
            $sociedad->save();


            //UPDATE THE BALANCE
            
         
            

       

            return redirect()->route('lqsociedades.index')->with('status', 'Sociedad actualizada con éxito.');
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

    public function searchSociedad(Request $request)
    {
        $sociedades = LqSociedad::where('nombre', 'like', '%' . $request->search_string . '%')
        ->orWhere('codigo', 'like', '%' . $request->search_string . '%')
        ->orderBy('created_at', 'desc')->get();
        return view('liquidaciones.sociedades.search-results', compact(var_name: 'sociedades'));
    }




    

}
