<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsSalidacaja extends Model
{
    use HasFactory;

    protected $table = 'ts_salidas_cajas';

    protected $fillable = ['monto','comprobante_correlativo', 'descripcion', 'caja_id', 'beneficiario_id','motivo_id', 'reposicion_id', 'tipo_comprobante_id', 'creador_id', 'fecha_comprobante', 'empresa_id'];


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


    public function beneficiario(){
        return $this->belongsTo(TsBeneficiario::class, 'beneficiario_id');
    }
 



    public function creador(){
        return $this->belongsTo(User::class, 'creador_id');
    }

    



}
