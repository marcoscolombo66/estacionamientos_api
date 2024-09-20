<?php

namespace App\Rest\Controllers;

use App\Rest\Controller as RestController;
use App\Models\Evento;
use App\Rest\Resources\EventoResource;
use Illuminate\Http\Request;

class EventosController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = EventoResource::class;

    public function buscar(Request $request)
    {
        $id_empresa = $request->input('id_empresa', auth()->user()->empresa_id);
        $eventos_filtro_por_fecha = $request->input('eventos_filtro_por_fecha', 'proximos');
        $fecha_desde = $request->input('fecha_desde', now()->format('Y-m-d'));
        $fecha_hasta = $request->input('fecha_hasta', '');

        if ($eventos_filtro_por_fecha == 'proximos') {
            $fecha_desde = $fecha_desde ?: now()->format('Y-m-d');
            $fecha_hasta = $fecha_hasta ?: now()->addMonths(6)->format('Y-m-d');
        } elseif ($eventos_filtro_por_fecha == 'actual_proximos') {
            $hora_actual = now()->format('Y-m-d H:i:s');
            $fecha_actual = now()->format('Y-m-d');

            $subquery = Evento::select('id')
                ->whereNotNull('hora_limite_compra')
                ->where('hora_limite_compra', '>', $hora_actual)
                ->pluck('id')
                ->toArray();

            $fecha_hasta = $fecha_hasta ?: now()->addMonths(6)->format('Y-m-d');
        } elseif ($eventos_filtro_por_fecha == 'anteriores') {
            $fecha_desde = $fecha_desde ?: now()->subMonths(2)->format('Y-m-d');
            $fecha_hasta = $fecha_hasta ?: now()->subDay()->format('Y-m-d');
        }

        $order = $request->input('order', 'fecha_hora ASC');
        $perPage = $request->input('limit', 20);
        $offset = $request->input('offset', 0);

        $query = Evento::with('venue')
            ->where('id_empresa', $id_empresa)
            ->when($eventos_filtro_por_fecha == 'actual_proximos', function ($query) use ($subquery) {
                return $query->whereIn('id', $subquery);
            })
            ->orderByRaw($order);

        $eventos = $query->offset($offset)->limit($perPage)->get();

        $totalRows = Evento::where('id_empresa', $id_empresa)->count();

        return response()->json([
            'data' => $eventos,
            'total' => $totalRows
        ]);
    }
}
