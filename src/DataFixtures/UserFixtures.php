<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class UserFixtures extends Fixture
{
    private $hasher;

    public function __construct(PasswordHasherFactoryInterface $factory)
    {
        $user = new User();
        $this->hasher = $factory->getPasswordHasher($user);
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setUsername('User1')
            ->setEmail('floryss.devweb+1@gmail.com')
            ->setPassword($this->hasher->hash('secret'))
            ->setCreatedAt(new DateTimeImmutable())
            ->setToken('token123')
        ;
        $manager->persist($user);

        $user2 = new User();
        $user2
            ->setUsername('User2')
            ->setEmail('floryss.devweb+2@gmail.com')
            ->setPassword($this->hasher->hash('secret'))
            ->setCreatedAt(new DateTimeImmutable())
            ->setToken('token123')
        ;
        $manager->persist($user2);

        $manager->flush();
    }
}