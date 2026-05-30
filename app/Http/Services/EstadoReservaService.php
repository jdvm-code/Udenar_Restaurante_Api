<?php
namespace App\Http\Services;

use Illuminate\Http\Request;

interface EstadoReservaService
{
    public function index(Request $request);
    public function show(int $id);
    public function store(Request $request);
    public function update(Request $request, int $id);
    public function delete(int $id);
}