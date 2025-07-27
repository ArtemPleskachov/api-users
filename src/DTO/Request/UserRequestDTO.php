<?php

namespace App\DTO\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequestDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 8)]
    public string $login;
    
    #[Assert\NotBlank]
    #[Assert\Length(max: 8)]
    public string $pass;
    
    #[Assert\NotBlank]
    #[Assert\Length(max: 8)]
    public string $phone;
    
    #[Assert\Uuid]
    public string $publicId;
    
    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        
        $dto = new self();
        $dto->login = $data['login'] ?? '';
        $dto->pass = $data['pass'] ?? '';
        $dto->phone = $data['phone'] ?? '';
        $dto->publicId = $data['publicId'] ?? '';
        
        return $dto;
    }
}