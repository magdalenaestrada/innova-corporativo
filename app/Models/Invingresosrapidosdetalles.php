<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invingresosrapidosdetalles extends Model
{
    use HasFactory;
    protected $table = 'inv_ingresosrapidosdetalles';
    protected $fillable = ['inv_ingresosrapidos_id','producto_id','precio','cantidad','cantidad_recepcionada','subtotal'];


    




}
