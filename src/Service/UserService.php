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
    
    public function update(string $publicId, UserRequestDTO $dto): User
    {
        $user = $this->getUserByPublicId($publicId);
        
        $user
            ->setLogin($dto->login)
            ->setPass($dto->pass)
            ->setPhone($dto->phone);
        
        $this->userRepository->save($user);
        
        return $user;
    }
    
    public function getUserByPublicId(string $publicId): User
    {
        return $this->userRepository->findByPublicId($publicId);
    }
    
    public function delete(string $publicId): void
    {
        $user = $this->getUserByPublicId($publicId);
        $this->userRepository->remove($user);
    }
}