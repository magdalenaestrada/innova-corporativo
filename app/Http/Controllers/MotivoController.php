<?php

namespace App\Http\Controllers;

use App\Models\Motivo;
use Illuminate\Http\Request;

class MotivoController extends Controller
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
        $motivos = Motivo::paginate(10);
        return view('motivos.index', compact('motivos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('motivos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_motivo' => 'required|unique:motivos,nombre_motivo',
                'descripcion_motivo' => 'nullable'
            ], [
                'nombre_motivo.unique' => 'El motivo ya existe en la base de datos.'
            ]);
    
            $motivo = new Motivo;
            $motivo->nombre_motivo = $request->input('nombre_motivo');
            $motivo->descripcion_motivo = $request->input('descripcion_motivo');
            $motivo->save();
    
            return redirect()->route('motivos.index')->with('crear-motivo', 'Motivo creado con éxito.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                // Código para manejar la excepción de clave única duplicada (puedes personalizar este mensaje según tus necesidades)
                return redirect()->back()->withInput()->with('error', 'El motivo ya existe en la base de datos.');
            } else {
                // Código para manejar otras excepciones desconocidas
                return redirect()->back()->with('error', 'Error desconocido al crear el motivo.');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(motivo $motivo)
    {
        return view('motivos.show', compact('motivo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $motivo = Motivo::findOrFail($id);
        return view('motivos.edit', compact('motivo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre_motivo' => 'required'
        ]);

        //Obtenemos la garita que se va a actualizar
        $motivo = Motivo::findOrFail($id);

        //Actualizamos los atributos del modelo motivo con los nuevos valores
        $motivo->nombre_motivo = $request->input('nombre_motivo');
        $motivo->descripcion_motivo = $request->input('descripcion_motivo');
        $motivo->save();

        return redirect()->route('motivos.index')->with('editar-motivo', 'Motivo actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Encontramos la garita que se va a eliminar
        $motivo = Motivo::findOrFail($id);

        //Eliminamos la garita
        $motivo->delete();

        return redirect()->route('motivos.index')->with('eliminar-motivo', 'Motivo eliminado con éxito.');
    }
}
