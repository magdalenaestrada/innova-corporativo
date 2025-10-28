<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventarioprestamoingreso;
use App\Models\Inventarioprestamoingresodetalle;
use App\Models\Producto;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InventarioprestamoingresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestamoingresos = Inventarioprestamoingreso::orderBy('created_at', 'desc')->paginate(30);
        $productos = Producto::all();

        return view('inventariopringresos.index', compact('prestamoingresos', 'productos'));
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
            $request->validate([
                'products.*' => 'required|exists:productos,id',
                'qty.*' => 'required|integer|min:1',


                'documento_responsable' => 'required',
                'nombre_responsable' => 'required',
                'origen' => 'required',
                'condicion' => 'required',
                'observacion' => 'required|string',
            ]);

            $products0 = $request->input('products');
            $index0 = 0;
            foreach ($products0 as $productId) {

                $producto = Producto::findOrFail($productId);
                $cantidad = $request->qty[$index0];


                $producto->stock += $cantidad;
                $producto->save();

                $index0 = $index0 + 1;
            }

            $inventarioprestamoingreso = new Inventarioprestamoingreso;
            $inventarioprestamoingreso->documento_responsable = $request->documento_responsable;
            $inventarioprestamoingreso->nombre_responsable = $request->nombre_responsable;
            $inventarioprestamoingreso->origen = $request->origen;
            $inventarioprestamoingreso->condicion = $request->condicion;
            $inventarioprestamoingreso->observacion = $request->observacion;
            $inventarioprestamoingreso->usuario_creador = auth()->user()->name;
            $inventarioprestamoingreso->estado = 'PRESTAMO PENDIENTE DE DEVOLUCIÓN';

            $inventarioprestamoingreso->save();


            $products = $request->input('products');
            $index = 0;
            foreach ($products as $productId) {
                $producto = Producto::find($productId);
                Inventarioprestamoingresodetalle::create([
                    'inventariopringreso_id' => $inventarioprestamoingreso->id,
                    'producto_id' => $productId,
                    'cantidad' => $request->qty[$index],
                    'estado' => 'PENDIENTE',
                    //fix this
                    'precio_ingreso' => $producto->ultimoprecio ?? 0,
                ]);
                $index = $index + 1;
            }


            return redirect()->route('inventarioprestamoingreso.index')->with('status', 'Ingreso como préstamo creada con éxito.');
        } catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al crear préstamo.');
        } catch (\Exception $e) {


            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
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
        $inventarioprestamoingreso = Inventarioprestamoingreso::findOrFail($id);
        if ($inventarioprestamoingreso->estado == 'PRESTAMO DEVUELTO') {
            throw new HttpException(404, 'ERROR.');
        }
        if ($inventarioprestamoingreso->condicion == 'SIN DEVOLUCIÓN') {
            throw new HttpException(404, 'ERROR.');
        }
        $inventarioprestamoingreso->usuario_devol_confirm = auth()->user()->name;
        $inventarioprestamoingreso->estado = 'PRESTAMO DEVUELTO';
        $inventarioprestamoingreso->save();


        $productos = $inventarioprestamoingreso->productos;
        foreach ($productos as $producto) {
            $producto->stock -= $producto->pivot->cantidad;
            $producto->save();
        }



        return redirect()->route('inventarioprestamoingreso.index')->with('status', 'Retorno de productos prestados realizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function anular(string $id)
    {

        try {
            $inventarioprestamoingreso = Inventarioprestamoingreso::findOrFail($id);

            foreach ($inventarioprestamoingreso->productos as $producto) {
                if ($producto->stock < $producto->pivot->cantidad) {
                    throw new HttpException(403, 'Si anulas se restará de tu stock (Revisa tu stock porque no hay suficientes productos)');
                }
            }



            foreach ($inventarioprestamoingreso->productos as $producto) {

                $producto->stock -= $producto->pivot->cantidad;
                $producto->save();
            }

            $inventarioprestamoingreso->estado = 'ANULADO';

            $inventarioprestamoingreso->save();

            return redirect()->route('inventarioprestamoingreso.index')->with('status', 'Prestamo como ingreso anulado con éxito.');
        } catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al crear la orden.');
        } catch (\Exception $e) {


            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }
}
