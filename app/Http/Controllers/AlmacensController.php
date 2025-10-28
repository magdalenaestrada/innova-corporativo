<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\User;
use Illuminate\Http\Request;

class AlmacensController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $almacenes = Almacen::with('responsable')->paginate(10);
        return view('almacenes.index', compact('almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        return view('almacenes.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'ruc_almacen' => 'required|string',
                'nombre_almacen' => 'required|string',
                'horario_almacen' => 'required|string',
                'responsable_id' => 'required|exists:users,id',
                'contacto_almacen' => 'required|string',
                'ubicacion_almacen' => 'required|string',
                'descripcion_almacen' => 'nullable|string',
            ]);

            // Crear un nuevo objeto Almacen
            $almacen = new Almacen();

            // Asignar los valores individualmente
            $almacen->ruc_almacen = $request->ruc_almacen;
            $almacen->nombre_almacen = $request->nombre_almacen;
            $almacen->horario_almacen = $request->horario_almacen;
            $almacen->responsable_id = $request->responsable_id;
            $almacen->contacto_almacen = $request->contacto_almacen;
            $almacen->ubicacion_almacen = $request->ubicacion_almacen;
            $almacen->descripcion_almacen = $request->descripcion_almacen;

            // Guardar el objeto en la base de datos
            $almacen->save();

            // Redireccionar a la vista o ruta deseada después de guardar
            return redirect()->route('almacenes.index')->with('success', 'El almacén se ha guardado exitosamente.');
        } catch (QueryException $e) {
            // Manejar la excepción de la base de datos
            return redirect()->route('almacenes.index')->with('error', 'Error al guardar el almacén: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Almacen $almacene)
    {
        return view('almacenes.show', compact('almacene'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $almacen = Almacen::findOrFail($id);
        $usuarios = User::all();
        return view('almacenes.edit', compact('almacen', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'ruc_almacen' => 'required|string',
                'nombre_almacen' => 'required|string',
                'horario_almacen' => 'required|string',
                'responsable_id' => 'required|exists:users,id',
                'contacto_almacen' => 'required|string',
                'ubicacion_almacen' => 'required|string',
                'descripcion_almacen' => 'nullable|string',
            ]);

            // Obtener el almacen existente por su ID
            $almacen = Almacen::findOrFail($id);

            // Actualizar los campos con los nuevos valores
            $almacen->ruc_almacen = $request->ruc_almacen;
            $almacen->nombre_almacen = $request->nombre_almacen;
            $almacen->horario_almacen = $request->horario_almacen;
            $almacen->responsable_id = $request->responsable_id;
            $almacen->contacto_almacen = $request->contacto_almacen;
            $almacen->ubicacion_almacen = $request->ubicacion_almacen;
            $almacen->descripcion_almacen = $request->descripcion_almacen;

            // Guardar los cambios en la base de datos
            $almacen->save();

            // Redireccionar a la vista o ruta deseada después de guardar
            return redirect()->route('almacenes.index')->with('success', 'El almacén se ha actualizado exitosamente.');
        } catch (QueryException $e) {
            // Manejar la excepción de la base de datos
            return redirect()->route('almacenes.index')->with('error', 'Error al actualizar el almacén: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Obtener el almacén por su ID
            $almacen = Almacen::findOrFail($id);

            // Eliminar el almacén
            $almacen->delete();

            // Redireccionar a la vista o ruta deseada después de eliminar
            return redirect()->route('almacenes.index')->with('success', 'El almacén se ha eliminado exitosamente.');
        } catch (\Exception $e) {
            // Manejar la excepción
            return redirect()->route('almacenes.index')->with('error', 'Error al eliminar el almacén: ' . $e->getMessage());
        }
    }
}
