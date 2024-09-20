<?php

namespace App\Models;

use App\Rest\Resources\EventoEstacionamientoTipoPlazaResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evento extends Model
{
    use HasFactory;

    public function venue() : BelongsTo
    {
        return $this->belongsTo(Venue::class, 'id_venue');
    }
    public function eventoEstacionamientoTipoPlaza() : HasMany
    {
        return $this->hasMany(EventoEstacionamientoTipoPlaza::class, 'id_evento');
    }
}
