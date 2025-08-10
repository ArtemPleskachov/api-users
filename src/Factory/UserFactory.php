<?php

namespace App\Factory;

use App\DTO\Request\Auth\RegisterDTO;
use App\Entity\User;
use App\Enum\UserRoleEnum;
use Symfony\Component\Uid\Uuid;

class UserFactory
{
    public static function createFromRequest(RegisterDTO $dto): User
    {
        return (new User())
            ->setPublicId(Uuid::v4()->toRfc4122())
            ->setLogin($dto->login)
            ->setPhone($dto->phone)
            ->setRoles([UserRoleEnum::ROLE_USER]);
    }
}