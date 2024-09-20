<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class ClientePolicy
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
    public function view(Usuario $usuario, Cliente $cliente): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $usuario): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $usuario, Cliente $cliente): bool
    {
        return false;
    }
}
