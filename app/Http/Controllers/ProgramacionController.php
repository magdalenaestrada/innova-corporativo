<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programacion;
use App\Models\Registro;
use App\Models\Producto;
use App\Models\ProgramacionProducto;

class ProgramacionController extends Controller
{

    public function __construct()
    { 
        $this->middleware('permission:usar programaciones');
    }
 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programaciones = Programacion::orderBy('created_at', 'desc')->paginate(20);
        return view('programacion.index', compact('programaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        #retrieve documentos_clientes after grouping registros
        $documentos_clientes = Registro::leftJoin('programacion_registro', 'registros.id', '=', 'programacion_registro.registro_id')
            ->whereNull('programacion_registro.id')
            ->distinct('documento_cliente')
            ->pluck('documento_cliente')
            ->toArray();

        # Filtro por los registros que ya existen (con estado pendiente)
        $documentos_clientes = array_filter($documentos_clientes, function ($documento_cliente) {
            $registros = Registro::where('documento_cliente', $documento_cliente)->get();
            foreach ($registros as $registro) {
                if (($registro->estado_proceso != 'pendiente' and $registro->estado_proceso != 'ejecutado') and ($registro->motivo->nombre_motivo === 'MINERALES' or $registro->motivo->nombre_motivo === 'CONCENTRADO') and ($registro->accion->nombre_accion === 'INGRESO')) {
                    return true;
                }
            }
            return false;
        });

        $registros = Registro::whereHas('motivo', function ($query) {
            $query->whereIn('nombre_motivo', ['MINERALES', 'CONCENTRADO']);
        })
            ->whereHas('accion', function ($query) {
                $query->where('nombre_accion', 'INGRESO');
            })
            ->where(function ($query) {
                $query->where('estado_proceso', '!=', 'pendiente')
                    ->where('estado_proceso', '!=', 'ejecutado')
                    ->orWhereNull('estado_proceso');
            })
            ->get();

        return view('programacion.create', compact('documentos_clientes', 'registros'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'documentos_clientes' => 'required|array',
            'programacion_inicio' => 'required',
            'programacion_fin' => 'required',
            'ejecucion_inicio' => 'nullable',
            'ejecucion_finalizada' => 'nullable',
        ]);

       
        // Create a new Programacion instance
        $programacion = new Programacion();
        // Attach existing Registro records to the Programacion
        $programacion->programacion_inicio = $request->programacion_inicio;
        $programacion->programacion_fin = $request->programacion_fin;
        $programacion->ejecucion_inicio = $request->ejecucion_inicio;
        $programacion->ejecucion_finalizada = $request->ejecucion_finalizada;
        // Set other attributes as needed...
        $programacion->save();


        $registroIds = $request->input('registros');

        // Attach registros to the programacion
        $programacion->registros()->attach($registroIds);

        // Loop through registros and update their estado_proceso
        foreach ($registroIds as $registroId) {
            $registro = Registro::find($registroId);
            if ($registro) {
                $registro->estado_proceso = 'pendiente';
                $registro->save();
            }
        }


        return redirect()->route('programacion.index')->with('success', 'Programacion created and related to existing Registros successfully');


    }

    /**
     * Display the specified resource.
     */
    public function show(programacion $programacion)
    {


        $registros = $programacion->registros;
        $registros_ejecutados = $programacion->registros()->wherePivot('estado', 'ejecutado')->get();
        $sum_of_tons_programado_total = $registros->sum('toneladas');
        $sum_of_tons_ejecutado_total = $registros_ejecutados->sum('toneladas');

        $tons_restantes = $sum_of_tons_programado_total - $sum_of_tons_ejecutado_total;

        // programacion with productos relations
        $programacion = Programacion::with('productos')->find($programacion->id);




        

        return view('programacion.show', compact('programacion', 'registros', 'registros_ejecutados', 'sum_of_tons_programado_total', 'sum_of_tons_ejecutado_total', 'tons_restantes', 'programacion'));
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
        try {
            // Encuentra el modelo con el ID proporcionado
            $programacion = Programacion::findOrFail($id);

            // free the registros up
            $registros = $programacion->registros;
            foreach ($registros as $registro) {
                $registro->estado_proceso = '';
                $registro->save();
            }

            // Elimina el registro
            $programacion->delete();



            return redirect()->route('programacion.index')->with('eliminar-programacion', 'Programacion eliminada con éxito.');
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir
            return redirect()->route('programacion.index')->with('error', 'Error al eliminar la programacion: ' . $e->getMessage());
        }
    }

    public function start(string $id)
    {
        $programacion = Programacion::findOrFail($id);
        return view('programacion.start', compact('programacion'));

    }

    public function updatestart(Request $request, string $id)
    {
        try {
            $request->validate([
                'ejecucion_inicio' => 'required'
            ]);

            // Buscar el registro existente
            $programacion = Programacion::findOrFail($id);

            // Actualizar los campos del registro
            $programacion->ejecucion_inicio = $request->input('ejecucion_inicio');

            $programacion->save();



            // Redireccionar a la página deseada después de actualizar el registro
            return redirect()->route('programacion.index')->with('editar-programacion', 'Programacion actualizado con éxito.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                // El código 23000 generalmente indica una violación de clave única
                // Mostramos la alerta de error
                return redirect()->back()->withInput()->with('error', 'Ya existe una programación con este valor.');
            } else {
                // Otro tipo de error desconocido
                // Mostramos la alerta de error
                return redirect()->back()->with('error', 'Error desconocido.');
            }
        }

    }




    public function finalizar(string $id)
    {
        $programacion = Programacion::findOrFail($id);


        $documentos_clientes = Registro::whereHas('programaciones', function ($query) use ($programacion) {
            $query->where('programacion_registro.programacion_id', $programacion->id);
        })
            ->distinct('documento_cliente')
            ->pluck('documento_cliente')
            ->toArray();

    
    
        $registros = $programacion->registros;

        $sum_of_tons_programado_total = $registros->sum('toneladas');

        

        return view('programacion.finalizar', compact('programacion', 'documentos_clientes', 'registros' ,'sum_of_tons_programado_total'));

    }



    public function updatefinalizar(Request $request, string $id)
    {


        $request->validate([
            'documentos_clientes' => 'required|array',
            'ejecucion_finalizada' => 'required',
            'observacion' => 'nullable'
        ]);


        $programacion = Programacion::findOrFail($id);
        $programacion->ejecucion_finalizada = $request->input('ejecucion_finalizada');
        $programacion->observacion = $request->input('observacion');
        $programacion->estado = 'finalizada';

        $programacion->save();

        $registros_no_ejecutados = $programacion->registros;
        foreach ($registros_no_ejecutados as $registro) {
            $registro->estado_proceso = 'no_ejecutado';
            $registro->save();
            $registro->programaciones()->updateExistingPivot($programacion->id, ['estado' => 'no_ejecutado']);
        }

        $registros_ejecutadosIds =  $request->input('registros');
        // Attach registros to the programacion

        foreach ($registros_ejecutadosIds as $registroId) {
            $registro = Registro::find($registroId);

            if ($registro) {
                $registro->estado_proceso = 'ejecutado';
                $registro->save();
                $registro->programaciones()->updateExistingPivot($programacion->id, ['estado' => 'ejecutado']);

            }
        }

        return redirect()->route('programacion.index')->with('finalizar-programacion', 'Programacion finalizada con éxito.');

    }


    public function createrequerimiento(Request $request, $id)
    {
        $productos = Producto::get();
        $programacion = Programacion::findOrFail($id);
        return view('programacion.create-requerimiento', compact('productos','programacion'));
        
    }

    public function storerequerimiento(Request $request, $id)
    {

        $request->validate([
            'producto_id' => 'required',
            'cantidad' => 'required'
        ]);

        $programacion = Programacion::findOrFail($id);

        
        $productoId = $request->producto_id;

        $producto = Producto::findOrFail($productoId);
        $producto->stock = $producto->stock - $request->cantidad;
        $producto->save();


        // Attach the producto to the programacion
        $programacion->productos()->attach($productoId, ['cantidad' => $request->cantidad]);
        return redirect()->route('programacion.show', $id)->with('createrequerimiento', 'Requerimiento añadido con éxito.');
    
    }


    public function destroyrequerimiento(string $programacionId, string $productoId, string $pivotId )
    {
        $programacion = Programacion::findOrFail($programacionId);
        $pivotInstance = $programacion->productos()->wherePivot('id', $pivotId)->first();

        if ($pivotInstance) {
            $programacion->productos()->wherePivot('id', $pivotId)->detach();

        }

        return redirect()->route('programacion.show', $programacionId)->with('eliminarequerimiento', 'Requerimiento eliminado con éxito.');



    }



    

}
