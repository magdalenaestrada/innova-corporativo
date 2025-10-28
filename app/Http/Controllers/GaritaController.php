<?php

namespace App\Http\Controllers;

use App\Models\Garita;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GaritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $garitas = Garita::with('responsable')->paginate(10);
        return view('garitas.index', compact('garitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        return view('garitas.create', ['usuarios' => $usuarios]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'ruc_empresa' => 'required|unique:garitas,ruc_empresa|numeric|digits:11',
                'nombre_garita' => 'required|unique:garitas,nombre_garita',
                'ubicacion_garita' => 'required',
                'horario' => 'required',
                'responsable_id' => 'required|exists:users,id',
                'contacto' => 'required'
            ]);
    
            // Lógica para guardar en la base de datos
            $garita = new Garita;
            $garita->ruc_empresa = $request->input('ruc_empresa');
            $garita->nombre_garita = $request->input('nombre_garita');
            $garita->ubicacion_garita = $request->input('ubicacion_garita');
            $garita->horario = $request->input('horario');
    
            // Buscar o crear el usuario responsable
            $responsable = User::find($request->input('responsable_id'));
            if ($responsable) {
                $garita->responsable_id = $responsable->id;
            } else {
                return redirect()->back()->withInput()->withErrors(['responsable_id' => 'El responsable seleccionado no existe. Por favor, elige uno válido.']);
            }
    
            $garita->contacto = $request->input('contacto');
            $garita->descripcion_garita = $request->input('descripcion_garita');
            $garita->save();
    
            return redirect()->route('garitas.index')->with('crear-garita', 'Garita creada con éxito.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->withInput()->with('error', 'Ya existe una garita con este nombre. Por favor, elige otro nombre.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Error desconocido.');
            } 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Garita $garita)
    {
        return view('garitas.show', compact('garita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //Encuentra la garita por su ID
        $garita = Garita::findOrFail($id);
        $usuarios = User::all();
        return view('garitas.edit', compact('garita', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Validamos la solicitud
        $request->validate([
            'nombre_garita' => 'required',
            'ubicacion_garita' => 'required',
            'horario' => 'required',
            'responsable_id' => 'required',
            'contacto' => 'required'
        ]);

        //Obtenemos la garita que se va a actualizar
        $garita = Garita::findOrFail($id);

        //Actualizamos los campos del modelo con los nuevos valores
        $garita->nombre_garita = $request->input('nombre_garita');
        $garita->ubicacion_garita = $request->input('ubicacion_garita');
        $garita->horario = $request->input('horario');
        $garita->responsable_id = $request->input('responsable_id');

        //Buscamos o creamos el usuario responsable
        $responsable = User::find($request->input('responsable_id'));
        if (!$responsable) {
            return redirect()->back()->withInput()->withErrors(['responsable_id' => 'El responsable seleccionado no existe. Por favor, elige uno válido']);
        }
        $garita->responsable_id = $responsable->id;

        $garita->contacto = $request->input('contacto');
        $garita->descripcion_garita = $request->input('descripcion_garita');

        //Guardamos los cambios
        $garita->save();

        return redirect()->route('garitas.index')->with('editar-garita', 'Garita actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Encontramos la garita que se va a eliminar
        $garita = Garita::findOrFail($id);

        //Eliminamos la garita
        $garita->delete();

        return redirect()->route('garitas.index')->with('eliminar-garita', 'Garita eliminada con éxito.');
    }
}
