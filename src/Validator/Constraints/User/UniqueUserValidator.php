<?php

namespace App\Validator\Constraints\User;

use App\DTO\Request\CreateUserDTO;
use App\Repository\Contract\UserRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniqueUserValidator extends ConstraintValidator
{
    private UserRepositoryInterface $userRepository;
    
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function validate($value, Constraint $constraint)
    {
    
        if (!$value instanceof CreateUserDTO) {
            throw new UnexpectedValueException($value, CreateUserDTO::class);
        }
        
        $user = $this->userRepository->findOneByLoginAndPass($value->login,$value->pass);
        
        if ($user !== null) {
            $this->context->buildViolation($constraint->message)
                ->atPath('login')
                ->setParameter('{{ login }}', $value->login)
                ->setParameter('{{ pass }}', $value->pass)
                ->addViolation();
        }
    }
}