<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\Contract\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
    
    public function remove(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }
    
    public function findAll(): array
    {
        return parent::findAll();
    }
    
    public function findById(int $id): ?User
    {
        return $this->find($id);
    }
    
    public function findByLogin(string $login): ?User
    {
        return $this->findOneBy(['login' => $login]);
    }
    
    public function findByPublicId(string $publicId): ?User
    {
        return $this->findOneBy(['publicId' => $publicId]);
    }
}