<?php

namespace App\Rest\Resources;

use App\Models\Plaza;
use App\Rest\Resource as RestResource;
use Illuminate\Contracts\Database\Query\Builder;
use Lomkit\Rest\Http\Requests\RestRequest;
use Lomkit\Rest\Relations\BelongsTo;

class PlazaResource extends RestResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    public static $model = Plaza::class;

    /**
     * The exposed fields that could be provided
     * @param RestRequest $request
     * @return array
     */
    public function fields(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [
            'id',
            'codigo_unico',
            'id_vehiculo',
            'estado',
            'vendible',
            'codigo_qr',
            'id_estacionamiento'
        ];
    }

    /**
     * The exposed relations that could be provided
     * @param RestRequest $request
     * @return array
     */
    public function relations(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [
            BelongsTo::make('estacionamiento', EstacionamientoResource::class),
            BelongsTo::make('evento', EventoResource::class),
            BelongsTo::make('tipoPlaza', TipoPlazaResource::class),
            BelongsTo::make('vehiculo', VehiculoResource::class),
        ];
    }

    /**
     * The exposed scopes that could be provided
     * @param RestRequest $request
     * @return array
     */
    public function scopes(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [];
    }

    /**
     * The exposed limits that could be provided
     * @param RestRequest $request
     * @return array
     */
    public function limits(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [
            10,
            25,
            50,
            1000,
            10000
        ];
    }

    /**
     * The actions that should be linked
     * @param RestRequest $request
     * @return array
     */
    public function actions(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [];
    }

    /**
     * The instructions that should be linked
     * @param RestRequest $request
     * @return array
     */
    public function instructions(\Lomkit\Rest\Http\Requests\RestRequest $request): array
    {
        return [];
    }

    public function searchQuery(RestRequest $request, Builder $query)
{
    // Obtener los IDs de los estacionamientos del usuario autenticado
    $estacionamientosIds = $request->user()->estacionamientos->pluck('id')->toArray();

    // Modificar la consulta para que solo incluya plazas asociadas a esos estacionamientos
    return $query->whereIn('id_estacionamiento', $estacionamientosIds);
}
}
