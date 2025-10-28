<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invsalidasrapidas;
use App\Models\Invsalidasrapidasdetalles;
use App\Models\Producto;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;
use App\Exports\DetalleInventarioSalidaRapidaExport;
use App\Models\Persona;
use Excel;
use Illuminate\Support\Facades\DB;


class InvsalidasrapidasController extends Controller
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
        $invsalidasrapidas = Invsalidasrapidas::orderBy('created_at', 'desc')->paginate(100);
        $today =  Carbon::today();
        return view('invsalidasrapidas.index', compact('invsalidasrapidas','productos', 'today'));
   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
        // Validate the request data
        $request->validate([
            'products.*' => 'required|exists:productos,id',
            'qty.*' => 'required|integer|min:1',
            'destino' => 'required',
            'documento_solicitante' => 'required',
            'nombre_solicitante' => 'required',

        ]);

        $products_p = $request->input('products');
        $index_p = 0;
        // Create order items
        foreach ($products_p as $productId) {
            $producto = Producto::find($productId);

            if  ($producto->stock < $request->qty[$index_p]) {
                throw new HttpException(403, 'No tienes suficientes productos para entregar.');
            }
            $producto->save();
            $index_p = $index_p + 1;
        }
        // Create the order
        $invsalidarapida = new Invsalidasrapidas;
        $invsalidarapida->destino = $request->destino;
        $invsalidarapida->documento_solicitante = $request->documento_solicitante;
        $invsalidarapida->nombre_solicitante = $request->nombre_solicitante;
        $invsalidarapida->usuario_creador = auth()->user()->name;
        $invsalidarapida->save();
        $products = $request->input('products');
        $index = 0;
        // Create order items
        foreach ($products as $productId) {
            Invsalidasrapidasdetalles::create([
                'inv_salidasrapidas_id' => $invsalidarapida->id,
                'producto_id' => $productId,
                'cantidad' => $request->qty[$index],
            ]);
            $producto = Producto::find($productId);
            $producto->stock -= $request->qty[$index];
            $producto->save();
            $index = $index + 1;
        }



        $persona = Persona::firstOrCreate(
            ['datos_persona' => $request->nombre_solicitante, 'documento_persona' => $request->documento_solicitante]
        );


        DB::commit();

        } catch (ValidationException $e) {

            DB::rollBack();
            // If validation fails during the transaction, handle the error
            return back()->withInput()->withErrors($e->validator->errors())->with('error', 'Error al cancelar la orden al crédito.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle other unexpected errors
            return back()->withInput()->with('error', 'Error: '.$e->getMessage());
        }



        
        


        // Redirect to a relevant page, e.g., order index or show
        return redirect()->route('invsalidasrapidas.index')->with('crear-salida-rapida', 'Salida rápida creada con éxito.');

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


    public function prnpriview(string $id)
    {

        $invsalidarapida = Invsalidasrapidas::findOrFail($id);

        
        return view('invsalidasrapidas.printdoc', compact('invsalidarapida'));
                
    }



    public function anular(string $id)
    {
        $inventariosalidarapida = Invsalidasrapidas::findOrFail($id);
        $inventariosalidarapida->estado = 'ANULADO';
        foreach( $inventariosalidarapida->productos as $producto )
        {
            
            $producto->stock += $producto->pivot->cantidad;
            $producto->save(); 
            
            

        }

        $inventariosalidarapida->save();

        return redirect()->route('invsalidasrapidas.index')->with('anular-salida-rapida', 'Salida rápida anulada con éxito.');

    }



  //search salidarapida
    public function searchSalidaRapida(Request $request)
    {
        $searchString = $request->search_string;
        $productos = Producto::all();
        $today =  Carbon::today();
        $invsalidasrapidas = Invsalidasrapidas::where('nombre_solicitante', 'like', '%' . $request->search_string . '%')
            ->orWhere('destino', 'like', '%' . $request->search_string . '%')
            ->orWhereHas('productos', function($query) use ($searchString) {
                $query->where('nombre_producto', 'like', '%' . $searchString . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(100);

        return view('invsalidasrapidas.search-results', compact('invsalidasrapidas','today', 'productos'));
    }


     //excel for detalles of this
    public function export_excel(Request $request){

        $destino = $request->input('destino');
        $nombre_solicitante = $request->input('nombre_solicitante');
        $producto_id = $request->input('producto_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        return Excel::download(new DetalleInventarioSalidaRapidaExport($destino, $nombre_solicitante, $producto_id, $start_date, $end_date), 'salidasrapidas.xlsx');
    
    }




}
