<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class ClientFixtures extends Fixture
{
    private $hasher;

    public function __construct(PasswordHasherFactoryInterface $factory)
    {
        $client = new Client();
        $this->hasher = $factory->getPasswordHasher($client);
    }

    public function load(ObjectManager $manager): void
    {
        $user = new Client();
        $user
            ->setUsername('User1')
            ->setEmail('floryss.devweb+1@gmail.com')
            ->setPassword($this->hasher->hash('secret'))
        ;
        $manager->persist($user);

        $user2 = new Client();
        $user2
            ->setUsername('User2')
            ->setEmail('floryss.devweb+2@gmail.com')
            ->setPassword($this->hasher->hash('secret'))
        ;
        $manager->persist($user2);

        $manager->flush();
    }
}