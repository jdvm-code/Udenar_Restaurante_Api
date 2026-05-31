<?php

namespace App\Http\Controllers;

use App\Http\Services\RoleService;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleServices) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->roleServices->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $role = $this->roleServices->store($request);
            return response()->json([
                'success' => true,
                'message' => 'Rol creado con éxito',
                'role' => $role
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el rol',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->roleServices->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->roleServices->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->roleServices->delete($id);
    }

    public function asignarPermiso(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permisos_id' => 'required|exists:permisos,id',
        ]);

        $role = Role::findOrFail($request->role_id);

        // attach() inserta directamente en la tabla rolesypermisos
        // usando syncWithoutDetaching() evitas que se duplique si repites la petición
        $role->permisos()->syncWithoutDetaching([$request->permisos_id]);

        return response()->json([
            'message' => 'Permiso asignado al rol con éxito.'
        ], 200);
    }
}
