<?php

namespace App\Http\Controllers;

use App\Models\Accion;
use App\Models\Estado;
use App\Models\Motivo;
use App\Models\Referencia;
use App\Models\Registro;
use App\Models\TipoVehiculo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:ver registro', ['only' => ['index']]);
        $this->middleware('permission:crear registro', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar registro', ['only' => ['update', 'edit']]);
        $this->middleware('permission:eliminar registro', ['only' => ['destroy']]);
    }


    public function index()
    {
        $registros = Registro::with(['motivo', 'accion', 'tipoVehiculo', 'estado'])->orderBy('created_at', 'desc')->paginate(20);
        return view('registros.index', compact('registros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $acciones = Accion::all();
        $motivos = Motivo::all();
        $estados = Estado::all();
        $vehiculos = TipoVehiculo::all();
        return view('registros.create', compact('acciones', 'motivos', 'estados', 'vehiculos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'accion_id' => 'required',
                'tipo_vehiculo_id' => 'required',
                'placa' => 'required|string|max:255',
                'motivo' => 'required',
                'documento_cliente' => 'required|string|max:255',
                'datos_cliente' => 'required|string|max:255',
                'documento_conductor' => 'nullable|string|max:255',
                'datos_conductor' => 'nullable|string|max:255',
                'guia_remision' => ['nullable', Rule::unique('registros')],
                'guia_transportista' => ['nullable', Rule::unique('registros')],
                'referencia_uno' => 'nullable|string|max:255',
                'referencia_dos' => 'nullable|string|max:255',
                'referencia_tres' => 'nullable|string|max:255',
                'observacion' => 'nullable|string',
                'estado_id' => 'required',
                'toneladas' => 'nullable'
            ]);

            // Crear un nuevo registro con los datos validados y las relaciones
            $registro = new Registro;
            $registro->accion_id = $request->input('accion_id');
            $registro->tipo_vehiculo_id = $request->input('tipo_vehiculo_id');
            $registro->estado_id = $request->input('estado_id');
            $registro->placa = $request->input('placa');
            $registro->motivo()->associate($request->input('motivo'));
            // Asociar las demás relaciones de la misma manera

            // Llenar los campos restantes  
            $registro->documento_cliente = $request->input('documento_cliente');
            $registro->datos_cliente = $request->input('datos_cliente');
            if ($registro->documento_conductor) {
                $registro->documento_conductor = $request->input('documento_conductor');
            } else {
                $registro->documento_conductor = '';
            }


            if ($registro->documento_conductor) {
                $registro->datos_conductor = $request->input('datos_conductor');
            } else {
                $registro->datos_conductor = '';
            }
            $registro->documento_balanza = $request->input('documento_balanza');
            $registro->datos_balanza = $request->input('datos_balanza');
            $registro->guia_remision = $request->input('guia_remision');
            $registro->guia_transportista = $request->input('guia_transportista');
            $registro->observacion = $request->input('observacion');
            $registro->toneladas = $request->input('toneladas');
            $registro->save();

            $referencia = new Referencia;
            $referencia->referencia_uno = $request->input('referencia_uno');
            $referencia->referencia_dos = $request->input('referencia_dos');
            $referencia->referencia_tres = $request->input('referencia_tres');

            $registro->referencia()->save($referencia);

            // Redireccionar a la página deseada después de guardar el registro
            return redirect()->route('registros.index')->with('success', 'Registro creado correctamente');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                // El código 23000 generalmente indica una violación de clave única
                // Puedes verificar específicamente si es un error de guia_remision o guia_transportista
                if (Str::contains($e->getMessage(), 'guia_remision')) {
                    return redirect()->back()->withInput()->with('error', 'La guía de remisión ya está en uso.');
                } elseif (Str::contains($e->getMessage(), 'guia_transportista')) {
                    return redirect()->back()->withInput()->with('error', 'La guía de transportista ya está en uso.');
                } else {
                    // Otro tipo de error desconocido
                    // Puedes personalizar este mensaje según tus necesidades
                    return redirect()->back()->with('error', 'Ya existe un registro con este valor.');
                }
            } else {
                // Otro tipo de error desconocido
                // Puedes personalizar este mensaje según tus necesidades
                return redirect()->back()->with('error', 'Error desconocido.');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(registro $registro)
    {
        return view('registros.show', compact('registro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Buscar el registro que se desea editar
        $registro = Registro::findOrFail($id);

        // Obtener listas para selectores en el formulario (si es necesario)
        $acciones = Accion::all();
        $motivos = Motivo::all();
        $vehiculos = TipoVehiculo::all();
        $estados = Estado::all();

        // Puedes adaptar esto según tus necesidades y la estructura de tu formulario
        return view('registros.edit', compact('registro', 'acciones', 'motivos', 'vehiculos', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'accion_id' => 'required',
                'tipo_vehiculo_id' => 'required',
                'placa' => 'required|string|max:255',
                'motivo' => 'required',
                'documento_cliente' => 'required|string|max:255',
                'datos_cliente' => 'required|string|max:255',
                'documento_conductor' => 'required|string|max:255',
                'datos_conductor' => 'required|string|max:255',
                'documento_balanza' => 'required|string|max:255',
                'datos_balanza' => 'required|string|max:255',
                'guia_remision' => ['required', Rule::unique('registros')->ignore($id)],
                'guia_transportista' => ['required', Rule::unique('registros')->ignore($id)],
                'referencia_uno' => 'nullable|string|max:255',
                'referencia_dos' => 'nullable|string|max:255',
                'referencia_tres' => 'nullable|string|max:255',
                'observacion' => 'nullable|string',
                'estado_id' => 'required',
                'toneladas' => 'nullable'
            ]);

            // Buscar el registro existente
            $registro = Registro::findOrFail($id);

            // Actualizar los campos del registro
            $registro->accion_id = $request->input('accion_id');
            $registro->tipo_vehiculo_id = $request->input('tipo_vehiculo_id');
            $registro->estado_id = $request->input('estado_id');
            $registro->placa = $request->input('placa');
            $registro->motivo()->associate(Motivo::findOrFail($request->input('motivo')));
            // Asociar las demás relaciones de la misma manera

            // Llenar los campos restantes
            $registro->documento_cliente = $request->input('documento_cliente');
            $registro->datos_cliente = $request->input('datos_cliente');
            $registro->documento_conductor = $request->input('documento_conductor');
            $registro->datos_conductor = $request->input('datos_conductor');
            $registro->documento_balanza = $request->input('documento_balanza');
            $registro->datos_balanza = $request->input('datos_balanza');
            $registro->guia_remision = $request->input('guia_remision');
            $registro->guia_transportista = $request->input('guia_transportista');
            $registro->observacion = $request->input('observacion');
            $registro->toneladas = $request->input('toneladas');
            $registro->save();

            // Buscar la referencia asociada al registro
            $referencia = $registro->referencia;

            // Actualizar los campos de la referencia
            if ($referencia) {
                $referencia->referencia_uno = $request->input('referencia_uno');
                $referencia->referencia_dos = $request->input('referencia_dos');
                $referencia->referencia_tres = $request->input('referencia_tres');
                $referencia->save();
            } else {
                $nuevaReferencia = new Referencia([
                    'referencia_uno' => $request->input('referencia_uno'),
                    'referencia_dos' => $request->input('referencia_dos'),
                    'referencia_tres' => $request->input('referencia_tres'),
                ]);
                $registro->referencia()->save($nuevaReferencia);
            }

            // Redireccionar a la página deseada después de actualizar el registro
            return redirect()->route('registros.index')->with('editar-registro', 'Registro actualizado con éxito.');
        } catch (QueryException $e) {
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
    public function destroy(string $id)
    {
        try {
            // Encuentra el modelo con el ID proporcionado
            $registro = Registro::findOrFail($id);

            // Elimina el registro
            $registro->delete();

            return redirect()->route('registros.index')->with('eliminar-registro', 'Registro eliminado con éxito.');
        } catch (\Exception $e) {
            // Maneja cualquier excepción que pueda ocurrir
            return redirect()->route('registros.index')->with('error', 'Error al eliminar el registro: ' . $e->getMessage());
        }
    }
    public function buscarDocumento(Request $request)
    {
        $documento = $request->input('documento');
        $token = env('APIS_TOKEN');

        $client = new Client([
            'base_uri' => 'https://api.decolecta.com/v1/',
            'verify' => false,
        ]);

        try {
            if (strlen($documento) === 8) {
                // 🔹 DNI (RENIEC)
                $endpoint = 'reniec/dni';
            } elseif (strlen($documento) === 11) {
                // 🔹 RUC (SUNAT)
                $endpoint = 'sunat/ruc/full';
            } else {
                return response()->json(['error' => 'Número de documento no válido.'], 400);
            }

            $response = $client->request('GET', $endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'query' => ['numero' => $documento],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // 🔁 Adaptar el formato para mantener compatibilidad
            if (strlen($documento) === 8) {
                // Formato antiguo Reniec
                $responseData = [
                    'numeroDocumento' => $data['document_number'] ?? $documento,
                    'nombres' => $data['first_name'] ?? '',
                    'apellidoPaterno' => $data['first_last_name'] ?? '',
                    'apellidoMaterno' => $data['second_last_name'] ?? '',
                ];
            } else {
                // Formato antiguo Sunat
                $responseData = [
                    'numeroDocumento' => $data['numero_documento'] ?? $documento,
                    'razonSocial' => $data['razon_social'] ?? '',
                    'direccion' => $data['direccion'] ?? '',
                    'estado' => $data['estado'] ?? '',
                    'condicion' => $data['condicion'] ?? '',
                ];
            }

            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al consultar la API: ' . $e->getMessage(),
            ], 500);
        }
    }
}
