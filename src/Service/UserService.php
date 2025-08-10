<?php

namespace App\Service;

use App\DTO\Request\Auth\RegisterDTO;
use App\DTO\Request\User\UpdateUserDTO;
use App\Entity\User;
use App\Factory\UserFactory;
use App\Repository\Contract\UserRepositoryInterface;
use DomainException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly JWTTokenManagerInterface $jwtManager,
    ) {}
    
    /**
     * @return array{user: User, token: string}
     */
    public function registerAndIssueToken(RegisterDTO $dto): array
    {
        if ($dto->password !== $dto->passwordConfirm) {
            throw new DomainException('Passwords do not match.', 422);
        }
        
        if ($this->userRepository->findOneByLogin($dto->login)) {
            throw new DomainException('Login already taken.', 409);
        }
        
        $user = UserFactory::createFromRequest($dto);
        $user->setPassword($this->hasher->hashPassword($user, $dto->password));
        
        $this->userRepository->save($user);
        $token = $this->jwtManager->create($user);
        
        return ['user' => $user, 'token' => $token];
    }
    
    public function update(string $publicId, UpdateUserDTO $dto): User
    {
        $user = $this->getUserByPublicId($publicId);
        
        if ($dto->login !== null)  { $user->setLogin($dto->login); }
        if ($dto->phone !== null)  { $user->setPhone($dto->phone); }
        
        if ($dto->password !== null) {
            $user->setPassword($this->hasher->hashPassword($user, $dto->password));
        }
        
        $this->userRepository->save($user);
        return $user;
    }
    
    public function getUserByPublicId(string $publicId): User
    {
        $user = $this->userRepository->findByPublicId($publicId);
        if (!$user) {
            throw new DomainException('User not found', 404);
        }
        return $user;
    }
    
    public function delete(string $publicId): void
    {
        $user = $this->getUserByPublicId($publicId);
        $this->userRepository->remove($user);
    }
}