<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarioprestamosalidadetalle extends Model
{
    use HasFactory;
    protected $table ='inventarioprestamosalidadetalles';
    protected $fillable = ['inventarioprsalida_id', 'producto_id', 'cantidad', 'usuario_devol_confirm', 'precio_salida'];
}
