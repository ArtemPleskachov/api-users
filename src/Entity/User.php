<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8)]
    private ?string $�login = null;

    #[ORM\Column(length: 8)]
    private ?string $phone = null;

    #[ORM\Column(length: 8)]
    private ?string $pass = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function get�login(): ?string
    {
        return $this->�login;
    }

    public function set�login(string $�login): static
    {
        $this->�login = $�login;

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
