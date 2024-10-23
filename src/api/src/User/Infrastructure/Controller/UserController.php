<?php
namespace App\User\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    public function register(Request $request): JsonResponse
    {
        // Handle user registration logic
        return new JsonResponse(['message' => 'User registered successfully']);
    }

    public function login(Request $request): JsonResponse
    {
        // Handle login logic
        return new JsonResponse(['message' => 'Login successful']);
    }

    public function profile(): JsonResponse
    {
        // Return user profile data
        return new JsonResponse(['data' => ['email' => 'user@example.com']]);
    }
}