<?php
namespace App\DTO\Request\Auth;

use App\Enum\UserRoleEnum;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 8)]
    public string $login;
    
    #[Assert\NotBlank]
    #[Assert\Length(max: 8)]
    public string $phone;
    
    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 255)]
    public string $password;
    
    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 255)]
    public string $passwordConfirm;
}