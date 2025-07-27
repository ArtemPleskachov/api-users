<?php

namespace App\Service;

use App\DTO\Request\UserRequestDTO;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Repository\Contract\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}
    
    public function create(UserRequestDTO $dto): User
    {
        $user = UserFactory::createFromRequest($dto);
        $this->userRepository->save($user);
        
        return $user;
    }
    
    public function update(User $user, UserRequestDTO $dto): User
    {
        $user
            ->setLogin($dto->login)
            ->setPass($dto->pass)
            ->setPhone($dto->phone);
        
        $this->userRepository->save($user);
        
        return $user;
    }
    
    public function delete(User $user): void
    {
        $this->userRepository->remove($user);
    }
}