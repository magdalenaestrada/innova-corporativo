<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonado extends Model
{
    use HasFactory;
    protected $table = 'abonados';

    public function ranchos()
    {
        return $this->belongsToMany(Rancho::class, 'abonado_rancho')->withTimestamps();
    }
}
