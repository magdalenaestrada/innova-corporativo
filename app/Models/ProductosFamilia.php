<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosFamilia extends Model
{
    use HasFactory;
    protected $table = 'productosfamilias';


    protected $fillable = ['nombre', 'descripcion'];


    public function parent()
    {
        return $this->belongsTo(ProductosFamilia::class, 'parent_id');
    }


}
