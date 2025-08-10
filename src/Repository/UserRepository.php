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
        $this->em = $this->getEntityManager();
    }
    
    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
    
    public function remove(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
    
    public function findAll(): array
    {
        return parent::findAll();
    }
    
    public function findById(int $id): ?User
    {
        return $this->find($id);
    }
    
    public function findOneByLogin(string $login): ?User
    {
        return $this->findOneBy(['login' => $login]);
    }
    
    public function findByPublicId(string $publicId): ?User
    {
        return $this->findOneBy(['publicId' => $publicId]);
    }
    
    public function findOneByLoginAndPass(string $login, string $pass): ?User
    {
        return $this->findOneBy(['login' => $login, 'pass' => $pass]);
    }
}