<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    use HasFactory;

    public function registros()
    {
        return $this->belongsToMany(Registro::class, 'programacion_registro');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'programacion_producto')->withPivot('cantidad','id')->withTimestamps();
    }
}
