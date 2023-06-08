<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Faker\Factory::create('fr_FR');


        for ($com=1; $com < 100; $com++) { 
            $comment = new Comment();
            $comment->setCommentTricks($faker->text(255));

            $dateTime = $faker->dateTimeThisYear();
            $dateImmutable = \DateTimeImmutable::createFromMutable($dateTime);

            $comment->setCommentCreatedAt($dateImmutable);

            //On va chercher la ref d'un User
            $user = $this->getReference('usr-' . rand(1, 5));
            $comment->setUser($user);

            //On va chercher la ref d'un tricks
            $tricks = $this->getReference('trk-' . rand(1, 10));
            $comment->setTricks($tricks);

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            TricksFixtures::class,
            MediaTricksFixtures::class,
            VideoTricksFixtures::class
        ];
    }
}
