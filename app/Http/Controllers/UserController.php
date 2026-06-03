<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userServices) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->userServices->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->userServices->store($request);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->userServices->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->userServices->update($request, $id);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->userServices->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario eliminado correctamente.'
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
     * metodo para el cambio de contraseña mediante la contraseña actual
     */
    public function cambiarPassword(Request $request, int $id)
    {
        $request->validate([
            'password_actual' => 'required|string',
            'nuevo_password' => 'required|string|min:8|confirmed'
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'confirmed' => 'La confirmación de la nueva contraseña no coincide.'
        ], [
            'password_actual' => 'contraseña actual',
            'nuevo_password' => 'nueva contraseña'
        ]);

        try {
            $this->userServices->cambiarPassword($id, $request->password_actual, $request->nuevo_password);

            return response()->json([
                'status' => 'success',
                'message' => 'Contraseña actualizada correctamente.'
            ], 200);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 400;
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    public function countAdmin(){
        $this->userServices->countAdmin();
    }
}
