<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LqSociedadCliente extends Model
{
    use HasFactory;

    protected $table = 'lq_sociedad_cliente';
    protected $fillable = ['cliente_id', 'sociedad_id', 'creador_id'];
}
