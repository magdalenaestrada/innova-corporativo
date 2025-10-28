<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalleinventariosalida extends Model
{
    use HasFactory;
    protected $table = 'detalleinventariosalidas';
    protected $fillable = ['inventariosalida_id', 'producto_id', 'cantidad','estado'];

}
