<?php
namespace App\Post\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PostController
{
    public function list(): JsonResponse
    {
        // Return a list of posts
        return new JsonResponse(['posts' => []]);
    }

    public function create(Request $request): JsonResponse
    {
        // Handle post creation logic
        return new JsonResponse(['message' => 'Post created successfully']);
    }

    public function view(int $id): JsonResponse
    {
        // Return details of a single post
        return new JsonResponse(['id' => $id, 'title' => 'Sample Post']);
    }
}