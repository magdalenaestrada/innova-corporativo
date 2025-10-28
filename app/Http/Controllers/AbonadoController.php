<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abonado;
use App\Models\Rancho;
use Illuminate\Validation\Rule;


class AbonadoController extends Controller
{

    
    
    public function __construct()
    { 
        $this->middleware('permission:use pagos tickets comedor');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abonados = Abonado::orderBy('created_at', 'desc')->paginate(20);


           
        $ranchos = Rancho::has('abonados')->get(); // Only retrieve ranchos with abonados

        foreach ($ranchos as $rancho) {
            $rancho->cancelado = 'si';
            $rancho->save();


        }

        

        return view('abonados.index', compact('abonados'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        #retrieve documentos_clientes after grouping registros

        $lotes = Rancho::leftJoin('abonado_rancho', 'ranchos.id', '=', 'abonado_rancho.abonado_id')
            ->whereNull('abonado_rancho.id')
            ->distinct('lote')
            ->pluck('lote')
            ->toArray();

        # Filtro por los registros que ya existen (con estado pendiente)
        $lotes = array_filter($lotes, function ($lote) {
            $ranchos = Rancho::where('lote', $lote)->get();
            foreach ($ranchos as $rancho) {
                if ($rancho->cancelado != 'si') {
                    return true;
                }
            }
            return false;
        });

        
        $ranchos = Rancho::where(function ($query) {
                $query->where('cancelado', '!=', 'si');
            })
            ->get();


        return view('abonados.create', compact('lotes', 'ranchos'));

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lotes' => 'required|array',
            'fecha_cancelacion' => 'required',
            'ranchos' => 'required',
            
        ]);

       
        // Create a new Programacion instance
        $abonado = new Abonado();
        // Attach existing Registro records to the Programacion
        $abonado->fecha_cancelacion = $request->fecha_cancelacion;
        $abonado->usuario = auth()->user()->name;
      

       
        // Set other attributes as needed...
        $abonado->save();


        $ranchoIds = $request->input('ranchos');

        // Attach registros to the programacion
        $abonado->ranchos()->attach($ranchoIds);

        // Loop through registros and update their estado_proceso
        foreach ($ranchoIds as $ranchoId) {
            $rancho = Rancho::find($ranchoId);
            if ($rancho) {
                $rancho->cancelado = 'si';
                $rancho->save();
            }
        }


        return redirect()->route('abonados.index')->with('crear-abonado-cancelar-tickets', 'Se cancelaron los tickets de comedor exitosamente.');


    }

    /**
     * Display the specified resource.
     */
    public function show(abonado $abonado)
    {


        $ranchos = $abonado->ranchos;
        $sum_cantidad_total = $ranchos->sum('cantidad');
       

        

        // programacion with productos relations
        $abonado = Abonado::with('ranchos')->find($abonado->id);




        

        return view('abonados.show', compact('ranchos', 'abonado', 'sum_cantidad_total'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

     
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
         // programacion with productos relations
        $abonado = Abonado::findOrFail($id);

        $ranchos = $abonado->ranchos;
        $sum_cantidad_total = $ranchos->sum('cantidad');
       

        

       
       
       
        
        return view('abonados.printticket', compact('abonado', 'sum_cantidad_total'));
        
    }
}
