<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventariosalida extends Model
{
    use HasFactory;
    protected $table = 'inventariosalidas';

    protected $fillable = ['descripcion'];



    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalleinventariosalidas')->withPivot('cantidad','id','cantidad_entregada', 'estado')->withTimestamps();
    }


    public function documento()
    {
        return $this->hasOne(Docinventariosalida::class);
    }
}
