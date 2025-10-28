<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventariosalida;
use App\Models\Producto;
use App\Models\Docinventariosalida;
use App\Models\Detalleinventariosalida;
use App\Models\Logdetallesinvsalida;
use Symfony\Component\HttpKernel\Exception\HttpException;


class InventariosalidaController extends Controller
{


    public function __construct()
    { 
        $this->middleware('permission:ver requerimientos', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear requerimientos', ['only' => ['create', 'store']]);
        $this->middleware('permission:entregar requerimientos', ['only' => ['entregar', 'updateentregar']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();

        $inventariosalidas = Inventariosalida::orderBy('created_at', 'desc')->paginate(20);
        return view('inventariosalidas.index', compact('inventariosalidas', 'productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('inventariosalidas.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
        // Validate the request data
        $request->validate([
            'products.*' => 'required|exists:productos,id',
            'qty.*' => 'required|integer|min:1',
            'descripcion' => 'nullable|string',

            //FOR DOC TABLE
            'documento_solicitante' => 'required',
            'nombre_solicitante' => 'required',
            'area_solicitante' => 'required',
            'prioridad' => 'required',
            'codigo' => 'required|unique:productos,nombre_producto',
        ]);

        // Create the order
        $inventariosalida = Inventariosalida::create([
            'descripcion' => $request->descripcion,
        ]);

        $inventariosalida->estado = 'PENDIENTE';
        $inventariosalida->usuario_requerimiento = auth()->user()->name;
        $inventariosalida->save();

        $products = $request->input('products');
        $index = 0;
        // Create order items
        foreach ($products as $productId) {
            Detalleinventariosalida::create([
                'inventariosalida_id' => $inventariosalida->id,
                'producto_id' => $productId,
                'cantidad' => $request->qty[$index],
                'estado' => 'PENDIENTE',

            ]);
            $index = $index + 1;
        }



        //CREATE DOC
        $doc = new Docinventariosalida;
        $doc->documento_solicitante = $request->documento_solicitante;
        $doc->nombre_solicitante = $request->nombre_solicitante;
        $doc->area_solicitante = $request->area_solicitante;
        $doc->prioridad = $request->prioridad;
        $doc->codigo = $request->codigo;
        $doc->inventariosalida_id = $inventariosalida->id;
        $doc->save();



        // Redirect to a relevant page, e.g., order index or show
        return redirect()->route('inventariosalidas.index')->with('status', 'Requerimiento creado con éxito.');
    
        }catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al ingresar los datos.');
        } catch (\Exception $e) {

            
            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error al procesar la solicitud: '.$e->getMessage());
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventariosalida $inventariosalida)
    {

        $inventariosalida = Inventariosalida::with('productos')->find($inventariosalida->id);
        return view('inventariosalidas.show', compact('inventariosalida'));

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


    public function entregar(string $id)
    {
        $inventariosalida = Inventariosalida::findOrFail($id);




        return view('inventariosalidas.entregar', compact('inventariosalida'));

    }



    public function updateentregar(Request $request, string $id)
    {
        
        $inventariosalida = Inventariosalida::findOrFail($id);
        

        if ($inventariosalida->estado !== 'PENDIENTE') {
            throw new HttpException(404, 'NO PUEDES INGRESAR MÁS PRODUCTOS DE LOS QUE ESTAN PENDIENTES.');
        }
            
        $closing = true;

        $productos = $inventariosalida->productos;


            
        foreach ($productos as $producto) {

            if (in_array($producto->id, $request->input('selected_products', []))) {
                $cantidad_entregada = $request->input('qty_arrived.' . $producto->id);

                if($producto->pivot->cantidad < $producto->pivot->cantidad_entregada + $cantidad_entregada)
                {
                        throw new HttpException(403, 'NO PUEDES INGRESAR MÁS PRODUCTOS DE LOS QUE ESTAN PENDIENTES.');
                }

                if($producto->stock < $cantidad_entregada)
                {
                        throw new HttpException(403, 'NO HAY SUFICIENTE STOCK.');
                }

                $producto->pivot->cantidad_entregada += $cantidad_entregada;

                $producto->stock -= $cantidad_entregada;

                //FILLING THE LOGDETALLESINVENTARIOSALIDA TABLE
                $logdetallesinvsalida = new Logdetallesinvsalida;
                $logdetallesinvsalida->detalleinventariosalida_id = $producto->pivot->id;

                $logdetallesinvsalida->usuario = auth()->user()->name;
                $logdetallesinvsalida->cantidad_entregada = $cantidad_entregada;

                $logdetallesinvsalida->save();

                }

            $producto->pivot->save();
            $producto->save();

            //logic to close the states of the detalles
            if($producto->pivot->cantidad == $producto->pivot->cantidad_entregada)
            {
                $producto->pivot->estado = 'ENTREGADO';
            }

            //LOGIC TO MODIFY THE STATE OF THE INVENTARIOINGRESO 
            if ($producto->pivot->estado != 'ENTREGADO')
            {
                $closing = false;
            }

            $producto->pivot->save();

            if ($closing == true){
                $inventariosalida->estado = 'INGRESADO AL ALMACEN';
            }

        }
        $inventariosalida->usuario_entrega = auth()->user()->name;
        $inventariosalida->save();
        
        return redirect()->route('inventariosalidas.index')->with('entregar-requerimiento', 'Requerimiento entregado con éxito.');

    }



    public function printdoc(string $id)
    {

        $inventariosalida = Inventariosalida::with('productos')->findOrFail($id);

        return view('inventariosalidas.printdoc', compact('inventariosalida'));
                
    }




}
