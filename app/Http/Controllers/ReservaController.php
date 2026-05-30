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
        return $this->reservaService->store($request);
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
        return $this->reservaService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->reservaService->delete($id);
    }
}
