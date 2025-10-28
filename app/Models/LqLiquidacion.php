<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LqLiquidacion extends Model
{
    use HasFactory;
    protected $table = 'lq_liquidaciones';


    protected $fillable = ['sociedad_id', 'representante_cliente_documento', 'representante_cliente_nombre', 'tipo_cambio', 'salida_cuenta_id', 'creador_id', 'cliente_id', 'fecha', 'total', 'descuento', 'otros_descuentos', 'total_sin_detraccion'];

    public function adelantos()
    {
        return $this->belongsToMany(LqAdelanto::class, 'lq_liquidaciones_adelantos', 'liquidacion_id', 'adelanto_id')->withTimestamps();
    }

    public function salidacuenta(){
        return $this->belongsTo(TsSalidaCuenta::class, 'salida_cuenta_id');
    }

    public function creador(){
        return $this->belongsTo(User::class, 'creador_id');
    }
    public function sociedad(){
        return $this->belongsTo(LqSociedad::class, 'sociedad_id');
    }

    public function cliente(){
        return $this->belongsTo(LqCliente::class, 'cliente_id');
    }


    
    protected $casts = [
        'fecha' => 'datetime',
    ];

  


}
