<?php
namespace App\Http\Repository;

use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserService
{
    public function __construct(private User $model)
    {
        parent::__construct($model);
    
    }
      public function store(Request $request)
    {
        try {
            $token =bin2hex(random_bytes(16));
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remeber_token'=> $token,
                'role_id'=>$request->role_id
            ]);
            // Generate token
            //$token = JWTAuth::fromUser($user);
            //Mail::to($user->email)->send(new ConfirmAccount($user));
            return $user;
        } catch (\Exception $e) {
            // Handle the exception (e.g., log the error, return an error response) 
            return response()->json(['error' => 'Failed to create user', 'message' => $e->getMessage()], 500);
        }
    }


}
