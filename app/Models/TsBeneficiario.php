<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsBeneficiario extends Model
{
    use HasFactory;

    protected $table = 'ts_beneficiarios';

    protected $fillable = ['documento', 'nombre'];
}
