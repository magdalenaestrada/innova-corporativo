<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductosFamilia;

class ProductosFamiliaController extends Controller
{




    public function __construct()
    { 
        $this->middleware('permission:ver familia', ['only' => ['index']]);
        $this->middleware('permission:crear familia', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar familia', ['only' => ['update', 'edit']]);
        $this->middleware('permission:eliminar familia', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productosfamilias = Productosfamilia::orderBy('created_at', 'desc')->paginate(20);
        return view('productosfamilias.index', compact('productosfamilias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productosfamilias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_familia' => 'required|unique:productosfamilias,nombre',
           
        ]);

        $productosfamilia = ProductosFamilia::create([
            'nombre' => $request->nombre_familia,
            'descripcion' => $request->descripcion,
            
        ]);

        return redirect()->route('productosfamilias.index')->with('crear-familia', 'Familia creada con éxito.');


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
        

        $productosfamilia = ProductosFamilia::findOrFail($id);
        $productosfamilias = ProductosFamilia::all();

        return view('productosfamilias.edit', compact('productosfamilia', 'productosfamilias'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'productosfamilia_id' => 'required',
           
        ]);

        $productosfamilia = ProductosFamilia::findOrFail($id);
        $productosfamilia->parent_id = $request->productosfamilia_id;
        $productosfamilia->save();
        return redirect()->route('productosfamilias.index')->with('actualizar-familia', 'Familia actualizada con éxito.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
