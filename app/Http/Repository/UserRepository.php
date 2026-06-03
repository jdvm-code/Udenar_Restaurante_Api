<?php

namespace App\Http\Repository;

use App\Http\Services\UserService;
use App\Mail\ConfirmAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserRepository extends BaseRepository implements UserService
{
    public function __construct(private User $model)
    {
        parent::__construct($model);
    }
    public function store(Request $request)
    {
        try {
            $token = bin2hex(random_bytes(16));
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remember_token' => $token,
                'role_id' => $request->role_id
            ]);
            // Generate token
            $token = JWTAuth::fromUser($user);
            // Mail::to($user->email)->send(new ConfirmAccount($user));
            return $user;
        } catch (\Exception $e) {
            // Handle the exception (e.g., log the error, return an error response)
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function cambiarPassword(int $id, string $passwordActual, string $nuevoPassword)
    {
        $usuario = $this->model->find($id);

        if (!$usuario) {
            throw new \Exception('El usuario no existe.', 404);
        }

        if (!Hash::check($passwordActual, $usuario->password)) {
            throw new \Exception('La contraseña actual es incorrecta.', 403);
        }

        if (Hash::check($nuevoPassword, $usuario->password)) {
            throw new \Exception('La nueva contraseña no puede ser igual a la anterior.', 400);
        }

        $usuario->update([
            'password' => Hash::make($nuevoPassword)
        ]);

        return true;
    }

    public function countAdmin()
    {
        try {
            $count = User::where('role_id', 1)->count();

            return response()->json([
                'success' => true,
                'message' => 'Conteo de administradores',
                'data' => ['count' => $count],
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al contar',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
