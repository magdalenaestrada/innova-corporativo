<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsSalidaCuenta extends Model
{
    use HasFactory;

   protected $table = 'ts_salidas_cuentas';

   protected $fillable = ['monto', 'comprobante_correlativo', 'descripcion','cuenta_id', 'motivo_id', 'tipo_comprobante_id', 'creador_id', 'fecha', 'nro_operacion'];

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


    public function beneficiario(){
        return $this->belongsTo(TsBeneficiario::class, 'beneficiario_id');
    }

    public function creador(){
        return $this->belongsTo(User::class, 'creador_id');
    }



    public function reposicioncaja()
    {
        return $this->hasOne(TsReposicioncaja::class, 'salida_cuenta_id');
    }


    public function ingreso()
    {
        return $this->belongsToMany(
            TsIngresoCuenta::class,  // The related model
            'ts_depositos_cuentas',  // The pivot table
            'ts_salida_cuenta_id',   // Foreign key for the current model (TsSalidaCuenta)
            'ts_ingreso_cuentA_id'   // Foreign key for the related model (TsIngresoCuenta)
        )->withPivot('tipo_cambio')  // Adding the extra pivot column
        ->withTimestamps();        // If the pivot table has timestamps
    }




    public function adelanto()
    {
        return $this->hasOne(LqAdelanto::class, 'salida_cuenta_id');
    }

    public function liquidacion()
    {
        return $this->hasOne(LqLiquidacion::class, 'salida_cuenta_id');
    }




    protected $casts = [
        'fecha' => 'datetime',
    ];



}
