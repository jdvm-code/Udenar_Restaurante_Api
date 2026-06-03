<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\EstadoReservaService;

class EstadoReservaController extends Controller
{

    public function __construct(private EstadoReservaService $estadoReserva)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->estadoReserva->index($request);
        return response()->json([
            'success' => true,
            'message' => 'Estados de reservas',
            'data' => $this->estadoReserva->index($request),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->estadoReserva->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->estadoReserva->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->estadoReserva->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->estadoReserva->delete($id);
    }
}
