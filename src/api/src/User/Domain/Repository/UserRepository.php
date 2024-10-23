<?php

namespace App\User\Domain\Repository;

use App\User\Domain\Model\User;

interface UserRepository
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function save(User $user): void;
    public function remove(User $user): void;
}
