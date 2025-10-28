<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleNotaPedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "detalle_nota_pedidos";
    protected $fillable = [
        'nota_pedido_id',
        'cantidad',
        'producto_id',
    ];


    public function nota_pedido()
    {
        return $this->belongsTo(NotaPedido::class, "nota_pedido_id", "id");
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, "producto_id", "id");
    }
}
