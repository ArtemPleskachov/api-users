<?php

namespace App\Entity;

use App\Enum\UserRoleEnum;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 8, unique: true)]
    private string $login;
    
    #[ORM\Column(length: 8)]
    private string $phone;
    
    #[ORM\Column(length: 255, name: 'password_hash')]
    private string $passwordHash;
    
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $publicId;
    
    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];
    
    public function getUserIdentifier(): string
    {
        return $this->login;
    }
    
    public function eraseCredentials(): void
    {
    }
    
    public function getRoles(): array
    {
        $roles = $this->roles;
        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }
        return array_values(array_unique($roles));
    }
    
    /**
     * @param array<int, string|UserRoleEnum> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = array_values(array_unique(array_map(
            fn($r) => $r instanceof UserRoleEnum ? $r->value : (string)$r,
            $roles
        )));
        return $this;
    }
    
    public function getPassword(): string
    {
        return $this->passwordHash;
    }
    
    public function setPassword(string $hash): self
    {
        $this->passwordHash = $hash;
        return $this;
    }
    
    public function getId(): ?int { return $this->id; }
    
    public function getLogin(): string { return $this->login; }
    public function setLogin(string $login): self { $this->login = $login; return $this; }
    
    public function getPhone(): string { return $this->phone; }
    public function setPhone(string $phone): self { $this->phone = $phone; return $this; }
    
    public function getPublicId(): string { return $this->publicId; }
    public function setPublicId(string $publicId): self { $this->publicId = $publicId; return $this; }
}