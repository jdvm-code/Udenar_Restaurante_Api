<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

interface ReservaService
{

    public function index(Request $request);
    public function show(int $id);
    public function store(Request $request);
    public function update(Request $request, int $id);
    public function delete(int $id);

    public function getByUsuarioYFecha($usuarioId, $fecha);
    // Admin
    public function confirmar($id);
    public function cancelar($id);

    public function marcarAsistencia(Request $request);
    public function estadoDia($usuarioId, $fecha);
}
