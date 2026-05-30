<?php
namespace App\Http\Services;
use Illuminate\Http\Request;

interface ReporteService {

    public function estudiantesInactivos(string $fechaInicio, string $fechaFin);
    public function traficoRestaurante(string $fechaInicio, string $fechaFin);
    public function estudiantesConInasistencias(string $fechaInicio, string $fechaFin, int $minimas);
    public function obtenerFaltasPorBecado(int $becasId);

}