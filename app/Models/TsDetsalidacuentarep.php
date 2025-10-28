<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsDetsalidacuentarep extends Model
{
    use HasFactory;
    
    protected $table = 'ts_det_salidacuenta_rep';
    protected $fillable = ['ts_salida_cuenta_id', 'ts_cuenta_id', 'ts_reposicion_caja_id'];
    
}
