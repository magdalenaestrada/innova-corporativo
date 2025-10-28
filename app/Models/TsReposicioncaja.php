<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsReposicioncaja extends Model
{
    use HasFactory;

    protected $table = 'ts_reposiciones_cajas';


    protected $fillable = ['monto', 'comprobante_correlativo', 'confirmación', 'descripcion', 'ultimo_balance_caja' , 'cuenta_procedencia_id','caja_id', 'salida_cuenta_id', 'motivo_id', 'tipo_comprobante_id', 'creador_id'];


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


    public function creador()
    {
        return $this->belongsTo(User::class, foreignKey: 'creador_id');
    }

    public function salidascaja()
    {
        return $this->hasMany(TsSalidacaja::class, 'reposicion_id');
    }


    public function salidacuenta()
    {
        return $this->belongsTo(TsSalidaCuenta::class, 'salida_cuenta_id');
    }


}
