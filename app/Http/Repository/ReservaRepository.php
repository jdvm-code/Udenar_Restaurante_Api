<?php

namespace App\Http\Repository;

use App\Http\Services\ReservaService;
use App\Models\horario;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaRepository extends BaseRepository implements ReservaService
{
    public function __construct(private Reserva $model)
    {
        parent::__construct($model);
    }

    public function confirmar($id)
    {
        try {
            $reserva = Reserva::find($id);

            if (!$reserva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reserva no encontrada',
                    'data' => null,
                    'error' => 'ID inválido',
                ], 404);
            }

            $reserva->estados_reservas_id = 2; // Confirmada
            $reserva->save();

            return response()->json([
                'success' => true,
                'message' => 'Reserva confirmada',
                'data' => $reserva,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al confirmar',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function cancelar($id)
    {
        try {
            $reserva = Reserva::find($id);

            if (!$reserva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reserva no encontrada',
                    'data' => null,
                    'error' => 'ID inválido',
                ], 404);
            }

            $reserva->estados_reservas_id = 3; // Cancelada
            $reserva->save();

            return response()->json([
                'success' => true,
                'message' => 'Reserva cancelada',
                'data' => $reserva,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cancelar',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getByUsuarioYFecha($usuarioId, $fecha)
    {
        try {
            $reservas = Reserva::join('becas', 'reservas.becas_id', '=', 'becas.id')
                ->where('becas.users_id', $usuarioId)
                ->where('reservas.fecha_reserva', $fecha)
                ->select('reservas.*')
                ->get();

            if ($reservas->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay reservas para esta fecha',
                    'data' => null,
                    'error' => 'No se encontraron reservas',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Reservas encontradas',
                'data' => $reservas,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar reservas',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function marcarAsistencia(Request $request)
    {
        try {
            $codigo = $request->input('codigo');

            $reserva = Reserva::where('codigo', $codigo)->first();

            if (!$reserva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código no encontrado',
                    'data' => null,
                    'error' => 'No existe reserva con este código',
                ], 404);
            }

            // Verificar si ya está en estado "Asistió" (2)
            if ($reserva->estados_reservas_id == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya registró asistencia',
                    'data' => null,
                    'error' => 'Esta reserva ya está marcada como Asistió',
                ], 400);
            }

            // Cambiar estado a "Asistió" (2)
            $reserva->estados_reservas_id = 2;
            $reserva->save();

            return response()->json([
                'success' => true,
                'message' => 'Asistencia registrada',
                'data' => $reserva,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al marcar asistencia',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
