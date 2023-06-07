<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder){}
    
    public function load(ObjectManager $manager): void
    {
        $user = new User;
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_USER']);
        $user->setUsername('DemoUser');
        $user->setPassword(
            $this->passwordEncoder->hashPassword($user, 'DemoPassword123')
        );

        $manager->persist($user);
        $manager->flush();
    }
}
