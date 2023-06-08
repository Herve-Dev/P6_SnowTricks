<?php

namespace App\DataFixtures;

use App\Entity\Tricks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class TricksFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $tricksArrayName = [
            '50-50',
            'FrontSide 180',
            'rails',
            'Backside 360',
            'Indy Grab',
            'Nose Grab',
            'Backflip',
            'Cork',
            'Tail Grab',
            'Jib'
        ]; 

        $faker = Faker\Factory::create('fr_FR');
        for ($trk=1; $trk <= 10 ; $trk++) { 
            $tricks = new Tricks();
            $tricks->setTricksName($tricksArrayName[$trk -1]);
            $tricks->setTricksDescription($faker->text(200));

            //On va chercher une référence de catégorie
            $category = $this->getReference('cat-' . rand(1, 4));
            $tricks->setCategory($category);

            //On va chercher un id d'un user
            $user = $this->getReference('usr-' . rand(1, 5));
            $tricks->setUser($user);

            $manager->persist($tricks);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
