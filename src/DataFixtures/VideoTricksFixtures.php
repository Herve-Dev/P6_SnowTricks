<?php

namespace App\DataFixtures;

use App\Entity\VideoTricks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class VideoTricksFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $videoUrl = [
            'https://www.youtube.com/embed/kOyCsY4rBH0',
            'https://www.youtube.com/embed/9Bhh28m_yBM',
            'https://www.youtube.com/embed/BqlxmzTJ5jo',
            'https://www.youtube.com/embed/HJiAYHGQApU',
            'https://www.youtube.com/embed/IlUy9gQJoss',
        ];

        for ($vidTrk=1; $vidTrk < 20; $vidTrk++) { 
            $videoTricks = new VideoTricks();
            $randomKey = array_rand($videoUrl);
            $randomUrl = $videoUrl[$randomKey];
            $videoTricks->setVideoUrl($randomUrl);
            
            $tricks = $this->getReference('trk-' . rand(1, 10));
            $videoTricks->setTricks($tricks);

            $manager->persist($videoTricks);

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
