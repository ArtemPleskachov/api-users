<?php
namespace App\Validator\Constraints\User;

use App\Repository\Contract\UserRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniquePublicIdValidator extends ConstraintValidator
{
    public function __construct(private readonly UserRepositoryInterface $userRepository) {}
    
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }
        
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }
        
        if ($this->userRepository->findByPublicId($value) !== null) {
            $this->context->buildViolation($constraint->message)
                ->atPath('id')
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}