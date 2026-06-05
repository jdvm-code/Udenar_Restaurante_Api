<?php

namespace App\Http\Repository;

use App\Http\Services\ReservaService;
use App\Models\Beca;
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

    public function estadoDia($usuarioId, $fecha)
    {
        try {
            // Reservas ACTIVAS (no canceladas) del usuario para esa fecha
            $reservasActivas = Reserva::join('becas', 'reservas.becas_id', '=', 'becas.id')
                ->where('becas.users_id', $usuarioId)
                ->where('reservas.fecha_reserva', $fecha)
                ->where('reservas.estados_reservas_id', '!=', 4) // Excluir canceladas
                ->select('reservas.comidas_id', 'reservas.horarios_id', 'reservas.id as reserva_id')
                ->get();

            // Beca activa
            $tieneBecaActiva = Beca::where('users_id', $usuarioId)
                ->where('estados_becas_id', 2)
                ->exists();

            // Qué comidas ya tiene reservadas (activas)
            $comidasReservadas = $reservasActivas->pluck('comidas_id')->toArray();

            // Total activas
            $totalReservas = $reservasActivas->count();

            // Puede reservar si: tiene beca, < 2 reservas, y no tiene esa comida
            $puedeDesayuno = $tieneBecaActiva && $totalReservas < 2 && !in_array(1, $comidasReservadas);
            $puedeAlmuerzo = $tieneBecaActiva && $totalReservas < 2 && !in_array(2, $comidasReservadas);

            return response()->json([
                'success' => true,
                'message' => 'Estado del día',
                'data' => [
                    'tiene_beca_activa' => $tieneBecaActiva,
                    'total_reservas' => $totalReservas,
                    'comidas_reservadas' => $comidasReservadas,
                    'puede_desayuno' => $puedeDesayuno,
                    'puede_almuerzo' => $puedeAlmuerzo,
                    'reservas' => $reservasActivas->map(function ($r) {
                        return [
                            'id' => $r->reserva_id,
                            'comidas_id' => $r->comidas_id,
                            'horarios_id' => $r->horarios_id,
                        ];
                    }),
                ],
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estado',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function cancelar(Request $request, $id)
    {
        try {
            $userId = $request->users_id;

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no especificado',
                    'error' => 'Se requiere users_id',
                ], 400);
            }

            $reserva = Reserva::find($id);

            if (!$reserva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reserva no encontrada',
                    'error' => 'La reserva no existe',
                ], 404);
            }

            // Verificar que la reserva pertenece al usuario
            $beca = Beca::where('id', $reserva->becas_id)
                ->where('users_id', $userId)
                ->first();

            if (!$beca) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado',
                    'error' => 'No puede cancelar esta reserva',
                ], 403);
            }

            // Solo cancelar si está pendiente (id: 1)
            if ($reserva->estados_reservas_id != 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede cancelar',
                    'error' => 'Solo puede cancelar reservas pendientes',
                ], 400);
            }

            $reserva->update([
                'estados_reservas_id' => 4, // Cancelada
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reserva cancelada exitosamente',
                'data' => $reserva->fresh(),
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

    public function misReservas(Request $request)
    {
        try {
            $userId = $request->users_id;

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no especificado',
                    'error' => 'Se requiere users_id',
                ], 400);
            }

            $reservas = Reserva::join('becas', 'reservas.becas_id', '=', 'becas.id')
                ->where('becas.users_id', $userId)
                ->where('reservas.estados_reservas_id', '!=', 4) // Excluir canceladas
                ->with(['horario', 'comida', 'estadoReserva'])
                ->select('reservas.*')
                ->orderBy('reservas.fecha_reserva', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Reservas del estudiante',
                'data' => $reservas,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener reservas',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function verificarAsistencia(Request $request)
    {
        try {
            $codigo = $request->codigo;

            if (!$codigo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código no proporcionado',
                    'error' => 'Se requiere el código de reserva',
                ], 400);
            }

            // Buscar reserva por código y que esté pendiente
            $reserva = Reserva::where('codigo', $codigo)
                ->where('estados_reservas_id', 1) // Solo pendientes
                ->where('fecha_reserva', now()->toDateString()) // Solo del día actual
                ->first();

            if (!$reserva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reserva no válida',
                    'error' => 'El código no existe, ya fue usado, o es de otra fecha',
                ], 404);
            }

            // Verificar que el horario esté activo (opcional: dentro de rango horario)
            $horario = Horario::find($reserva->horarios_id);
            $ahora = now()->format('H:i:s');

            if ($horario && ($ahora < $horario->hora_inicio || $ahora > $horario->hora_fin)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fuera de horario',
                    'error' => "El horario de esta reserva es {$horario->hora_inicio} - {$horario->hora_fin}",
                ], 400);
            }

            // Marcar como asistió (estado 2)
            // Opción A: Borrar el código (para que no se reutilice)
            $reserva->update([
                'estados_reservas_id' => 2 // Asistió
                //'codigo' => null, // ← Borrar código (opcional)
            ]);

            // Opción B: Mantener código (comentar la línea anterior)
            // $reserva->update(['estados_reservas_id' => 2]);

            // Obtener info del estudiante para mostrar
            $beca = Beca::with('user')->find($reserva->becas_id);

            return response()->json([
                'success' => true,
                'message' => 'Asistencia verificada correctamente',
                'data' => [
                    'reserva_id' => $reserva->id,
                    'estudiante' => $beca?->user?->name ?? 'Desconocido',
                    'comida' => $reserva->comida?->tipo ?? 'N/A',
                    'horario' => $horario ? "{$horario->hora_inicio} - {$horario->hora_fin}" : 'N/A',
                    'fecha' => $reserva->fecha_reserva,
                    'estado' => 'Asistió',
                ],
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar asistencia',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
