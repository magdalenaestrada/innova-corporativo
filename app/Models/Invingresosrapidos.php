<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invingresosrapidos extends Model
{
    use HasFactory;
    protected $table = 'inv_ingresosrapidos';

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function productos()
    {
        return $this->belongsToMany(
            Producto::class, 'inv_ingresosrapidosdetalles',
            'inv_ingresosrapidos_id', // Custom foreign key name
            'producto_id',          // Default related key name
        )->withPivot('cantidad','id','cantidad_recepcionada', 'precio', 'subtotal', 'created_at')->withTimestamps();
    }


}
