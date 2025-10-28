<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LqDevolucion extends Model
{
    use HasFactory;
    protected $table = 'lq_devoluciones';

    protected $fillable = ['sociedad_id', 'ingreso_cuenta_id', 'creador_id', 'cliente_id', 'fecha'];



    public function adelantos()
    {
        return $this->belongsToMany(LqAdelanto::class, 'lq_devoluciones_adelantos', 'devolucion_id', 'adelanto_id')->withTimestamps();
    }

    public function ingresocuenta(){
        return $this->belongsTo(TsIngresoCuenta::class, 'ingreso_cuenta_id');
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
