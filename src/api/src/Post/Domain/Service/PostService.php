<?php

namespace App\Post\Domain\Service;

use App\Post\Domain\Model\Post;
use App\Post\Domain\Repository\PostRepository;

class PostService
{
    public function __construct(private PostRepository $postRepository) {}

    public function createPost(string $email, string $password): Post
    {
        // Perform validations, create the Post entity
        $post = new Post($email, $password);
        $this->postRepository->save($post);
        return $post;
    }

    public function deletePost(int $id): void
    {
        $post = $this->postRepository->findById($id);
        if ($post) {
            $this->postRepository->remove($post);
        }
    }
}