<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

interface BecaService
{

    public function index(Request $request);
    public function show(int $id);
    public function store(Request $request);
    public function update(Request $request, int $id);
    public function delete(int $id);

    public function getBecaActivaByUsuario($usuarioId);
    public function solicitar(Request $request);
    public function activar($id);


}

