<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'referencia_uno',
        'referencia_dos',
        'referencia_tres'
    ];

    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
}
