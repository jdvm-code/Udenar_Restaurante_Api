<?php

namespace App\Http\Repository;

use App\Models\Reserva;
use App\Models\Beca;
use App\Http\Services\ReporteService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteRepository extends BaseRepository implements ReporteService
{

    public function __construct(private Reserva $model)
    {
        parent::__construct($model);
    }
    /**
     * REPORTES 1: Estudiantes que perdieron el beneficio (Inactivos)
     * Filtra los estudiantes cuyo estado de beca cambió a inactivo en un período.
     */
    public function estudiantesInactivos($fechaInicio, $fechaFin)
    {
        // Nota: Ajusta 'Beca' según tu tabla de estudiantes/becas y sus columnas.
        $query = Beca::where('activo', false);

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('updated_at', [$fechaInicio, $fechaFin]);
        }

        return $query->with('usuario')->get();
    }

    /**
     * REPORTE 2: Tráfico del restaurante (Flujo por hora/horario y tipo de comida)
     * Cuenta cuántas reservas fueron exitosamente CONSUMIDAS (ej: estado 2) agrupadas por día, comida y horario.
     */
    public function traficoRestaurante($fechaInicio, $fechaFin)
    {
        return Reserva::select(
            'fecha_reserva',
            'comidas_id',
            'horarios_id',
            DB::raw('COUNT(*) as total_atendidos')
        )
            ->where('estados_reservas_id', 2) // 2 = Consumido / Reclamado
            ->whereBetween('fecha_reserva', [$fechaInicio, $fechaFin])
            ->groupBy('fecha_reserva', 'comidas_id', 'horarios_id')
            ->orderBy('fecha_reserva', 'desc')
            ->get();
    }

    /**
     * REPORTE 3: Estudiantes con determinado número de inasistencias
     * Busca qué estudiantes han acumulado N o más fallas en un rango de fechas.
     */
    public function estudiantesConInasistencias($fechaInicio, $fechaFin, $minInasistencias = 3)
    {
        $hoy = Carbon::now('America/Bogota')->format('Y-m-d');

        return Reserva::select('becas_id', DB::raw('COUNT(*) as total_inasistencias'))
            // Consideramos inasistencia si la fecha ya pasó y nunca se reclamó (sigue en estado 1)
            ->where('estados_reservas_id', 1)
            ->where('fecha_reserva', '<', $hoy)
            ->whereBetween('fecha_reserva', [$fechaInicio, $fechaFin])
            ->groupBy('becas_id')
            ->having('total_inasistencias', '>=', $minInasistencias)
            ->orderBy('total_inasistencias', 'desc')
            ->with('becas') // Carga la relación para saber quién es
            ->get();
    }

    public function obtenerFaltasPorBecado(int $becasId)
    {
        $hoy = \Carbon\Carbon::now('America/Bogota')->format('Y-m-d');

        return Reserva::where('becas_id', $becasId)
            ->where('estados_reservas_id', 1) // Estado activa / no reclamada
            ->where('fecha_reserva', '<', $hoy) // Que la fecha ya haya pasado
            ->count(); // Cuenta el total de registros que cumplen las condiciones
    }   
}
