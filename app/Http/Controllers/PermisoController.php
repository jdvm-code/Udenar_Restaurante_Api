<?php
namespace App\Http\Controllers;

use App\Http\Services\PermisoService;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function __construct(private PermisoService $permisoServices)
    {

    } 
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->permisoServices->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->permisoServices->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->permisoServices->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->permisoServices->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->permisoServices->delete($id);
    }
}
