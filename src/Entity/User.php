<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
#[ORM\UniqueConstraint(name: "unique_login_pass", columns: ["login", "pass"])]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8)]
    private ?string $login = null;

    #[ORM\Column(length: 8)]
    private ?string $phone = null;

    #[ORM\Column(length: 8)]
    private ?string $pass = null;
    
    #[ORM\Column(type: 'string', length: 8, unique: true)]
    private string $publicId;
    
    
    public function getPublicId(): string
    {
        return $this->publicId;
    }
    
    public function setPublicId(string $publicId): static
    {
        $this->publicId = $publicId;
        
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getlogin(): ?string
    {
        return $this->login;
    }

    public function setlogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): static
    {
        $this->pass = $pass;

        return $this;
    }
}
