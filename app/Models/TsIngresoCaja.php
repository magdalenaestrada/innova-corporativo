<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsIngresoCaja extends Model
{
    use HasFactory;

    protected $table = 'ts_ingresos_cajas';
    protected $fillable = ['monto','comprobante_correlativo', 'descripcion', 'caja_id', 'motivo_id', 'reposicion_id', 'tipo_comprobante_id', 'beneficiario_id','creador_id', 'fecha_comprobante'];



    
    public function caja()
    {
        return $this->belongsTo(TsCaja::class);
    }


    public function motivo()
    {
        return $this->belongsTo(TsMotivo::class);
    }


    public function tipocomprobante()
    {
        return $this->belongsTo(TipoComprobante::class, 'tipo_comprobante_id');
    }


 

    



}
