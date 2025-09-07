<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;

use App\Http\Resources\Auth\LoginResource;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Traits\ApiResponse;

use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        return $this->successResponse(new LoginResource([
            'token' => $token,
            'user' => auth()->user()
        ]), 'Login successful');
    }

    public function me(): JsonResponse
    {
        $user = auth()->user();

        return $this->successResponse(['user' => $user, 'company' => $user->company], 'User retrieved successfully');
    }

    public function logout(): JsonResponse
    {
        try {
            auth('api')->logout();
            return $this->successResponse(null, 'Successfully logged out');
        } catch (\Exception $e) {
            return $this->errorResponse('Logout failed: ' . $e->getMessage(), 500);
        }
    }

    public function refresh(): JsonResponse
    {
        return $this->successResponse(['token' => [
            'access_token' => JWTAuth::refresh(),
            'token_type' => 'Bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]], 'Token refreshed successfully');
    }

}