<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsCuenta extends Model
{
    use HasFactory;

    protected $table = 'ts_cuentas';

    protected $fillable = ['nombre','codigo','tipo_moneda_id', 'banco_id', 'encargado_id' ,'creador_id', 'balance'];


    public function banco()
    {
        return $this->belongsTo(TsBanco::class);
    }


    public function encargado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function tipomoneda()
    {
        return $this->belongsTo(TipoMoneda::class, 'tipo_moneda_id');
    }

    public function cierres_diarios(){
        return $this->hasMany(TsCierreCuentaDiario::class, 'cuenta_id');
    }


    public function ingresos(){
        return $this->hasMany(TsIngresoCuenta::class, 'cuenta_id');
    }

    public function salidas(){
        return $this->hasMany(TsSalidaCuenta::class, 'cuenta_id');
    }


    
    
}
