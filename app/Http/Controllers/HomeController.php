<?php

namespace App\Http\Controllers;

use App\Models\Accion;
use App\Models\Motivo;
use App\Models\Registro;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Inventarioingreso;
use App\Models\Inventariosalida;
use App\Models\Message;
use App\Models\Chat;
use App\Models\TsIngresoCuenta;
use App\Models\TsSalidaCuenta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener la lista de motivos

        $chats = Chat::where(function ($query) {
            $query->where('user_id', auth()->id())
                ->orWhere('recipient_id', auth()->id());
        })
            ->with(['messages' => function ($query) {
                // Get the messages, ordered by the latest
                $query->orderBy('created_at', 'desc');
            }])
            ->get();
        
      

        // Crear una consulta dinámica para obtener la cantidad de registros por motivo y acción
       

        // Finalizar la consulta
        
        // Crear el array de datos para el gráfico
       

        // $messages = Message::all();
        // foreach ($messages as $message){
        //     $message->is_read = true;
        //     $message->save();
        // }

        $total_productos = Producto::count();
        $total_inventarioingresos = Inventarioingreso::count();
        $total_inventariosalidas = Inventariosalida::count();
        $total_proveedores = Proveedor::count();
   

        $salidas_cuentas_dolares = TsSalidaCuenta::whereHas('cuenta.tipomoneda', function ($query) {
            $query->where('nombre', 'dolares');
        })
        ->select(DB::raw('DATE_FORMAT(fecha, "%d/%m/%Y") as date'), DB::raw('SUM(monto) as total_monto'))
        ->groupBy('date')
        ->orderBy('fecha') // Use the original date format for ordering
        ->get();



        $salidas_cuentas_soles = TsSalidaCuenta::whereHas('cuenta.tipomoneda', function ($query) {
            $query->where('nombre', 'soles');
        })
        ->select(DB::raw('DATE_FORMAT(fecha, "%d/%m/%Y") as date'), DB::raw('SUM(monto) as total_monto'))
        ->groupBy('date')
        ->orderBy('fecha') // Use the original date format for ordering
        ->get();


      
        $ingresos_cuentas_dolares = TsIngresoCuenta::whereHas('cuenta.tipomoneda', function ($query) {
            $query->where('nombre', 'dolares');
        })
        ->select(DB::raw('DATE_FORMAT(fecha, "%d/%m/%Y") as date'), DB::raw('SUM(monto) as total_monto'))
        ->groupBy('date')
        ->orderBy('fecha') // Use the original date format for ordering
        ->get();

        $ingresos_cuentas_soles = TsIngresoCuenta::whereHas('cuenta.tipomoneda', function ($query) {
            $query->where('nombre', 'soles');
        })
        ->select(DB::raw('DATE_FORMAT(fecha, "%d/%m/%Y") as date'), DB::raw('SUM(monto) as total_monto'))
        ->groupBy('date')
        ->orderBy('fecha') // Use the original date format for ordering
        ->get();
        $inventarios_ingresos_soles = Inventarioingreso::where('tipomoneda',  'SOLES')->get();
        $inventarios_ingresos_dolares = Inventarioingreso::where('tipomoneda',  'DOLARES')->get();
    




        return view('admin.index', compact('total_productos', 'total_inventarioingresos','total_inventariosalidas','total_proveedores', 'salidas_cuentas_soles', 'salidas_cuentas_dolares', 'ingresos_cuentas_dolares', 'ingresos_cuentas_soles', 'inventarios_ingresos_soles', 'inventarios_ingresos_dolares', 'chats'));
    
    
    
    }
}
