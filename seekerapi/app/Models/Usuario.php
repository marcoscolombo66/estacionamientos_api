<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;
    
    protected $table = "com_usuarios";

    public function estacionamientos() : BelongsToMany
    {
        return $this->belongsToMany(Estacionamiento::class, 'com_usuarios_estacionamientos', 'id_usuario', 'id_estacionamiento');
    }
}
