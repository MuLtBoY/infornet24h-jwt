<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function register(array $data): array
    {
        $user = $this->userRepository->create($data);

        if (! $user) {
            throw new \RuntimeException('Erro ao criar usuário.');
        }

        $token = JWTAuth::fromUser($user);

        return ['user' => $user->setAttribute('token', $token)];
    }

    public function login(string $email, string $password): array|bool
    {
        $token = JWTAuth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (! $token) {
            return false;
        }

        return ['user' => JWTAuth::user()->setAttribute('token', $token)];
    }

    public function logout(): void
    {
        try {
            JWTAuth::parseToken()->invalidate();
        } catch (TokenExpiredException $e) {
            throw new \Exception('Token já expirou.', 401);
        } catch (TokenInvalidException $e) {
            throw new \Exception('Token inválido.', 400);
        } catch (JWTException $e) {
            throw new \Exception('Token não encontrado.', 400);
        }
    }
}