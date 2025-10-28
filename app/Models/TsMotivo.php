<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsMotivo extends Model
{
    use HasFactory;

    protected $table = 'ts_motivos';

    protected $fillable = ['nombre', 'creador_id'];



}
