<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    use HasFactory;

    public function estacionamientos() : HasMany
    {
        return $this->hasMany(Estacionamiento::class, 'venues_estacionamientos');
    }

    public function eventos() : HasMany
    {
        return $this->hasMany(Evento::class, 'id_venue');
    }
}
