<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invingresosrapidos;
use App\Models\Invingresosrapidosdetalles;
use App\Models\Producto;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Proveedor;

class InvingresosrapidosController extends Controller
{





    public function __construct()
    {
        $this->middleware('permission:ver producto', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear producto', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar producto', ['only' => ['update', 'edit']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        $invingresosrapidos = Invingresosrapidos::orderBy('created_at', 'desc')->paginate(20);
        return view('invingresosrapidos.index', compact('invingresosrapidos', 'productos'));
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

            // Validate the request data
            $request->validate([
                'products.*' => 'required|exists:productos,id',
                'product_price.*' => 'required|numeric',
                'qty.*' => 'required',
                'subtotals.*' => 'required|numeric',
                'product_sub_total' => 'required|numeric',
                'product_grand_total' => 'required|numeric',
                'proveedor' => 'required',
                'documento_proveedor' => 'required',
                'tipo_comprobante' => 'required',
                'comprobante_correlativo' => 'required',

            ]);
            // Create the order
            $invingresorapido = new Invingresosrapidos;
            $invingresorapido->tipo_comprobante     = $request->tipo_comprobante;
            if ($invingresorapido->tipo_comprobante == 'OTRO') {
                $invingresorapido->tipo_comprobante = $request->tipo_comprobante_especifico;
            }
            $invingresorapido->comprobante_correlativo = $request->comprobante_correlativo;
            $invingresorapido->total = $request->product_grand_total;
            $invingresorapido->subtotal = $request->product_sub_total;
            $invingresorapido->usuario_creador = auth()->user()->name;
            $invingresorapido->save();
            $products = $request->input('products');
            $index = 0;
            // Create order items
            foreach ($products as $productId) {
                Invingresosrapidosdetalles::create([
                    'inv_ingresosrapidos_id' => $invingresorapido->id,
                    'producto_id' => $productId,
                    'precio' => $request->product_price[$index],
                    'cantidad' => $request->qty[$index],
                    'cantidad_recepcionada' => $request->qty[$index],
                    'subtotal' => $request->item_total[$index],
                ]);
                $producto = Producto::find($productId);
                $producto->stock += $request->qty[$index];
                $producto->save();
                $index = $index + 1;
            }

            // Create or update the proveedor
            $proveedor = Proveedor::updateOrCreate(
                ['ruc' => $request->documento_proveedor],
                [
                    'razon_social' => $request->proveedor,
                    'telefono' => '-',
                    'direccion' => '-'
                ]
            );

            $invingresorapido->proveedor_id = $proveedor->id;
            $invingresorapido->save();

            // Redirect to a relevant page, e.g., order index or show
            return redirect()->route('invingresosrapidos.index')->with('crear-ingreso-rapido', 'Ingreso rapido creado con éxito.');
        } catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al crear el ingreso rápido.');
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
        //
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
            $invingresorapido = Invingresosrapidos::findOrFail($id);

            foreach ($invingresorapido->productos as $producto) {
                if ($producto->stock < $producto->pivot->cantidad) {
                    throw new HttpException(403, 'Si anulas se restará de tu stock (Revisa tu stock)');
                }
            }



            foreach ($invingresorapido->productos as $producto) {

                $producto->stock -= $producto->pivot->cantidad;
                $producto->save();
            }

            $invingresorapido->estado = 'ANULADO';

            $invingresorapido->save();

            return redirect()->route('invingresosrapidos.index')->with('status', 'Ingreso rápido anulado con éxito.');
        } catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al crear la orden.');
        } catch (\Exception $e) {


            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }
}
