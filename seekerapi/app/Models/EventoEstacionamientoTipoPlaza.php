<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventoEstacionamientoTipoPlaza extends Model
{
    use HasFactory;
    protected $table = 'eventos_estacionamientos_tipos_plaza';

    public function evento() : BelongsTo
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
    public function eventoEstacionamiento() : BelongsTo
    {
        return $this->belongsTo(EventoEstacionamiento::class, 'id_evento_estacionamiento');
    }
    public function tipoPlaza() : BelongsTo
    {
        return $this->belongsTo(TipoPlaza::class, 'id_tipo_plaza');
    }
}
