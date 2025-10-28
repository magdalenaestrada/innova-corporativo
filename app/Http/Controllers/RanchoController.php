<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rancho;
use App\Models\Log;

use App\Models\Comida;
use App\Models\Persona;
use App\Models\Lote;
use Spatie\Permission\Models\Permission;

class RanchoController extends Controller
{



    public function __construct()
    { 
        $this->middleware('permission:view comedor', ['only' => ['index']]);
        $this->middleware('permission:create comedor', ['only' => ['create', 'store']]);
        $this->middleware('permission:print comedor', ['only' => ['prnpriview']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ranchos = Rancho::with('comida')->orderBy('created_at', 'desc')->paginate(20);
        return view('ranchos.index', compact('ranchos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $comidas = Comida::all();
        return view('ranchos.create', compact('comidas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'datos_cliente' =>'required',
            'documento_trabajador' => 'required|string|max:255',
            'datos_trabajador' => 'required|string|max:255',
            'lote' => 'required|string|max:255',
            'cantidad' => 'required',


        
        ]);

        $rancho = new Rancho;
        
        $rancho->documento_cliente = '0';
        $rancho->datos_cliente = $request->input('datos_cliente');
        $rancho->comida_id = $request->comida_id;

        $rancho->documento_trabajador = $request->input('documento_trabajador');
        $rancho->datos_trabajador = $request->input('datos_trabajador');
        $rancho->cantidad = $request->input('cantidad');
        $rancho->estado = 'abierto';
        $rancho->cancelado = 'no';
        $rancho->lote = $request->input('lote');
        $rancho->usuario = auth()->user()->name;

        $lote_nombre = $request->input('lote');
        $existingLote= Lote::where('nombre', $lote_nombre)->first();

        if($existingLote){
            
        }else{
            $lote = new Lote();
            $lote->nombre = $lote_nombre;
            $lote->usuario = auth()->user()->name;
            $lote->save();
        }

        
        $rancho->save();

        return redirect()->route('ranchos.index')->with('success', 'Ticket creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(rancho $rancho)
    {
        return view('ranchos.show', compact('rancho'));
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
        $rancho = Rancho::findOrFail($id);

        $log = new Log;
        $log->usuario = auth()->user()->name;
        $log->accion = 'eliminar rancho';
        $log->ip = '0';
        $log->id_fila_afectada = $rancho->id;
        $log->dato_importante = $rancho->lote;
        $log->save();
        



        $rancho->delete();



        return redirect()->route('ranchos.index')->with('eliminar-ticket', 'Ticket eliminado con éxito');


    }

    public function prnpriview(string $id)
    {
        $ranchos = Rancho::all();
        $rancho = Rancho::findOrFail($id);
        if ($rancho->estado == 'abierto')
        {
            $rancho->estado = 'impreso';
            $rancho->save();
        }
       
        
        return view('ranchos.printticket', compact('rancho'));
                
    }

    public function get_persona(){
        $p  = Persona::all();

        return response()->json($p);
    }


 

}
