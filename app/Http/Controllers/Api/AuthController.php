<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $authService, $code = 201)
    {
        $user = $authService->register($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => new UserResource($user)
        ], $code);
    }

    public function login(Request $request, AuthService $authService)
    {
        $token = $authService->login($request->only('email', 'password'));

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => null
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
