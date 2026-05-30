<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\AsistenciaService;
use App\Http\Services\ReservaService;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function __construct(private ReservaService $reservaService)
    {
        //
     }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->reservaService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Primero validas que los campos obligatorios vengan en la petición
            $request->validate([
                'becas_id' => 'required|integer',
                'horarios_id' => 'required|integer',
                'comidas_id' => 'required|integer',
                'estados_reservas_id' => 'required|integer',
                'fecha_registro' => 'required|date_format:Y-m-d H:i:s',
                'fecha_reserva' => 'required|date_format:Y-m-d',
            ]);

            $nuevaReserva = $this->reservaService->store($request);

            return response()->json([
                'status' => 'success',
                'message' => 'Reserva creada exitosamente.',
                'data' => $nuevaReserva
            ], 201);

        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 400;

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->reservaService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $reservaActualizada = $this->reservaService->update($request, (int)$id);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Reserva actualizada correctamente.',
                'data' => $reservaActualizada
            ], 200);

        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 400;
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->reservaService->delete($id);
    }

    /**
     * Verifica el código QR enviado desde el cliente.
     */
    public function verificarQR(Request $request)
    {
        // Validamos que el código venga en el cuerpo de la petición
        $request->validate([
            'codigo' => 'required|string'
        ]);

        try {
            // Se invoca el método a través del servicio inyectado
            $reserva = $this->reservaService->verificarQR($request->codigo);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Reserva verificada con éxito. ¡Buen provecho!',
                'data' => $reserva
            ], 200);

        } catch (\Exception $e) {
            // Captura los errores controlados (404 o 400) que lanzamos con 'throw new Exception'
            $statusCode = $e->getCode() ?: 400;
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }
}
