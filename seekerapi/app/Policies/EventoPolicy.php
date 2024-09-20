<?php

namespace App\Policies;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class EventoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $usuario): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $usuario, Evento $evento): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $usuario): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $usuario, Evento $evento): bool
    {
        return true;
    }
}
