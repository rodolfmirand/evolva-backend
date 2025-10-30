<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
            'password' => ['required', 'confirmed', Password::min(8)], 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        try {
            $user = $this->userService->createUser($validator->validated());

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Usuário registrado com sucesso!',
                'user'    => $user,
                'token'   => $token,
            ], 201); // 201 Created

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao registrar usuário',
                'error'   => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }
}
