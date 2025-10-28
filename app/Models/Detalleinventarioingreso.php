<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalleinventarioingreso extends Model
{
    use HasFactory;
    protected $table = 'detalleinventarioingresos';

    protected $fillable = ['inventarioingreso_id', 'producto_id', 'precio', 'cantidad','subtotal', 'estado'];

    public function inventarioingreso()
    {
        return $this->belongsTo(inventarioingreso::class, 'inventarioingreso_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    
    

   
}
