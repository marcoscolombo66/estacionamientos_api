<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventoEstacionamiento extends Model
{
    use HasFactory;
    protected $table = 'eventos_estacionamientos';

    public function evento() : BelongsTo
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
    public function estacionamiento() : BelongsTo
    {
        return $this->belongsTo(Estacionamiento::class, 'id_estacionamiento');
    }
}
