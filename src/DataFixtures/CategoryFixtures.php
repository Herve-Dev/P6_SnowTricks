<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private $counter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->createCategory('Butters', $manager);
        $this->createCategory('Grabs', $manager);
        $this->createCategory('Spins', $manager);
        $this->createCategory('Flips', $manager);

        $manager->flush();
    }

    public function createCategory(string $name, ObjectManager $manager): Category
    {
        $category = new Category();
        $category->setCategoryTricks($name);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}

