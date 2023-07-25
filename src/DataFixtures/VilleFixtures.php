<?php

namespace App\DataFixtures;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 10; $i++) {
            $ville = new Ville();
            $ville->setName("Saint-Denis");
            $ville->setCodePostal("97490");

            $manager->persist($ville);

        }
        $manager->flush();
    }
}
