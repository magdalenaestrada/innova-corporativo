<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsIngresoCuenta extends Model
{
    use HasFactory;
    protected $table = 'ts_ingresos_cuentas';

    protected $fillable = ['monto', 'comprobante_correlativo', 'descripcion', 'cuenta_id', 'motivo_id',  'tipo_comprobante_id', 'creador_id', 'fecha'];


    public function cuenta() 
    {
        return $this->belongsTo(TsCuenta::class);
    }

    public function motivo() 
    {
        return $this->belongsTo(TsMotivo::class);
    }


    public function tipocomprobante() 
    {
        return $this->belongsTo(TipoComprobante::class, 'tipo_comprobante_id');
    }



    public function creador() 
    {
        return $this->belongsTo(User::class, foreignKey: 'creador_id');
    }



    public function cliente(){
        return $this->belongsTo(TsCliente::class, 'cliente_id');
    }




    protected $casts = [
        'fecha' => 'datetime',
    ];




}
