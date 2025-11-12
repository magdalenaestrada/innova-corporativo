<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'empleado_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        //Evento para convertir el nombre a mayúsculas antes de guardar
        static::saving(function($user) {
            $user->name = strtoupper($user->name);
        });
    }

    public function garita() 
    {
        return $this->belongsTo(Garita::class, 'garita_id');
    }

    public function adminlte_desc(){
        return "Miembro Innova";
    }


    public function empleado(){
        return $this->belongsTo(Empleado::class);
    }

}
