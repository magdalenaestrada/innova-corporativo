<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsBanco extends Model
{
    use HasFactory;
    protected $table = 'ts_bancos';

    protected $fillable = ['nombre', 'creador_id'];


}
