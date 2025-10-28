<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Invherramientas;

class InvherramientasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invherramientas = Invherramientas::orderBy('created_at', 'desc')->paginate(20);
        return view('invherramientas.index', compact('invherramientas'));

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
            // Validamos los datos del formulario
            $request->validate([
                'nombre' => 'required|unique:inv_herramientas,nombre',
                
            ]);

            // Creamos una nueva acción
            $inv_herramienta = new Invherramientas;
            $inv_herramienta->nombre = $request->input('nombre');
            $inv_herramienta->codigo = $request->input('codigo');
            $inv_herramienta->observacion = $request->input('observacion');
            $inv_herramienta->descripcion = $request->input('descripcion');
            $inv_herramienta->stock = $request->input('stock');
            

            $inv_herramienta->save();



            $log = new Log;
            $log->usuario = auth()->user()->name;
            $log->accion = 'crear herramienta inventario';
            $log->ip = '0';
            $log->id_fila_afectada = $inv_herramienta->id;
            $log->dato_importante = $inv_herramienta->stock.'stock';
            $log->save();





            return redirect()->route('invherramientas.index')->with('crear-herramienta', 'Herramienta creada con éxito.');
        }catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error de validación.'.$e->getMessage());
        } catch (\Exception $e) {

            
            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error al procesar la solicitud: '.$e->getMessage());
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
