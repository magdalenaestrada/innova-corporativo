<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Motivo;
use App\Models\Accion;

class DataController extends Controller
{
    public function query(Request $request)
    {
        $sumTons = null;
        $filteredData = null;
        $motivos = Motivo::whereIn('nombre_motivo', ['MINERALES', 'CONCENTRADO'])->pluck('nombre_motivo', 'id');
        $accions = Accion::pluck('nombre_accion', 'id');

        // If the form is submitted
        if ($request->filled(['documento_cliente', 'accion_id', 'start_date', 'end_date'])) {
            $documentoCliente = $request->input('documento_cliente');
            $accionId = $request->input('accion_id');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $motivoId = $request->input('motivo_id');
            $query = Registro::with(['motivo', 'accion', 'tipoVehiculo', 'estado'])->orderBy('created_at', 'desc');

            if ($documentoCliente) {
                $query->where('documento_cliente', $documentoCliente);
            }

            if ($accionId) {
                $query->where('accion_id', $accionId);
            }

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            if ($motivoId) {
                $query->where('motivo_id', $motivoId);
            }

            $filteredData = $query->paginate(20);
            $sumTons = $filteredData->sum('toneladas');

            return view('registros.query', compact('filteredData', 'sumTons', 'motivos', 'accions'));
        }

        return view('registros.query',  compact('filteredData','sumTons', 'motivos', 'accions'));
    }

}
