<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ApiResponse; // Asegúrate de importar el ApiResponse

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signup(SignupRequest $request): JsonResponse
    {
        try {
            $email = $request->input('email');
            $name = $request->input('name');
            $password = $request->input('password');

            $token = $this->authService->signup($email, $name, $password);

            // Usando ApiResponse para estructurar la respuesta
            return (new ApiResponse([
                'data' => ['token' => $token],
                'message' => 'User successfully registered'
            ]))->response()->setStatusCode(201);
        } catch (\Exception $e) {
            Log::error('Signup Error: ' . $e->getMessage());
            return (new ApiResponse([
                'data' => [],
                'message' => 'Failed to register user',
                'code' => 500 // Asegúrate de manejar los códigos de estado apropiadamente
            ]))->response()->setStatusCode(500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            $token = $this->authService->login($email, $password);

            if ($token === null) {
                return (new ApiResponse([
                    'data' => [],
                    'message' => 'Wrong email or password',
                    'code' => 401
                ]))->response()->setStatusCode(401);
            }

            return (new ApiResponse([
                'data' => ['token' => $token],
                'message' => 'Login successful'
            ]))->response()->setStatusCode(200);
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
            return (new ApiResponse([
                'data' => [],
                'message' => 'Failed to login',
                'code' => 500
            ]))->response()->setStatusCode(500);
        }
    }
}
