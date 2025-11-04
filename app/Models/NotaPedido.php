<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaPedido extends Model
{
    protected $table = "nota_pedidos";
    protected $fillable = [
        "codigo",
        "fecha_creacion",
        "dni",
        "conductor",
        "telefono",
        "placa_vehiculo",
        "kilometraje",
        "usuario_id",
        "encargado_id",
        "estado"
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, "usuario_id", "id");
    }
    public function encargado()
    {
        return $this->belongsTo(Empleado::class, "encargado_id", "id");
    }
    public function detalles()
    {
        return $this->hasMany(DetalleNotaPedido::class, 'nota_pedido_id', 'id');
    }
}
