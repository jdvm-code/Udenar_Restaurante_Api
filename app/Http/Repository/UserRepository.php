<?php

namespace App\Http\Repository;

use App\Http\Services\UserService;
use App\Mail\ConfirmAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $token = bin2hex(random_bytes(16));

        // Si esto falla (por ejemplo, correo duplicado), 
        // Laravel lanzará una excepción automáticamente hacia el controlador.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => $token,
            'role_id' => $request->role_id
        ]);

        return $user;
    }
}
