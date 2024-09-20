<?php

namespace App\Policies;

use App\Models\Estacionamiento;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class EstacionamientoPolicy
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
    public function view(Usuario $usuario, Estacionamiento $estacionamiento): bool
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
    public function update(Usuario $usuario, Estacionamiento $estacionamiento): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $usuario, Estacionamiento $estacionamiento): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $usuario, Estacionamiento $estacionamiento): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $usuario, Estacionamiento $estacionamiento): bool
    {
        return false;
    }
}
