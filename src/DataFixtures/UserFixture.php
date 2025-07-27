<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 12; $i++) {
            $user = new User();
            echo "Seeding user $i\n";
            $user->setLogin('user' . $i);
            $user->setPass('pass' . $i);
            $user->setPhone('0000' . $i);
            $user->setPublicId((string)$i);
            
            $manager->persist($user);
        }
        
        $manager->flush();
    }
}