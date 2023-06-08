<?php

namespace App\DataFixtures;

use App\Entity\MediaTricks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MediaTricksFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Faker\Factory::create('fr_FR');

        for ($medTrk=1; $medTrk < 50; $medTrk++) { 
            $mediaTricks = new MediaTricks();
            $mediaTricks->setMediaName($faker->image(null, 640, 480));
            $tricks = $this->getReference('trk-' . rand(1, 50));
            $mediaTricks->setTricks($tricks);
            
            $manager->persist($mediaTricks);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TricksFixtures::class
        ];
    }
}
