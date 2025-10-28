<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::orderBy('created_at', 'desc')->paginate(20);
        return view('proveedores.index', compact('proveedores'));
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
        //
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




    public function searchProveedor(Request $request)
    {
        $proveedor = Proveedor::where('razon_social', '=', $request->search_string)->firstOrFail();
        
        return response()->json(['ruc' => $proveedor->ruc, 'telefono' => $proveedor->telefono, 'direccion' => $proveedor->direccion]);
    }


    public function searchProveedorByRuc(Request $request)
    {
        $proveedor = Proveedor::where('ruc', '=', $request->search_string)->firstOrFail();
        return response()->json(['razon_social' => $proveedor->razon_social, 'telefono' => $proveedor->telefono, 'direccion' => $proveedor->direccion]);

    }


}
