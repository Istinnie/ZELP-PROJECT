<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class RestaurantFixtures extends Fixture implements DependentFixtureInterface
{
    private $villeRepository;

    public  function __construct(VilleRepository $villeRepository) {
        $this->villeRepository = $villeRepository;
    }
    
    public function load(ObjectManager $manager)
    {
        
        for($i=0; $i < 10; $i++) {

            $restaurant = new Restaurant();
            $restaurant->setName("Chez Ninie");
            $restaurant->setDescription( "Description" );
            $restaurant->setVille( $this->villeRepository->find( rand(1, 10) ) );
            $manager->persist($restaurant);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            VilleFixtures::class,
        );
    }
}