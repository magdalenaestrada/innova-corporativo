<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garita extends Model
{
    use HasFactory;

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
