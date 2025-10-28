<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\TsMotivo;

class TsMotivoController extends Controller
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
        $motivos = TsMotivo::orderBy('created_at', 'desc')->paginate(30);
        return view('tesoreria.motivos.index', compact('motivos'));
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
        try{

            $request->validate([
                'nombre' => 'required|max:255|string|unique:ts_motivos,nombre'
            ]);
    
            $motivos = TsMotivo::create([
                'nombre' => $request->nombre,
                'creador_id' => auth()->id(),
            ]);
        
            return redirect()->route('tsmotivos.index')->with('status', 'Motivo de movimiento creado con éxito.');
            
            }
            catch(QueryException $e){
                    if ($e->getCode() == '23000'){
                        return redirect()->back->withInput()->with('error', 'Ya existe un registro con este valor.');
                    }else{
                        return redirect()->back()->with('error', 'Error desconocido');
                    }
    
            } catch (\Exception $e)  {
    
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
        //
    }
}
