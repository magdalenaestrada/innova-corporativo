<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventariopagoacuenta extends Model
{
    use HasFactory;
    protected $table ='inventariopagosacuenta';
    protected $fillable  =['inventarioingreso_id', 'fecha_pago', 'monto', 'comprobante_correlativo', 'usuario'];
}
