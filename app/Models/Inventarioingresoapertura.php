<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarioingresoapertura extends Model
{
    use HasFactory;

    protected $table = 'ingresoinventarioapertura';


    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
