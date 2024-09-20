<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reserva extends Model
{
    use HasFactory;
    protected $table = 'clientes_reservas';

    public function cliente() : BelongsTo
    {
        return $this->belongsTo(Cliente::class , 'id_cliente');
    }
    public function plaza() : HasOne
    {
        return $this->hasOne(Plaza::class, 'id_plaza');
    }
}
