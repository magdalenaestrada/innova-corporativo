<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EstadoController extends Controller
{

    public function __construct()
    { 
        $this->middleware('permission:administrar externos');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estado::paginate(10);
        return view('estados.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_estado' => 'required|unique:estados,nombre_estado',
                'status' => 'required|in:0,1'
            ]);
    
            $estado = new Estado;
            $estado->nombre_estado = $request->input('nombre_estado');
            $estado->descripcion_estado = $request->input('descripcion_estado');
            $estado->status = $request->input('status');
            $estado->save();
    
            return redirect()->route('estados.index')->with('crear-estado', 'Estado creado con éxito.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->withInput()->with('error', 'Ya existe un registro con este valor.');
            } else {
                return redirect()->back()->with('error', 'Error desconocido.');
            } 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(estado $estado)
    {
        return view('estados.show', compact('estado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estado $estado)
    {
        return view('estados.edit', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre_estado' => 'required'
        ]);

        //Obtenemos la garita que se va a actualizar
        $estado = Estado::findOrFail($id);

        //Actualizamos los campos según la soliitud
        $estado->nombre_estado = $request->input('nombre_estado');
        $estado->descripcion_estado = $request->input('descripcion_estado');

        // Actualizamos el campo status dependiendo del valor del checkbox
        $estado->status = $request->input('status') ? true : false;

        $estado->save();

        return redirect()->route('estados.index')->with('editar-estado', 'Estado actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Buscamos el estado que se va a eliminar
        $estado = Estado::findOrFail($id);

        //Eliminamos el estado
        $estado->delete();

        return redirect()->route('estados.index')->with('eliminar-estado', 'Estado eliminado con éxito.');
    }
}
