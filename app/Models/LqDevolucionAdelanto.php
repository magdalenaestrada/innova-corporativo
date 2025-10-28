<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LqDevolucionAdelanto extends Model
{
    use HasFactory;

    protected $table = 'lq_devoluciones_adelantos';


    protected $fillable = ['devolucion_id', 'adelanto_id'];
}
