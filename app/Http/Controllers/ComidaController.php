<?php

namespace App\Http\Controllers;

use App\Http\Services\ComidaService;
use Illuminate\Http\Request;

class ComidaController extends Controller
{
    public function __construct(private ComidaService $comidaService)
    {
        //
    }
    public function index(Request $request)
    {
        $this->comidaService->index($request);
        return response()->json([
            'success' => true,
            'message' => 'Comidas listadas exitosamente',
            'data' => $this->comidaService->index($request),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->comidaService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->comidaService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->comidaService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            return $this->comidaService->delete($id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la comida: ' . $e->getMessage()], 500);
        }
    }
}
