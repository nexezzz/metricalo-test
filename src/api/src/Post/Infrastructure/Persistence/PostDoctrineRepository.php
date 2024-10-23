<?php

namespace App\Post\Infrastructure\Persistence;

use App\Post\Domain\Repository\PostRepository;
use App\Post\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostDoctrineRepository implements PostRepository
{
    private EntityManagerInterface $entityManager; 

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findById(int $id): ?Post
    {
        return $this->entityManager->getRepository(Post::class)->find($id);
    }

    public function findByTitle(string $title): ?Post
    {
        return $this->entityManager->getRepository(Post::class)->findOneBy(['title' => $title]);
    }

    public function save(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function remove(Post $post): void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}