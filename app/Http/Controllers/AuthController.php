<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $resultResource = [];
        try {
            $result = $this->authService->register($request->validated());
            $resultResource = ['user' => new UserResource($result['user'])];

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($resultResource, 'cadastrar usuário');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $resultResource = [];
        try {
            $result = $this->authService->login(
                $request->email,
                $request->password
            );
            
            $customMessage = 'realizar login';
            if (! $result) {
                $customMessage = 'validar token.';
                $this->responseCode = 401;
                throw new Exception('Credenciais inválidas.', 401);
            }

            $resultResource = ['user' => new UserResource($result['user'])];
        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse($resultResource, $customMessage);
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();

        } catch (Throwable $e) {
            $this->resolveException($e);
        }

        return $this->resolveResponse([], 'realizar logout');
    }
}