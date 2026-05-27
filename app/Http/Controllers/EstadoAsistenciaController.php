<?php
namespace App\Http\Controllers;

use App\Http\Services\EstadoAsistenciaService;
use Illuminate\Http\Request;

class EstadoAsistenciaController extends Controller
{

    public function __construct(private EstadoAsistenciaService $estadoAsistencia)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->estadoAsistencia->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->estadoAsistencia->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->estadoAsistencia->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->estadoAsistencia->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->estadoAsistencia->delete($id);
    }
}
