<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rancho extends Model
{
    use HasFactory;
    protected $table = 'ranchos';



    public function comida()
    {
        return $this->belongsTo(Comida::class, 'comida_id');
    }


    public function abonados()
    {
        return $this->belongsToMany(Abonado::class, 'abonado_rancho')->withTimestamps();
    }
}
