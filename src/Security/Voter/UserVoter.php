<?php
namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface as CoreUser;

final class UserVoter extends Voter
{
    public const VIEW   = 'USER_VIEW';
    public const MANAGE = 'USER_MANAGE'; // для PUT
    
    protected function supports(string $attribute, mixed $subject): bool
    {
        return \in_array($attribute, [self::VIEW, self::MANAGE], true)
            && $subject instanceof User;
    }
    
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $actor = $token->getUser();
        if (!$actor instanceof CoreUser) {
            return false;
        }
        
        if (\in_array('ROLE_ADMIN', $actor->getRoles(), true)) {
            return true;
        }
        
        /** @var User $target */
        $target = $subject;
        return $actor->getPublicId() === $target->getPublicId();
    }
}