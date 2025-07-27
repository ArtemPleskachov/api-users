<?php

namespace App\Validator\Constraints\User;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class UniquePublicId extends Constraint
{
    public string $message = 'User with Id: "{{ value }}" already exists.';
    
    public function validatedBy(): string
    {
        return static::class . 'Validator';
    }
}