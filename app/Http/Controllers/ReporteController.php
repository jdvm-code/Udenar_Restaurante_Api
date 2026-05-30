<?php
namespace App\Http\Controllers;

use App\Http\Services\ReporteService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function __construct(private ReporteService $reporteService) {
        
    }

    // Helper para procesar las fechas de los Query Params
    private function parsearFechas(Request $request) {
        $fechaInicio = $request->query('fecha_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $fechaFin = $request->query('fecha_fin', Carbon::now()->endOfMonth()->format('Y-m-d'));
        return [$fechaInicio, $fechaFin];
    }

    public function estudiantesInactivos(Request $request) {
        [$inicio, $fin] = $this->parsearFechas($request);
        $data = $this->reporteService->estudiantesInactivos($inicio, $fin);
        return response()->json(['status' => 'success', 'periodo' => ["desde" => $inicio, "hasta" => $fin], 'data' => $data]);
    }

    public function traficoRestaurante(Request $request) {
        [$inicio, $fin] = $this->parsearFechas($request);
        $data = $this->reporteService->traficoRestaurante($inicio, $fin);
        return response()->json(['status' => 'success', 'periodo' => ["desde" => $inicio, "hasta" => $fin], 'data' => $data]);
    }

    public function estudiantesConInasistencias(Request $request) {
        [$inicio, $fin] = $this->parsearFechas($request);
        $minimas = $request->query('minimas', 3); // Si no mandan el número, busca de 3 inasistencias en adelante
        
        $data = $this->reporteService->estudiantesConInasistencias($inicio, $fin, $minimas);
        return response()->json(['status' => 'success', 'condicion' => ">= $minimas inasistencias", 'data' => $data]);
    }
}
