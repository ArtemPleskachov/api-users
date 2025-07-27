<?php

namespace App\Factory;

use App\DTO\Request\UserRequestDTO;
use App\Entity\User;

class UserFactory
{
    public static function createFromRequest(UserRequestDTO $dto): User
    {
        return (new User())
            ->setPublicId($dto->publicId)
            ->setLogin($dto->login)
            ->setPass($dto->pass)
            ->setPhone($dto->phone);
    }
}