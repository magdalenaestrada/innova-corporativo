<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = ['referencia_uno', 'referencia_dos', 'referencia_tres'];

    public function accion()
    {
        return $this->belongsTo(Accion::class, 'accion_id');
    }

    public function motivo()
    {
        return $this->belongsTo(Motivo::class);
    }

    public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function referencia()
    {
        return $this->hasOne(Referencia::class);
    }

    public function programaciones()
    {
        return $this->belongsToMany(Programacion::class, 'programacion_registro');
    }
}
