<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invsalidasrapidas extends Model
{
    use HasFactory;
    protected $table = 'inv_salidasrapidas';

    public function productos()
    {
        return $this->belongsToMany(
            Producto::class, 
            'inv_salidasrapidasdetalles', 
            'inv_salidasrapidas_id', // Custom foreign key name
            'producto_id'           // Default related key name
        )->withPivot('cantidad')->withTimestamps();
    }
}
