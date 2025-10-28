<?php

namespace App\Http\Controllers;

use App\Models\Accion;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AccionController extends Controller
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
        $acciones = Accion::paginate(10);
        return view('acciones.index', compact('acciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('acciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validamos los datos del formulario
            $request->validate([
                'nombre_accion' => 'required|unique:accions,nombre_accion'
            ]);

            // Creamos una nueva acción
            $accion = new Accion;
            $accion->nombre_accion = $request->input('nombre_accion');
            $accion->descripcion_accion = $request->input('descripcion_accion');
            $accion->save();

            return redirect()->route('acciones.index')->with('crear-accion', 'Acción creada con éxito.');
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
    public function show(Accion $accione)
    {
        return view('acciones.show', compact('accione')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accion $accione)
    {
        return view('acciones.edit', compact('accione'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accion $accione)
    {
        try {
            // Validamos los datos del formulario
            $request->validate([
                'nombre_accion' => 'required|unique:accions,nombre_accion,' . $id
            ]);
    
            // Actualizamos la acción existente
            $accione->nombre_accion = $request->input('nombre_accion');
            $accione->descripcion_accion = $request->input('descripcion_accion');
            $accione->save();
    
            return redirect()->route('acciones.index')->with('editar-accion', 'Acción actualizada con éxito.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->withInput()->with('error', 'Ya existe un registro con este valor.');
            } else {
                return redirect()->back()->with('error', 'Error desconocido.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accion $accione)
    {
        try {
            // Eliminamos la acción
            $accione->delete();
    
            return redirect()->route('acciones.index')->with('eliminar-accion', 'Acción eliminada con éxito.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', 'No se puede eliminar la acción porque está relacionada con otros registros.');
            } else {
                return redirect()->back()->with('error', 'Error desconocido al intentar eliminar la acción.');
            }
        }
    }
}
