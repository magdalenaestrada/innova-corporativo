<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsCliente extends Model
{
    use HasFactory;

    protected $table = 'ts_clientes';

    protected $fillable = ['documento','nombre'];
}
