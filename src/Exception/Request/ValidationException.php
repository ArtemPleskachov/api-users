<?php

namespace App\Exception\Request;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException
{
    public function __construct(array $errors)
    {
        parent::__construct(422, 'Validation failed');
        $this->errors = $errors;
    }
    
    private array $errors;
    
    public function getErrors(): array
    {
        return $this->errors;
    }
}