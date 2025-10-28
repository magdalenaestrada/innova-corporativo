<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventarioingreso;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Detalleinventarioingreso;
use App\Models\Logdetallesinvingreso;
use App\Models\Inventariopagoacuenta;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Excel;
use App\Exports\DetalleInventarioIngresoExport;
use Illuminate\Support\Facades\DB;


class InventarioingresoController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:ver ordenes', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear ordenes', ['only' => ['create', 'store']]);
        $this->middleware('permission:cancelar ordenes', ['only' => ['cancelar', 'updatecancelar', 'cancelaralcredito', 'updatecancelaralcredito']]);
        $this->middleware('permission:recepcionar ordenes', ['only' => ['recepcionar', 'updaterecepcionar']]);
        //$this->middleware('permission:anular ordenes', ['only' => ['anular']]);
    }


    /**
     * Actualiza únicamente 'cotizacion' (sin tocar otros campos).
     */
  
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        $inventarioingresos = Inventarioingreso::orderBy('created_at', 'desc')->paginate(100);
        return view('inventarioingresos.index', compact('inventarioingresos', 'productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('inventarioingresos.create', compact('productos'));
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
                'observacion' => 'nullable|string',
                'product_grand_total' => 'required|numeric',
                'product_sub_total' => 'required|numeric',
                'proveedor' => 'required',
                'documento_proveedor' => 'required',
                'tipomoneda' => 'required',
                'cotizacion'=> 'nullable|string|max:255'
            ]);

            // Create the order
            $inventarioingreso = Inventarioingreso::create([
                'descripcion' => $request->observacion,
                'total' => $request->product_grand_total,
                'subtotal' => $request->product_sub_total,
                'cotizacion'   => $request->cotizacion ?? $request->codigo_cotizacion,
                'tipomoneda' => $request->tipomoneda,
            ]);

            $inventarioingreso->estado = 'PENDIENTE';
            $inventarioingreso->estado_pago = 'PENDIENTE DE PAGO';
            $inventarioingreso->usuario_ordencompra = auth()->user()->name;
            $inventarioingreso->save();

            $products = $request->input('products');
            $index = 0;
            // Create order items
            foreach ($products as $productId) {
                Detalleinventarioingreso::create([
                    'inventarioingreso_id' => $inventarioingreso->id,
                    'producto_id' => $productId,
                    'precio' => $request->product_price[$index],
                    'cantidad' => $request->qty[$index],
                    'subtotal' => $request->item_total[$index],
                    'estado' => 'PENDIENTE',

                ]);
                $index = $index + 1;
            }



            // Create or update the proveedor
            $proveedor = Proveedor::updateOrCreate(
                ['ruc' => $request->documento_proveedor],
                [
                    'razon_social' => $request->proveedor,
                    'telefono' => $request->telefono_proveedor,
                    'direccion' => $request->direccion_proveedor,
                ]
            );

            $inventarioingreso->proveedor_id = $proveedor->id;
            $inventarioingreso->save();







            // Redirect to a relevant page, e.g., order index or show
            return redirect()->route('inventarioingresos.index')->with('crear-orden', 'Orden de compra creada con éxito.');
        } catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al crear la orden.');
        } catch (\Exception $e) {


            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventarioingreso $inventarioingreso)
    {

        $inventarioingreso = Inventarioingreso::with('productos')->find($inventarioingreso->id);
        return view('inventarioingresos.show', compact('inventarioingreso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
 public function edit(string $id)
{
    $inventarioingreso = Inventarioingreso::with(['proveedor','productos'])->findOrFail($id);
    return view('inventarioingresos.edit', compact('inventarioingreso'));
}

public function update(Request $request, string $id)
{
    // Solo actualizar 'cotizacion'
    $request->merge([
        'cotizacion' => trim((string) $request->cotizacion),
    ]);

    $validated = $request->validate([
        'cotizacion' => ['required','string','max:120'],
    ], [
        'cotizacion.required' => 'La cotización es obligatoria.',
        'cotizacion.max'      => 'La cotización no debe exceder 120 caracteres.',
    ]);

    $inventarioingreso = Inventarioingreso::findOrFail($id);

    if ($inventarioingreso->estado === 'ANULADO') {
        throw new \Symfony\Component\HttpKernel\Exception\HttpException(
            403, 'No se puede editar la cotización de una orden ANULADA.'
        );
    }

    DB::transaction(function () use ($inventarioingreso, $validated) {
        $inventarioingreso->cotizacion = $validated['cotizacion'];
        $inventarioingreso->save();
    });

    return redirect()
        ->route('inventarioingresos.index')
        ->with('actualizar-cotizacion', 'Cotización actualizada con éxito.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }






    public function cancelar(string $id)
    {
        $inventarioingreso = Inventarioingreso::findOrFail($id);
        return view('inventarioingresos.cancelar', compact('inventarioingreso'));
    }



    public function updatecancelar(Request $request, string $id)
    {
        $request->validate([
            'comprobante_correlativo' => 'required',
            'fecha_cancelacion' => 'required',
            'fecha_emision_comprobante' => 'required',
            'tipopago' => 'required',

        ]);
        $inventarioingreso = Inventarioingreso::findOrFail($id);


        if ($inventarioingreso->estado !== 'PENDIENTE') {
            throw new HttpException(403, 'No puedes acceder a esta página');
        }



        $inventarioingreso->comprobante_correlativo = $request->input('comprobante_correlativo');
        $inventarioingreso->fecha_cancelacion = $request->input('fecha_cancelacion');
        $inventarioingreso->tipocomprobante = 'FACTURA';
        $inventarioingreso->tipopago = $request->input('tipopago');
        $inventarioingreso->fecha_emision_comprobante = $request->input('fecha_emision_comprobante');
        $inventarioingreso->usuario_cancelacion = auth()->user()->name;
        $inventarioingreso->estado = 'POR RECOGER';
        $inventarioingreso->cambio_dolar_precio_venta =  $request->input('cambio_dia');

        if ($request->input('tipopago') == 'CONTADO') {
            $inventarioingreso->estado_pago = 'CANCELADO AL CONTADO';
        } elseif ($request->input('tipopago') == 'A CUENTA') {
            $inventarioingreso->estado_pago = 'PENDIENTE A CUENTA';
        } else {
            $inventarioingreso->estado_pago = 'PENDIENTE AL CRÉDITO';
        }

        $inventarioingreso->save();

        return redirect()->route('inventarioingresos.index')->with('cancelar-orden-compra', 'Orden de compra cancelada exitosamente.');
    }





    public function cancelaralcredito(string $id)
    {
        $inventarioingreso = Inventarioingreso::findOrFail($id);

        return view('inventarioingresos.cancelaralcredito', compact('inventarioingreso'));
    }



    public function updatecancelaralcredito(Request $request, string $id)
    {
        $inventarioingreso = Inventarioingreso::findOrFail($id);

        if ($inventarioingreso->estado_pago == 'PENDIENTE AL CRÉDITO') {
            $request->validate([
                'fecha_pago_al_credito' => 'required',
            ]);

            $inventarioingreso->fecha_pago_al_credito = $request->input('fecha_pago_al_credito');
            $inventarioingreso->usuario_pago_al_credito = auth()->user()->name;

            $inventarioingreso->estado_pago = 'CANCELADO AL CRÉDITO';

            $inventarioingreso->save();

            return redirect()->route('inventarioingresos.index')->with('cancelar-al-credito', 'Orden cancelada al crédito con éxito.');
        }
    }




    public function cancelaracuenta(string $id)
    {
        $inventarioingreso = Inventarioingreso::findOrFail($id);
        if ($inventarioingreso->estado_pago !== 'PENDIENTE A CUENTA') {
            throw new HttpException(403, 'NO ESTÁ PENDIENTE A CUENTA.');
        }

        $today = now()->toDateString();
        return view('inventarioingresos.cancelaracuenta', compact('inventarioingreso', 'today'));
    }



    public function updatecancelaracuenta(Request $request, string $id)
    {

        try {
            $request->validate([
                'fechas_pagos.*' => 'required',
                'montos.*' => 'required',
                'comprobantes.*' => 'required',

            ]);

            $inventarioingreso = Inventarioingreso::findOrFail($id);

            if ($inventarioingreso->estado_pago !== 'PENDIENTE A CUENTA') {
                throw new HttpException(403, 'NO ESTÁ PENDIENTE A CUENTA.');
            }

            $countFechasPagos = count($request->fechas_pagos);
            $fechas_pagos = $request->input('fechas_pagos');
            $index = 0;
            // Create order items
            for ($i = 0; $i < $countFechasPagos; $i++) {
                Inventariopagoacuenta::create([
                    'inventarioingreso_id' => $inventarioingreso->id,
                    'fecha_pago' => $request->fechas_pagos[$index],
                    'monto' => $request->montos[$index],
                    'comprobante_correlativo' => $request->comprobantes[$index],
                    'usuario' => auth()->user()->name,
                ]);
                $index = $index + 1;
            }

            $cerrar_pago = False;
            $monto_total_pagado = 0;
            foreach ($inventarioingreso->pagosacuenta as $pago) {
                $monto_total_pagado += $pago->monto;
            }

            if ($monto_total_pagado >= $inventarioingreso->total) {
                $inventarioingreso->estado_pago = 'CANCELADO A CUENTA';
            }

            $inventarioingreso->save();

            return redirect()->route('inventarioingresos.index')->with('cancelar-al-credito', 'Orden cancelada al crédito con éxito.');
        } catch (ValidationException $e) {
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al cancelar la orden al crédito.');
        } catch (\Exception $e) {
            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error al procesar la solicitud.');
        }
    }



   public function updaterecepcionar(Request $request, string $id)
{
    $request->validate([
        'guiaingresoalmacen' => 'nullable|string|max:120',
    ]);

    $inventarioingreso = Inventarioingreso::with('productos')->findOrFail($id);

    if ($inventarioingreso->estado !== 'POR RECOGER') {
        throw new HttpException(403, 'La orden no está en estado POR RECOGER.');
    }

    $selected   = collect($request->input('selected_products', []))->map(fn($v)=>(int)$v)->all();
    $qtyArrived = $request->input('qty_arrived', []);

    // Normaliza la guía: null o '', según prefieras
    $guia = $request->filled('guiaingresoalmacen')
        ? Str::limit(trim((string)$request->guiaingresoalmacen), 120)
        : ''; // <- usa '' para evitar errores si alguna columna es NOT NULL

    DB::transaction(function () use ($inventarioingreso, $selected, $qtyArrived, $guia) {
        $closing = true;

        foreach ($inventarioingreso->productos as $producto) {
            $pivot   = $producto->pivot;
            $pivotId = (int) $pivot->id;

            if (!in_array($pivotId, $selected, true)) {
                if ($pivot->estado !== 'INGRESADO') $closing = false;
                continue;
            }

            $cantidad_recepcionada = (int) ($qtyArrived[$pivotId] ?? 0);
            if ($cantidad_recepcionada <= 0) {
                throw new HttpException(422, 'Cantidad inválida para uno de los productos.');
            }

            $pedido    = (int) $pivot->cantidad;
            $ingresado = (int) $pivot->cantidad_ingresada;
            $pendiente = $pedido - $ingresado;
            if ($cantidad_recepcionada > $pendiente) {
                throw new HttpException(403, 'NO PUEDES INGRESAR MÁS PRODUCTOS DE LOS QUE HAY POR RECIBIR.');
            }

            $pivot->cantidad_ingresada = $ingresado + $cantidad_recepcionada;
            $pivot->guiaingresoalmacen = $guia; // '' si vacío
            $producto->stock = (int) $producto->stock + $cantidad_recepcionada;

            $log = new Logdetallesinvingreso();
            $log->detalleinventarioingreso_id = $pivotId;
            $log->usuario = auth()->user()->name;
            $log->cantidad_ingresada = $cantidad_recepcionada;
            $log->guiaingresoalmacen = $guia;     // '' si vacío
            $log->save();

            if ($inventarioingreso->tipomoneda === 'SOLES') {
                $producto->ultimoprecio = $pivot->precio;
            } else {
                $producto->ultimoprecio = $pivot->precio * (float) $inventarioingreso->cambio_dolar_precio_venta;
            }

            $pivot->estado = $pivot->cantidad_ingresada >= $pedido ? 'INGRESADO' : $pivot->estado;
            if ($pivot->estado !== 'INGRESADO') $closing = false;

            $pivot->save();
            $producto->save();

            // (opcional) recalcular promedio ponderado...
        }

        if ($closing) $inventarioingreso->estado = 'INGRESADO AL ALMACEN';
        $inventarioingreso->usuario_recepcionista = auth()->user()->name;
        $inventarioingreso->save();
    });

    return redirect()->route('inventarioingresos.index')
        ->with('actualizar-recepcion', 'Recepción exitosa de productos.');
}

    public function prnpriview(string $id)
    {

        $inventarioingreso = Inventarioingreso::with('productos')->findOrFail($id);


        return view('inventarioingresos.printticket', compact('inventarioingreso'));
    }


    public function anular(string $id)
    {
        DB::beginTransaction();
        try {
            $inventarioingreso = Inventarioingreso::findOrFail($id);
            
            foreach($inventarioingreso->productos as $producto){
                if($producto->stock < $producto->pivot->cantidad_ingresada){
                    throw new HttpException(403, 'NO HAY SUFICIENTES PRODUCTOS EN EL ALMACEN PARA CANCELAR LA ORDEN.');
                }


                $producto->stock -= $producto->pivot->cantidad_ingresada;
                $producto->save();
            }

            $inventarioingreso->estado = 'ANULADO';
            $inventarioingreso->save();
            DB::commit();
            return redirect()->route('inventarioingresos.index')->with('anular-orden-compra', 'Orden de compra anulada con éxito.');

        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error desconocido');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    //excel for detalles of this
    public function export_excel()
    {
        return Excel::download(new DetalleInventarioIngresoExport, 'detalleordenesdecompra.xlsx');
    }

    public function getProductByBarcode($barcode)
    {
        $product = Producto::where('barcode', $barcode)->first();

        if ($product) {
            return response()->json(['success' => true, 'product' => $product]);
        } else {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
    }

    public function getProductImageByProduct($product)
    {
        $product = Producto::with('unidad')->find($product);


        if ($product) {
            return response()->json(['success' => true, 'product' => $product]);
        } else {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
    }

    public function getSellingPrice(Request $request)
    {
        try {
            $token = env('APIS_TOKEN');
            $fecha = $request->input('fecha'); // Get the selected date from the request

            // Make API call to get selling price
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.apis.net.pe/v2/sunat/tipo-cambio?date=' . $fecha,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 2,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => ['Referer: https://apis.net.pe/tipo-de-cambio-sunat-api', 'Authorization: Bearer ' . $token],
            ]);

            $response = curl_exec($curl);

            if ($response === false) {
                throw new Exception('Error fetching data from the API');
            }

            curl_close($curl);

            // Decode API response and extract selling price
            $tipoCambioSunat = json_decode($response);
            $precio_venta = $tipoCambioSunat->precioVenta;

            // Return selling price as JSON response
            return response()->json(['precio_venta' => $precio_venta]);
        } catch (Exception $e) {
            // Handle exception
            // Log error or show a friendly message to the user
            // You might want to return an error response
            return response()->json(['error' => 'Error fetching data from the API'], 500);
        }
    }





    //search ingreso
   // public function searchIngreso(Request $request)
    //{
    //    $searchString = $request->search_string;

    //    $inventarioingresos = Inventarioingreso::where('comprobante_correlativo', 'like', '%' . $searchString . '%')
    //        ->orWhereHas('productos', function ($query) use ($searchString) {
    //            $query->where('nombre_producto', 'like', '%' . $searchString . '%');
    //        })
    //        ->orderBy('id', 'desc')
   //         ->paginate(100);

    //    return view('inventarioingresos.search-results', compact('inventarioingresos'));
  //  }
  public function searchIngreso(Request $request)
{
    $searchString = $request->search_string;

    $inventarioingresos = Inventarioingreso::where('comprobante_correlativo', 'like', "%{$searchString}%")
        ->orWhere('cotizacion', 'like', "%{$searchString}%") // <--- NUEVO
        ->orWhereHas('productos', function ($query) use ($searchString) {
            $query->where('nombre_producto', 'like', "%{$searchString}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(100);

    return view('inventarioingresos.search-results', compact('inventarioingresos'));
}
}
