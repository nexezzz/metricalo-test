<?php
namespace App\Post\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'posts')]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function __construct(
        #[ORM\Column(type: 'string', length: 180, unique: true)]
        private string $title, 
        #[ORM\Column(type: 'string', length: 255, unique: true)]
        private string $description
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}