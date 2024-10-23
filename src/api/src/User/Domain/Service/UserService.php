<?php

namespace App\User\Domain\Service;

use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(string $email, string $password): User
    {
        // Perform validations, create the User entity
        $user = new User($email, $password);
        $this->userRepository->save($user);
        return $user;
    }

    public function deleteUser(int $id): void
    {
        $user = $this->userRepository->findById($id);
        if ($user) {
            $this->userRepository->remove($user);
        }
    }
}