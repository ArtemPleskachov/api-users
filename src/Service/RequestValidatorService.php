<?php

namespace App\Service;

use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestValidatorService
{
    public function __construct(private ValidatorInterface $validator) {}
    
    public function validate(object $dto): void
    {
        $errors = $this->validator->validate($dto);
        
        if (count($errors) > 0) {
            throw new ValidationFailedException($dto, $errors);
        }
    }
}