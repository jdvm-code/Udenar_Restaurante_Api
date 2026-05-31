<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\HorarioService;

class HorarioController extends Controller
{
    public function __construct(private HorarioService $horarioService)
    {
        //
     }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->horarioService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
                $horario = $this->horarioService->store($request);
                return response()->json([
                    'success' => true,
                    'message' => 'Horario creado con éxito',
                    'horario' => $horario
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el horario',
                    'error' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->horarioService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->horarioService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        return $this->horarioService->delete($id);
    }
}
