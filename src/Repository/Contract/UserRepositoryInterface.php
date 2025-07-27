<?php

namespace App\Repository\Contract;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function remove(User $user): void;
    
    public function findAll(): array;
    public function findById(int $id): ?User;
    public function findByLogin(string $login): ?User;
}