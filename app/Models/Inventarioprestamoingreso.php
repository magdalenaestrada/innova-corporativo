<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarioprestamoingreso extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table ='inventarioprestamoingresos';


    public function productos()
    {
        return $this->belongsToMany(
            Producto::class, 
            'inv_prestamosingresodetalles', 
            'inventariopringreso_id', // Custom foreign key name
            'producto_id'           // Default related key name
        )->withPivot('cantidad')->withTimestamps();
    }
}
