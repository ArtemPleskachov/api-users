<?php

namespace App\Repository\Contract;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function remove(User $user): void;
    
    public function findAll(): array;
    public function findById(int $id): ?User;
    public function findOneByLogin(string $login): ?User;
    public function findByPublicId(string $publicId): ?User;
    public function findOneByLoginAndPass(string $login, string $pass): ?User;
}