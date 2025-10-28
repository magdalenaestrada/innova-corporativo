<?php

namespace App\Http\Controllers;

use App\Models\LqCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LqClienteController extends Controller
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
        $clientes = LqCliente::orderBy('created_at', 'desc')->paginate(30);
        return view('liquidaciones.clientes.index', compact('clientes'));
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

        DB::beginTransaction();
        try {

            $request->validate([
                'documento' => 'required|max:255|string|unique:lq_clientes,documento',
                'nombre' => 'required|max:255|string|unique:lq_clientes,nombre',
            ]);

            $empleado = LqCliente::create([
                'documento' => $request->documento,
                'nombre' => $request->nombre,
                'creador_id' => auth()->id(),
            ]);


            DB::commit();

            return redirect()->route('lqclientes.index')->with('status', 'Cliente creado con éxito.');
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == '23000') {
                return redirect()->back->withInput()->with('error', 'Ya existe un registro con este valor.');
            } else {
                return redirect()->back()->with('error', 'Error desconocido');
            }
        } catch (\Exception $e) {
            DB::rollBack();

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




    //FOR AJAX
    public function getLqClienteByNombre($cliente)
    {
        $cliente = LqCliente::find($cliente);


        if ($cliente) {
            return response()->json(['success' => true, 'cliente' => $cliente]);
        } else {
            return response()->json(['success' => false, 'message' => 'Lote no encontrado']);
        }
    }
}
