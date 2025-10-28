<?php

namespace App\Http\Controllers;

use App\Models\TipoVehiculo;
use Illuminate\Http\Request;

class TipoVehiculoController extends Controller
{

    public function __construct()
    { 
        $this->middleware('permission:administrar externos');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehiculos = TipoVehiculo::paginate(10);
        return view('vehiculos.index', compact('vehiculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehiculos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validamos los datos del formulario
            $request->validate([
                'nombre_vehiculo' => 'required|unique:tipos_vehiculos,nombre_vehiculo',
                'descripcion_vehiculo' => 'nullable'
            ]);
    
            // Creamos un nuevo tipo de vehículo
            $tipoVehiculo = new TipoVehiculo;
            $tipoVehiculo->nombre_vehiculo = $request->input('nombre_vehiculo');
            $tipoVehiculo->descripcion_vehiculo = $request->input('descripcion_vehiculo');
    
            // Guardamos el tipo de vehículo en la base de datos
            $tipoVehiculo->save();
    
            // Mostramos la alerta de éxito
            return redirect()->route('vehiculos.index')->with('crear-vehiculo', 'Tipo de vehículo creado con éxito.');
    
        } catch (QueryException $e) {
            // Manejamos la excepción
    
            if ($e->getCode() == '23000') {
                // El código 23000 generalmente indica una violación de clave única
                // Mostramos la alerta de error
                return redirect()->back()->withInput()->with('error', 'Ya existe un registro con este valor.');
            } else {
                // Otro tipo de error desconocido
                // Mostramos la alerta de error
                return redirect()->back()->with('error', 'Error desconocido.');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoVehiculo $vehiculo)
    {
        return view('vehiculos.show', compact('vehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoVehiculo $vehiculo)
    {
        return view('vehiculos.edit', compact('vehiculo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoVehiculo $vehiculo)
    {
        try {
            // Validamos los datos del formulario
            $request->validate([
                'nombre_vehiculo' => 'required|unique:tipos_vehiculos,nombre_vehiculo,' . $vehiculo->id,
                'descripcion_vehiculo' => 'nullable'
            ]);
    
            // Obtenemos el tipo de vehículo que se va a actualizar (ya se pasa como parámetro)
            // No es necesario buscarlo nuevamente
            $tipoVehiculo = $vehiculo;
    
            // Actualizamos los campos según la solicitud
            $tipoVehiculo->nombre_vehiculo = $request->input('nombre_vehiculo');
            $tipoVehiculo->descripcion_vehiculo = $request->input('descripcion_vehiculo');
    
            // Guardamos los cambios en la base de datos
            $tipoVehiculo->save();
    
            // Mostramos la alerta de éxito
            return redirect()->route('vehiculos.index')->with('editar-vehiculo', 'Tipo de vehículo actualizado con éxito.');
    
        } catch (QueryException $e) {
            // Manejamos la excepción
    
            if ($e->getCode() == '23000') {
                // El código 23000 generalmente indica una violación de clave única
                // Mostramos la alerta de error
                return redirect()->back()->withInput()->with('error', 'Ya existe un registro con este valor.');
            } else {
                // Otro tipo de error desconocido
                // Mostramos la alerta de error
                return redirect()->back()->with('error', 'Error desconocido.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoVehiculo $vehiculo)
    {
        try {
            // Eliminamos el tipo de vehículo
            $vehiculo->delete();
    
            // Mostramos la alerta de éxito
            return redirect()->route('vehiculos.index')->with('eliminar-vehiculo', 'Tipo de vehículo eliminado con éxito.');
        } catch (QueryException $e) {
            // Manejamos la excepción
    
            // Mostramos la alerta de error
            return redirect()->back()->with('error', 'Error al eliminar el tipo de vehículo.');
        }
    }
}
