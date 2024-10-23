<?php

namespace App\Post\Domain\Repository;

use App\Post\Domain\Model\Post;

interface PostRepository
{
    public function findById(int $id): ?Post;
    public function findByTitle(string $title): ?Post;
    public function save(Post $post): void;
    public function remove(Post $post): void;
}
