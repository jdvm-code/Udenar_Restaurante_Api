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
     return $this->comidaService->index($request);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
                $comida = $this->comidaService->store($request);
                return response()->json([
                    'success' => true,
                    'message' => 'Comida creada con éxito',
                    'comida' => $comida
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la comida',
                    'error' => $e->getMessage()
                ], 500);
        }

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
        return $this->comidaService->delete($id);
    }
}
