<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarioprestamosalida extends Model
{
    use HasFactory;
    protected $table ='inventarioprestamosalidas';


    public function productos()
    {
        return $this->belongsToMany(
            Producto::class, 
            'inventarioprestamosalidadetalles', 
            'inventarioprsalida_id', // Custom foreign key name
            'producto_id'           // Default related key name
        )->withPivot('cantidad')->withTimestamps();
    }

}
