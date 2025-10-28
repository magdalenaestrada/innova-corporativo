<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventarioprestamosalida;
use App\Models\Inventarioprestamosalidadetalle;
use App\Models\Producto;
use Symfony\Component\HttpKernel\Exception\HttpException;


class InventarioprestamosalidaController extends Controller
{




    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestamosalidas = Inventarioprestamosalida::orderBy('created_at', 'desc')->paginate(30);
        $productos = Producto::all();

        return view('inventarioprsalidas.index', compact('prestamosalidas', 'productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('inventarioprsalidas.create', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'products.*' => 'required|exists:productos,id',
                'qty.*' => 'required|integer|min:1',


                'documento_responsable' => 'required',
                'nombre_responsable' => 'required',
                'destino' => 'required',
                'condicion' => 'required',
                'observacion' => 'required|string',
            ]);

            $products0 = $request->input('products');
            $index0 = 0;
            foreach ($products0 as $productId) {

                $producto = Producto::findOrFail($productId);
                $cantidad = $request->qty[$index0];
                if ($producto->stock < $cantidad) {
                    throw new HttpException(403, 'NO TIENES SUFICIENTES PRODUCTOS PARA HACER ESTE PRÉSTAMO.');
                }

                $producto->stock -= $cantidad;
                $producto->save();

                $index0 = $index0 + 1;
            }

            $inventarioprestamosalida = new Inventarioprestamosalida;
            $inventarioprestamosalida->documento_responsable = $request->documento_responsable;
            $inventarioprestamosalida->nombre_responsable = $request->nombre_responsable;
            $inventarioprestamosalida->destino = $request->destino;
            $inventarioprestamosalida->condicion = $request->condicion;
            $inventarioprestamosalida->observacion = $request->observacion;
            $inventarioprestamosalida->usuario_creador = auth()->user()->name;
            $inventarioprestamosalida->estado = 'PRESTAMO PENDIENTE DE DEVOLUCIÓN';

            $inventarioprestamosalida->save();


            $products = $request->input('products');
            $index = 0;
            foreach ($products as $productId) {
                $producto = Producto::find($productId);
                Inventarioprestamosalidadetalle::create([
                    'inventarioprsalida_id' => $inventarioprestamosalida->id,
                    'producto_id' => $productId,
                    'cantidad' => $request->qty[$index],
                    'estado' => 'PENDIENTE',
                    'precio_salida' => $producto->ultimoprecio ?? 0,
                ]);
                $index = $index + 1;
            }


            return redirect()->route('inventarioprestamosalida.index')->with('crear-prestamo-salida', 'Salida como préstamo creada con éxito.');
        } catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al crear el prestamo.');
        } catch (\Exception $e) {


            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventarioprestamosalida $inventarioprestamosalida)
    {
        $inventarioprestamosalida = Inventarioprestamosalida::find($inventarioprestamosalida->id);
        return view('inventarioprsalidas.show', compact('inventarioprestamosalida'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventarioprestamosalida $inventarioprestamosalida)
    {
        $inventarioprestamosalida = Inventarioprestamosalida::find($inventarioprestamosalida->id);
        return view('inventarioprsalidas.edit', compact('inventarioprestamosalida'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventarioprestamosalida = Inventarioprestamosalida::findOrFail($id);
        if ($inventarioprestamosalida->estado == 'PRESTAMO DEVUELTO') {
            throw new HttpException(404, 'ERROR.');
        }
        if ($inventarioprestamosalida->condicion == 'SIN DEVOLUCIÓN') {
            throw new HttpException(404, 'ERROR.');
        }
        $inventarioprestamosalida->usuario_devol_confirm = auth()->user()->name;
        $inventarioprestamosalida->estado = 'PRESTAMO DEVUELTO';
        $inventarioprestamosalida->save();


        $productos = $inventarioprestamosalida->productos;
        foreach ($productos as $producto) {
            $producto->stock += $producto->pivot->cantidad;
            $producto->save();
        }
        return redirect()->route('inventarioprestamosalida.index')->with('actualizar-retorno', 'Retorno de productos prestados realizado con éxito.');
    }





    public function printdoc(string $id)
    {

        $inventarioprestamosalida = Inventarioprestamosalida::with('productos')->findOrFail($id);
        return view('inventarioprsalidas.printdoc', compact('inventarioprestamosalida'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
