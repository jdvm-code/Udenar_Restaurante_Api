<?php

namespace App\Http\Controllers;

use App\Http\Services\EstadoBecaService;
use Illuminate\Http\Request;

class EstadoBecaController extends Controller
{
    public function __construct(private EstadoBecaService $estadoBecaService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->estadoBecaService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->estadoBecaService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->estadoBecaService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->estadoBecaService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->estadoBecaService->delete($id);
    }
}
