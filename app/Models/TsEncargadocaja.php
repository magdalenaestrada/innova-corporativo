<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsEncargadocaja extends Model
{
    use HasFactory;

    protected $table = 'ts_encargados_cajas';

    protected $fillable = [ 'caja_id', 'encargado_id'];
}
