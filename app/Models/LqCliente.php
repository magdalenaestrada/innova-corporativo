<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LqCliente extends Model
{
    use HasFactory;

    protected $table = 'lq_clientes';
    protected $fillable = ['documento', 'nombre', 'creador_id'];
}
