<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LqLiquidacionAdelanto extends Model
{
    use HasFactory;

    protected $table = 'lq_liquidaciones_adelantos';


    protected $fillable = ['liquidacion_id', 'adelanto_id'];
}
