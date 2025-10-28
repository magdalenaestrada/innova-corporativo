<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventarioingresoapertura;
use App\Models\Producto;


class InventarioingresoaperturaController extends Controller
{


    public function __construct()
    { 
        $this->middleware('permission:usar apertura');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventarioingresosapertura = Inventarioingresoapertura::orderBy('created_at', 'desc')->paginate(50);
        $productos = Producto::all();

        return view('inventarioingresoapertura.index', compact('inventarioingresosapertura', 'productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('inventarioingresoapertura.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try{
        $request->validate([
            'producto' => 'required',
            'stock' => 'required',
        ]);

        $inventarioingresoapertura = new Inventarioingresoapertura;
        $inventarioingresoapertura->producto_id = $request->input('producto');
        $inventarioingresoapertura->stock = $request->input('stock');
        $inventarioingresoapertura->precio_inicial ='no';
        $inventarioingresoapertura->usuario_creador = auth()->user()->name;

        $inventarioingresoapertura->save();

        $producto= $inventarioingresoapertura->producto;
        $producto->stock = $request->input('stock');

        $producto->save();


        return redirect()->route('inventarioingresoapertura.index')->with('status', 'Apertura de producto de almacen realizada exitosamente.');



        }catch (ValidationException $e) {

             // If validation fails during the transaction, handle the error
             return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al crear la orden.');
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
