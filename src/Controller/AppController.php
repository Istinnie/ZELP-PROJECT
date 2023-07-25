<?php

namespace App\Controller;

use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractController
{
    // #[Route('/', name: 'app_index')]
    // public function index(): Response
    // {
    //     return $this->render('app/index.html.twig', [
    //         // 'controller_name' => 'AppController',
    //         'restaurants' => $this->getDoctrine()->getRepository(Restaurant::class)->findAll(),
    //     ]);
    // }
    // #[Route('/', name: 'app_index')]
    
    #[Route('/', name: 'app_restaurant_index', methods: ['GET'])]
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
        ]);
    }
}




