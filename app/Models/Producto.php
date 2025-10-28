<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = ['nombre_producto', 'descripcion_producto','stock','ultimoprecio', 'unidad_id'];


    public function programaciones()
    {
        return $this->belongsToMany(Programacion::class, 'programacion_producto');
    }


    public function familia()
    {
        return $this->belongsTo(ProductosFamilia::class, 'productosfamilia_id');
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }

    public function salidasrapidasdetails(){
        return $this->hasMany(Invsalidasrapidasdetalles::class);
    }

}
