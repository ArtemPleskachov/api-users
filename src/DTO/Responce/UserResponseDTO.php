<?php

namespace App\DTO\Responce;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class UserResponseDTO
{
    #[Groups(['put', 'post'])]
    public string $id;
    
    #[Groups(['post', 'get'])]
    public string $login;
    
    #[Groups(['post', 'get'])]
    public string $phone;
    
    #[Groups(['post', 'get'])]
    public string $pass;
    
    private function __construct() {}
    
    public static function fromEntity(User $user): self
    {
        $dto = new self();
        $dto->id = $user->getPublicId();
        $dto->login = $user->getLogin();
        $dto->phone = $user->getPhone();
        $dto->pass = $user->getPass();
        
        return $dto;
    }
}