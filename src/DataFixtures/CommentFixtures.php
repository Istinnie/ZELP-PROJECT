<?php

namespace App\DataFixtures;
use App\Entity\Comment;
use App\Repository\RestaurantRepository;
use App\Repository\CommentRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    private $restaurantRepository;
    private $commentRepository;

    public function __construct(RestaurantRepository $restaurantRepository, CommentRepository $commentRepository) {
        $this->restaurantRepository = $restaurantRepository;
        $this->commentRepository = $commentRepository;
    }

    public function load(ObjectManager $manager)
    {

        
        /**
         * On créée 20 avis 
         */
        for ($i=0; $i<20; $i++) {
            $comment = new Comment();
            $comment->setMessage( "Test d'avis" );
            $comment->setRating( rand(0,5) );
            $comment->setRestaurant( $this->restaurantRepository->find(rand(1, 1000)) );
            $manager->persist($comment);
        }

        /**
         * On les enregistre en DB
         */
        $manager->flush();


        /**
         * On créée 30 comments enfants (dont le parent est une des comment initiales)
         */
        for ($i=0; $i<30; $i++) {
            $comment = new Comment();
            $comment->setMessage("Exemple de commentaires");
            $comment->setRating( rand(0,5) );
            $comment->setParent( $this->commentRepository->find(rand(1, 30)) ); // On cherche un ID entre 1 et 70 (un commentaire initial)
            $comment->setRestaurant( $comment->getParent()->getRestaurant() ); // On récupère le restaurant de la comment parente
            $manager->persist($comment);

        }

        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            RestaurantFixtures::class,
        );
    }
}
