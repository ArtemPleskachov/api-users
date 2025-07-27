<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueUser extends Constraint
{
    public string $message = 'User with login "{{ login }}" and password "{{ pass }}" already exists.';
    
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}