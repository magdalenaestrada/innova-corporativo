<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarioingreso extends Model
{
    use HasFactory;
    protected $table = 'inventarioingresos';
    protected $fillable = ['descripcion', 'subtotal' ,'total','proveedor', 'documento_proveedor', 'tipomoneda','suma','descuento' , 'cotizacion',];

 

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalleinventarioingresos')->withPivot('cantidad','precio', 'subtotal','id','cantidad_ingresada', 'estado','guiaingresoalmacen')->withTimestamps();
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    

    public function pagosacuenta()
    {
        return $this->hasMany(Inventariopagoacuenta::class);
    }





  
}
