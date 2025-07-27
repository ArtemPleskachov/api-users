<?php

namespace App\DTO\Request;
use App\Validator\Constraints\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueUser]
class UserRequestDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 8)]
        public readonly string $login,
        
        #[Assert\NotBlank]
        #[Assert\Length(max: 8)]
        public readonly string $pass,
        
        #[Assert\NotBlank]
        #[Assert\Length(max: 8)]
        public readonly string $phone,
        
        #[Assert\NotBlank]
        #[Assert\Length(max: 8)]
        public readonly string $publicId
    ) {}
    
    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        
        return new self(
            $data['login'] ?? '',
            $data['pass'] ?? '',
            $data['phone'] ?? '',
            $data['id'] ?? ''
        );
    }
}