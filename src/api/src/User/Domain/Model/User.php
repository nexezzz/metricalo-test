<?php
namespace App\User\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function __construct(
        #[ORM\Column(type: 'string', length: 180, unique: true)]
        private string $email, 
        #[ORM\Column(type: 'string')]
        private string $password
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}