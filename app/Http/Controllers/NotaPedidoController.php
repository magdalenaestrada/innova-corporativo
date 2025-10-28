<?php

namespace App\Http\Controllers;

use App\Exports\CombustibleExport;
use App\Exports\NotaPedidoFullExport;
use App\Http\Requests\NotaPedido\SubmitNotaPedidoRequest;
use App\Models\DetalleNotaPedido;
use App\Models\Empleado;
use App\Models\NotaPedido;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class NotaPedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver ordenes', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear ordenes', ['only' => ['create', 'store']]);
        $this->middleware('permission:cancelar ordenes', ['only' => ['cancelar', 'updatecancelar']]);
        $this->middleware('permission:recepcionar ordenes', ['only' => ['recepcionar', 'updaterecepcionar']]);
    }

    public function index()
    {
        $notas = NotaPedido::with('encargado')
            ->where('estado', 'A')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('notas.index', compact('notas'));
    }

    public function formulario()
    {
        $productos = Producto::all();
        $encargados = Empleado::all();

        return view('notas.formulario', compact('productos', 'encargados'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('🟢 Datos recibidos en request', $request->all());

            $usuario = Auth::user();

            $insert = [
                "codigo" => $this->generarCodigo(),
                "fecha_creacion" => $request->fecha_creacion,
                "dni" => $request->dni,
                "conductor" => $request->proveedor,
                "telefono" => $request->telefono,
                "placa_vehiculo" => $request->placa_vehiculo,
                "kilometraje" => $request->kilometraje,
                "usuario_id" => $usuario ? $usuario->id : null,
                "encargado_id" => $request->encargado_id,
            ];

            Log::info('🟠 Datos de cabecera', $insert);

            $nota_pedido = DB::transaction(function () use ($insert, $request) {
                $nota_pedido = NotaPedido::create($insert);

                $detalles = json_decode($request->detalles, true);
                Log::info('🟢 Detalles decodificados', $detalles);

                foreach ($detalles as $detalle) {
                    Log::info('🔹 Procesando detalle', $detalle);

                    // Validar datos
                    if (empty($detalle['producto']) || empty($detalle['cantidad'])) {
                        throw new \Exception('Faltan datos de producto o cantidad');
                    }

                    DetalleNotaPedido::create([
                        "nota_pedido_id" => $nota_pedido->id,
                        "cantidad" => $detalle["cantidad"],
                        "producto_id" => $detalle["producto"], // ✅ corregido
                    ]);

                    $producto = Producto::findOrFail($detalle["producto"]);
                    $producto->update([
                        "stock" => $producto->stock - $detalle["cantidad"],
                    ]);
                }

                return $nota_pedido;
            });

            Log::info('✅ Nota de pedido guardada', ['id' => $nota_pedido->id]);

            return redirect()
                ->route('nota-pedido.index')
                ->with('success', 'La nota de pedido se creó correctamente.');
        } catch (\Exception $exception) {
            Log::error('❌ Error al crear nota de pedido', [
                'mensaje' => $exception->getMessage(),
                'linea' => $exception->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error al crear la nota de pedido: ' . $exception->getMessage());
        }
    }
    public function generarCodigo()
    {
        $count = NotaPedido::count() + 1;
        $codigo = str_pad($count, 5, '0', STR_PAD_LEFT);
        return "NPDO-" . $codigo;
    }

    public function datatable()
    {
        $model = NotaPedido::with('encargado')
            ->where('estado', 'A')
            ->orderBy('id', 'desc')
            ->get();

        return DataTables::of($model)
            ->addIndexColumn()
            ->make(true);
    }

    public function show(NotaPedido $nota)
    {
        $nota->load('encargado', 'detalles.producto');
        return view('notas.show', compact('nota'));
    }

    public function edit($id)
    {
        $nota = NotaPedido::with(['encargado', 'detalles'])->findOrFail($id);
        $productos = Producto::all();
        $encargados = Empleado::all();

        return view('notas.edit', compact('nota', 'productos', 'encargados'));
    }

    public function update(Request $request, $id)
    {
        try {
            $nota_pedido = DB::transaction(function () use ($request, $id) {
                $nota = NotaPedido::findOrFail($id);

                $detallesAntiguos = $nota->detalles()->get();
                foreach ($detallesAntiguos as $detalle) {
                    $producto = Producto::findOrFail($detalle->producto_id);
                    $producto->update([
                        'stock' => $producto->stock + $detalle->cantidad,
                    ]);
                }

                $nota->update([
                    "fecha_creacion" => $request->fecha_creacion,
                    "dni" => $request->dni,
                    "conductor" => $request->conductor,
                    "telefono" => $request->telefono,
                    "placa_vehiculo" => Str::upper($request->placa_vehiculo),
                    "kilometraje" => $request->kilometraje,
                    "encargado_id" => $request->encargado_id,
                    "descripcion" => $request->descripcion,
                ]);

                $nota->detalles()->delete();

                $detalles = json_decode($request->detalles, true);

                foreach ($detalles["detalles"] as $detalle) {
                    DetalleNotaPedido::create([
                        "nota_pedido_id" => $nota->id,
                        "cantidad" => $detalle["cantidad"],
                        "producto_id" => $detalle["producto_id"],
                    ]);

                    $producto = Producto::findOrFail($detalle["producto_id"]);
                    $producto->update([
                        "stock" => $producto->stock - $detalle["cantidad"],
                    ]);
                }

                return $nota;
            });
            $user = Auth::user();
            activity()
                ->performedOn($nota_pedido)
                ->causedBy($user)
                ->log('Actualizó una nota de pedido');

            return redirect()
                ->route('nota-pedido.index')
                ->with('success', 'La nota de pedido se actualizó correctamente.');
        } catch (\Exception $exception) {
            Log::error('❌ Error al crear nota de pedido', [
                'mensaje' => $exception->getMessage(),
                'linea' => $exception->getLine(),
                'archivo' => $exception->getFile(),
            ]);

            dd('ERROR CAPTURADO:', $exception->getMessage(), $exception->getLine(), $exception->getFile());
        }
    }

    public function anular($id)
    {
        try {
            $nota = NotaPedido::findOrFail($id);
            $nota->estado = 'I';
            $nota->save();

            return redirect()
                ->route('nota-pedido.index')
                ->with('success', 'La nota ha sido anulada correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('nota-pedido.index')
                ->with('error', 'Ocurrió un error al anular la nota: ' . $e->getMessage());
        }
    }
    public function print($id)
    {
        $nota = NotaPedido::with('detalles.producto')->findOrFail($id);
        return view('notas.ticket', compact('nota'));
    }
    public function search(Request $request)
    {
        $search = $request->get('search');

        $notas = NotaPedido::with('encargado')
            ->when($search, function ($query, $search) {
                $query->where('codigo', 'like', "%{$search}%")
                    ->orWhereHas('encargado', function ($q) use ($search) {
                        $q->where('razon_social', 'like', "%{$search}%")
                            ->orWhere('ruc', 'like', "%{$search}%");
                    });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('notas.partials._rows', compact('notas'));
    }

    public function reportes()
    {
        return view('notas.reportes');
    }

    public function exportCombustible(Request $request)
    {
        $placa = $request->get('placa');
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');

        if (!$desde || !$hasta) {
            return redirect()->back()->with('error', 'Debe seleccionar un rango de fechas.');
        }

        return Excel::download(new CombustibleExport($placa, $desde, $hasta), 'reporte_combustible.xlsx');
    }
}
