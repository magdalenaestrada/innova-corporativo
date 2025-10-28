<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LqSociedad extends Model
{
    use HasFactory;

    protected $table = 'lq_sociedades';
    
    protected $fillable = ['codigo', 'nombre', 'creador_id'];

    public function clientes()
    {
        return $this->belongsToMany(LqCliente::class, 'lq_sociedad_cliente', 'sociedad_id', 'cliente_id')
                    ->withPivot('creador_id', 'id')
                    ->withTimestamps();
    }

    public function adelantos_activos()
    {
        return $this->hasMany(LqAdelanto::class, 'sociedad_id')->where('cerrado', false);
    }


    public function adelantos()
    {
        return $this->hasMany(LqAdelanto::class, 'sociedad_id');
    }


    public function liquidaciones()
    {
        return $this->hasMany(LqLiquidacion::class, 'sociedad_id');
    }




}
