<?php

namespace App\Service;

use App\Exception\Request\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestValidatorService
{
    public function __construct(private ValidatorInterface $validator) {}
    
    public function validate(object $dto): void
    {
        $errors = $this->validator->validate($dto);
    
        if (count($errors) > 0) {
            $messages = [];
        
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }
        
            throw new ValidationException($messages);
        }
    }
}