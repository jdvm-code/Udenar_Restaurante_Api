<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\AsistenciaService;
use App\Http\Services\ReservaService;
use App\Models\Beca;
use App\Models\Horario;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function __construct(private ReservaService $reservaService)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Reserva::with(['beca.usuario', 'horario', 'comida', 'estadoReserva']);

            // Filtro por fecha
            if ($request->has('fecha')) {
                $query->where('fecha_reserva', $request->fecha);
            }

            // Filtro por estado
            if ($request->has('estado')) {
                $query->where('estados_reservas_id', $request->estado);
            }

            // Filtro por comida
            if ($request->has('comida')) {
                $query->where('comidas_id', $request->comida);
            }

            // Filtro por usuario
            if ($request->has('usuario')) {
                $query->whereHas('beca', function ($q) use ($request) {
                    $q->where('users_id', $request->usuario);
                });
            }

            $reservas = $query->orderBy('fecha_reserva', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Reservas obtenidas',
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
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // 1. BUSCAR BECA ACTIVA
            $beca = Beca::where('users_id', $request->users_id)
                ->where('estados_becas_id', 2)
                ->first();

            if (!$beca) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene beca activa',
                    'data' => null,
                    'error' => 'El usuario no tiene una beca activa para reservar',
                ], 400);
            }

            $becaId = $beca->id;

            // 2. LÍMITE 2 RESERVAS ACTIVAS
            $reservasActivas = Reserva::join('becas', 'reservas.becas_id', '=', 'becas.id')
                ->where('becas.users_id', $request->users_id)
                ->where('reservas.fecha_reserva', $request->fecha_reserva)
                ->where('reservas.estados_reservas_id', '!=', 4)
                ->count();

            if ($reservasActivas >= 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Límite de reservas alcanzado',
                    'data' => null,
                    'error' => 'Solo puede tener 2 reservas activas por día. Cancele una existente si desea cambiar.',
                ], 400);
            }

            // 3. COMIDA NO REPETIDA (activas)
            $comidaActiva = Reserva::join('becas', 'reservas.becas_id', '=', 'becas.id')
                ->where('becas.users_id', $request->users_id)
                ->where('reservas.fecha_reserva', $request->fecha_reserva)
                ->where('reservas.comidas_id', $request->comidas_id)
                ->where('reservas.estados_reservas_id', '!=', 4)
                ->first();

            if ($comidaActiva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya tiene una reserva para este tipo de comida',
                    'data' => null,
                    'error' => 'Solo puede reservar una vez por desayuno y una por almuerzo',
                ], 400);
            }

            // 4. CUPO HORARIO
            $reservasHorario = Reserva::where('horarios_id', $request->horarios_id)
                ->where('fecha_reserva', $request->fecha_reserva)
                ->where('estados_reservas_id', '!=', 4)
                ->count();

            $horario = Horario::find($request->horarios_id);

            if (!$horario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Horario no encontrado',
                    'data' => null,
                    'error' => 'El horario seleccionado no existe',
                ], 400);
            }

            if ($reservasHorario >= $horario->cupo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cupo agotado',
                    'data' => null,
                    'error' => 'No hay cupos disponibles para este horario',
                ], 400);
            }

            // 5. REACTIVAR O CREAR
            $reservaCancelada = Reserva::where('becas_id', $becaId)
                ->where('fecha_reserva', $request->fecha_reserva)
                ->where('comidas_id', $request->comidas_id)
                ->where('estados_reservas_id', 4)
                ->first();

            if ($reservaCancelada) {
                // REACTIVAR: cambia horario, estado, fecha_registro. Código se mantiene.
                $reservaCancelada->update([
                    'horarios_id' => $request->horarios_id,
                    'estados_reservas_id' => 1,
                    'fecha_registro' => $request->fecha_registro,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Reserva reactivada exitosamente',
                    'data' => $reservaCancelada->fresh(),
                    'error' => null,
                ], 200);
            }

            // CREAR NUEVA
            $codigo = 'RES-' . strtoupper(uniqid());

            $reserva = Reserva::create([
                'becas_id' => $becaId,
                'horarios_id' => $request->horarios_id,
                'comidas_id' => $request->comidas_id,
                'estados_reservas_id' => 1,
                'fecha_registro' => $request->fecha_registro,
                'fecha_reserva' => $request->fecha_reserva,
                'codigo' => $codigo,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reserva creada exitosamente',
                'data' => $reserva,
                'error' => null,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la reserva',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $reserva = Reserva::with(['beca.usuario', 'horario', 'comida', 'estadoReserva'])
                ->find($id);

            if (!$reserva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reserva no encontrada',
                    'data' => null,
                    'error' => 'ID inválido',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Reserva encontrada',
                'data' => $reserva,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar reserva',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->reservaService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->reservaService->delete($id);
    }

    public function getByUsuarioYFecha($usuarioId, $fecha)
    {
        return $this->reservaService->getByUsuarioYFecha($usuarioId, $fecha);
    }

    // Admin actions
    public function confirmar($id)
    {
        return $this->reservaService->confirmar($id);
    }

    public function cancelar(Request $request, $id)
    {
        return $this->reservaService->cancelar($request, $id);
    }

    public function marcarAsistencia(Request $request)
    {
        return $this->reservaService->marcarAsistencia($request);
    }

    public function estadoDia($usuarioId, $fecha)
    {
        return $this->reservaService->estadoDia($usuarioId, $fecha);
    }

    public function misReservas(Request $request)
    {
        return $this->reservaService->misReservas($request);
    }

    public function verificarAsistencia(Request $request)
    {
        return $this->reservaService->verificarAsistencia($request);
    }

}
