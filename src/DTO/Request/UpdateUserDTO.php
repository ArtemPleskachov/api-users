<?php
namespace App\DTO\Request\User;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class UpdateUserDTO
{
    #[Assert\Length(max: 8)]
    public ?string $login = null;
    
    #[Assert\Length(max: 8)]
    public ?string $phone = null;
    
    #[Assert\Length(min: 6, max: 255)]
    public ?string $password = null;
    
    public ?string $passwordConfirm = null;
    
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $ctx): void
    {
        if ($this->password !== null) {
            if ($this->passwordConfirm === null) {
                $ctx->buildViolation('Password confirmation is required.')
                    ->atPath('passwordConfirm')->addViolation();
            } elseif ($this->password !== $this->passwordConfirm) {
                $ctx->buildViolation('Passwords do not match.')
                    ->atPath('passwordConfirm')->addViolation();
            }
        }
    }
}