<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UserFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private UserPasswordHasherInterface $passwordEncoder){}
    
    public function load(ObjectManager $manager): void
    {
        
        $faker = Faker\Factory::create('fr_FR');

        for ($usr=1; $usr <= 5 ; $usr++) { 
            $user = new User;
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $user->setUsername($faker->userName);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'DemoPassword123')
            );

            $manager->persist($user);

            $this->addReference('usr-' . $usr, $user);
            $this->counter++;
        }

        $manager->flush();
    }
}
