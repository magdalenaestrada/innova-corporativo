<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\User;
use App\Models\Area;
use App\Models\Posicion;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function __construct()
     {
         $this->middleware('permission:use cuenta');
 
     }
    public function index()
    {
        $empleados = Empleado::orderBy('created_at', 'desc')->paginate(30);
        $areas = Area::orderBy('created_at', 'desc')->paginate(30);
        $posiciones = Posicion::orderBy('created_at', 'desc')->paginate(30);
        return view('empleados.index', compact('empleados', 'areas', 'posiciones'));
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
        try{

            $request->validate([
                'documento' => 'required|max:255|string|unique:empleados,documento',
                'nombre' => 'required|max:255|string|unique:empleados,nombre',
                'direccion' => 'nullable|max:255|string',
                'telefono' => 'nullable|max:255|string',
                'sueldo' => 'nullable|max:255|string',
                'en_actividad' => 'nullable',
                'jefe_id' => 'nullable',
                'area_id' => 'nullable',
                'posicion_id' => 'nullable',


                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|max:20',


            ]);
    
            $empleado = Empleado::create([
                'documento' => $request->documento,
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'sueldo' => $request->sueldo,
                'en_actividad' => $request->en_actividad,
                'jefe_id' => $request->jefe_id,
                'area_id' => $request->area_id,
                'posicion_id' => $request->posicion_id,
                'creador_id' => auth()->id(),
            ]);


            $user = User::create([
                'name' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),

                'empleado_id' =>$empleado->id,

            ]);
        
            return redirect()->route('empleados.index')->with('status', 'Empleado creado con éxito.');
            
        }
        catch(QueryException $e){
                if ($e->getCode() == '23000'){
                    return redirect()->back->withInput()->with('error', 'Ya existe un registro con este valor.');
                }else{
                    return redirect()->back()->with('error', 'Error desconocido');
                }
    
        } catch (\Exception $e)  {
    
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    
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
}
