<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setUsername('User1')
            ->setEmail('floryss.devweb+1@gmail.com')
            ->setCreatedAt(new DateTimeImmutable())
            ->setToken('token123')
        ;
        $manager->persist($user);

        $user2 = new User();
        $user2
            ->setUsername('User2')
            ->setEmail('floryss.devweb+2@gmail.com')
            ->setCreatedAt(new DateTimeImmutable())
            ->setToken('token123')
        ;
        $manager->persist($user2);

        $manager->flush();
    }
}