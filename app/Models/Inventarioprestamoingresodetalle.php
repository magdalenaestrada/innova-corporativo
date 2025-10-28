<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarioprestamoingresodetalle extends Model
{
    use HasFactory;
    protected $table ='inv_prestamosingresodetalles';
    protected $fillable = ['inventariopringreso_id', 'producto_id', 'cantidad', 'usuario_devol_confirm', 'precio_ingreso'];
}
