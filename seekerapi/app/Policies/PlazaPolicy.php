<?php

namespace App\Policies;

use App\Models\Plaza;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class PlazaPolicy
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
    /*public function view(Usuario $usuario, Plaza $plaza): bool
    {
        $tiene_estacionamiento = $usuario->estacionamientos->contains($plaza->estacionamiento);
        Log::info('Tiene Estacionamiento: ', $tiene_estacionamiento);
        return $tiene_estacionamiento;
    }*/

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
    public function update(Usuario $usuario, Plaza $plaza): bool
    {
        $tiene_estacionamiento = $usuario->estacionamientos->contains($plaza->estacionamiento);
        Log::info('Tiene Estacionamiento: ', [$tiene_estacionamiento]);
        return $tiene_estacionamiento;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $usuario, Plaza $plaza): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $usuario, Plaza $plaza): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $usuario, Plaza $plaza): bool
    {
        return false;
    }
}
