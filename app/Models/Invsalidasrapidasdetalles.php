<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invsalidasrapidasdetalles extends Model
{
    use HasFactory;
    protected $table = 'inv_salidasrapidasdetalles';
    protected $fillable =[ 'inv_salidasrapidas_id','producto_id','cantidad' ];


    public function producto(){
        return $this->belongsTo(Producto::class);
    }


    public function salidarapida() {
        return $this->belongsTo(Invsalidasrapidas::class, 'inv_salidasrapidas_id');
    }


}