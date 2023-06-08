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
        
        $arrayImgTricks = [
            '1c179b4a84e5be39f4a0e994cdcb1c8a.webp',
            '6c4fc77200021efd2af6c64f7c29faf7.webp',
            '7cafc1592cc85ce8d50cc8a69c12f8fd.webp',
            '0425d89160c23604e7ef806e6075cb99.webp',
            '1822cb578816f92242493feec04bbaee.webp',
            '82968479442dd2f52411fc916c461b1c.webp',
            '834839ea0eb5a6e17c2c9ee11584fe51.webp',
            'b45b6b0781edd8a29355af36052edb95.webp',
            'ddc35d0a55559c6d4fe60fa23361b860.webp',
            'f24b2f2f79e87bab992574e2fb82b309.webp',
            '98c483c5c5f9d53fb568baf8750c4451.webp',
            '8c9cd42074008fb8e789b20faaa8ecfd.webp',
            '76b66cac48b7041414110b5d6807161e.webp',
            '6e995cd096498249e7461b76a96ea774.webp',
            '6c4fc77200021efd2af6c64f7c29faf7.webp',
            '82a8be4a942b101fd9d19410f21ca1d3.webp',
            '845c795532c5c0fcbc7ae21c42934b2a.webp',
            '3454f7aad262f4dcce2a2c40b91ee4c2.webp',
            'b8f515ed55e5ab52bac7e1b37f542ebb.webp',
            'e6caf286e4560455a2fd3a5c3c54714e.webp',
        ];

        for ($medTrk=1; $medTrk < 50; $medTrk++) { 
            $mediaTricks = new MediaTricks();

            $randomKey = array_rand($arrayImgTricks);
            $randomImg = $arrayImgTricks[$randomKey];

            $mediaTricks->setMediaName($randomImg);
            $tricks = $this->getReference('trk-' . rand(1, 10));
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
