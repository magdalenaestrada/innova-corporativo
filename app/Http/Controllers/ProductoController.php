<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Unidad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\ProductosFamilia;
use App\Models\Log;
use App\Exports\ProductosExport;
use Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Process;

class ProductoController extends Controller
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
        $productos = DB::table('productos')
            ->leftJoin('productosfamilias', 'productos.productosfamilia_id', '=', 'productosfamilias.id')  // Join productosfamilias table
            ->leftJoin('unidades', 'productos.unidad_id', '=', 'unidades.id')  // Join unidades table
            ->orderBy('productos.nombre_producto')
            ->select(
                'productos.*',
                'productosfamilias.nombre as familia_nombre',  // Select familia name
                'unidades.nombre as unidad_nombre',  // Select unidad name
            )
            ->paginate(50);

        $unidades = Unidad::orderBy('nombre')->get();

        $productosfamilias = ProductosFamilia::all();

        return view('productos.index', compact('productos', 'productosfamilias', 'unidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unidades = Unidad::orderBy('nombre')->get();
        return view('productos.create', compact('unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validamos los datos del formulario
            $request->validate([
                'nombre_producto' => 'nullable|unique:productos,nombre_producto',

            ]);

            // Creamos una nueva acción
            $producto = new Producto;
            $producto->nombre_producto = $request->input('nombre_producto');
            $producto->descripcion_producto = $request->input('descripcion_producto');
            $producto->observacion = $request->input('observacion');
            $producto->codigo_producto = 0;
            $producto->precio = $request->precio ?? 0;
            $producto->stock = 0;
            $producto->usuario = auth()->user()->name;
            $producto->unidad_id =  $request->input('unidad_id');

            $producto->save();

            return redirect()->route('productos.index')->with('crear-producto', 'Producto creado con éxito.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->withInput()->with('error', 'Ya existe un registro con este valor.');
            } else {
                return redirect()->back()->with('error', 'Error desconocido.');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    
     public function show(Producto $producto)
     {
         // Extrae el nombre del producto para la búsqueda de imágenes
         $query = $producto->nombre_producto;
     
         // Ejecuta el script Python directamente desde PHP, asumiendo que este retorna la URL
     
         // Retorna la vista con el producto y la URL de la imagen
         return view('productos.show', compact('producto'));
     }
     
    
     
     



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        $productosfamilias = ProductosFamilia::all();
        $unidades = Unidad::all();


        return view('productos.edit', compact('producto', 'productosfamilias', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([]);

        $producto = Producto::findOrFail($id);
        $producto->productosfamilia_id = $request->productosfamilia_id;
        $producto->nombre_producto = $request->nombre_producto;
        $producto->unidad_id = $request->unidad_id;
        if ($producto->precio == 0) {
            $producto->precio = $request->valor_promedio;
        }

        $producto->save();


        $log = new Log;
        $log->accion = "editar producto";
        $log->usuario = auth()->user()->name;
        $log->ip = '-';
        $log->id_fila_afectada = $producto->id;
        $log->dato_importante = 'request' . json_encode($request->all());
        $log->save();






        return redirect()->route('productos.index', ['page' => $request->page])
            ->with('actualizar-producto', 'Producto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $producto = Producto::findOrFail($id);

            // Eliminamos el producto
            $producto->delete();

            $log = new Log;
            $log->accion = "eliminar producto";
            $log->usuario = auth()->user()->name;
            $log->ip = '-';
            $log->id_fila_afectada = $id;
            $log->dato_importante = $producto->nombre_producto;
            $log->save();



            return redirect()->route('productos.index')->with('eliminar-producto', 'Producto eliminado con éxito.');
        } catch (QueryException $e) {

            


            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', 'No se puede eliminar el producto porque está relacionado con otros registros.');
            } else {
                return redirect()->back()->with('error', 'Error desconocido al intentar eliminar el producto.');
            }
        }
    }




    public function export_excel()
    {
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }





    //search product
    public function searchProduct(Request $request)
    {
        $productos = Producto::where('nombre_producto', 'like', '%' . $request->search_string . '%')
            ->orWhere('codigo_producto', 'like', '%' . $request->search_string . '%')
            ->orderBy('nombre_producto')
            ->paginate(20);

        return view('productos.search-results', compact('productos'));
    }




    public function dailyrotation(string $id)
    {
        // Fetch the product by ID
        $producto = Producto::findOrFail($id);

        // Filter 'salidasrapidasdetails' where related 'salidarapida' has 'estado' equal to NULL
        $salidasrapidasdetails = $producto->salidasrapidasdetails()
            ->whereHas('salidarapida', function ($query) {
                $query->whereNull('estado'); // Corrected to check for NULL
            })
            ->get();

        // If you want 'pruebas' to include all salidasrapidasdetails, regardless of the filter:
        $pruebas = $producto->salidasrapidasdetails; // This fetches all details

        // Aggregate the cantidad field by date
        $dailyData = $salidasrapidasdetails->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m-d');
        })->map(function ($day) {
            return $day->sum('cantidad');
        });

        // Pass the aggregated data to the view
        return view('productos.rotations.daily', [
            'producto' => $producto,
            'salidasrapidas' => $salidasrapidasdetails,
            'dailyData' => $dailyData,
            'pruebas' => $pruebas,
        ]);
    }






    
}
