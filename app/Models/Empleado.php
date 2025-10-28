<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleados';

    protected $fillable = ['documento', 'nombre', 'direccion', 'telefono', 'sueldo', 'en_actividad', 'jefe_id', 'area_id', 'posicion_id', 'creador_id'];


    public function area() 
    {
        return $this->belongsTo(Area::class);
    }

    public function jefe() 
    {
        return $this->belongsTo(Empleado::class);
    }


    public function usuario()
    {
        return $this->hasOne(User::class);
    }




}
