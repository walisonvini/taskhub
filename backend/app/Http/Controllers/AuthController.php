<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Auth\LoginRequest;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Traits\ApiResponse;

use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponse
    {
        return $this->successResponse(JWTAuth::user(), 'User retrieved successfully');
    }

    public function logout(): JsonResponse
    {
        JWTAuth::logout();

        return $this->successResponse(null, 'Successfully logged out');
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}