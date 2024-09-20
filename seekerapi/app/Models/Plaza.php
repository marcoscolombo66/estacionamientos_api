<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Plaza extends Model
{
    use HasFactory;

    protected $table = 'plazas_eventos';
    public $timestamps = false;

    public function evento() : BelongsTo
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
    public function estacionamiento() : BelongsTo
    {
        return $this->belongsTo(Estacionamiento::class, 'id_estacionamiento');
    }
    public function tipoPLaza() : BelongsTo
    {
        return $this->belongsTo(TipoPlaza::class, 'id_tipo_plaza');
    }
    public function vehiculo() : BelongsTo
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo');
    }
}
