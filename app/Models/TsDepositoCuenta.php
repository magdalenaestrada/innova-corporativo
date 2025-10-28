<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsDepositoCuenta extends Model
{
    use HasFactory;
    
    protected $table = 'ts_depositos_cuentas';
    protected $fillable = ['ts_salida_cuenta_id' ,'ts_ingreso_cuenta_id', 'tipo_cambio'];
}
