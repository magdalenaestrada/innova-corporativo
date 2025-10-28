<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsCierreCuentaDiario extends Model
{
    use HasFactory;


    protected $table = 'ts_cierres_cuentas_diarios';


    public function cuenta(){
        return $this->belongsTo(TsCuenta::class, 'cuenta_id');
    }
}
