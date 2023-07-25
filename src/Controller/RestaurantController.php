<?php

namespace App\Controller;
use App\Entity\Restaurant;
use App\Entity\Comment;
use App\Form\RestaurantType;
use App\Form\CommentType;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class RestaurantController extends AbstractController
{
    #[Route('/restaurant', name: 'app_restaurant')]
    public function index(): Response
    {
        // return $this->render('restaurant/index.html.twig', [
        //     'controller_name' => 'RestaurantController',
        // ]);
        return $this->render('restaurant/index.html.twig', [
            // 'restaurants' => $restaurantRepository->findAll(),
            'restaurants' => $this->getDoctrine()->getRepository(Restaurant::class)->findLastTenElements(),
        ]);
    }
    /**
     * Affiche et gère le formulaire de création de restaurant
     * @Route("/restaurant/new", name="restaurant_new", methods={"GET", "POST"})
    */
    public function new(Request $request)
    {
        $restaurant = new Restaurant();

        $form = $this->createForm(RestaurantType::class, $restaurant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = $form->getData();
            $restaurant->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('app_restaurant');
        }

        return $this->render('restaurant/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // /**
    //  * Affiche un restaurant
    //  * @Route("/restaurant/{id}", name="restaurant_show", methods={"GET"}, requirements={"restaurant"="\d+"})
    //  * @param Restaurant $restaurant
    //  * @return Response
    //  */
    
    // public function show(Restaurant $restaurant)
    // {
        
    //     return $this->render('restaurant/show.html.twig', [
    //         'restaurant' => $restaurant
    //     ]);
    // }
    /**
     * Affiche un restaurant
     * @Route("/restaurant/{id}", name="restaurant_show", methods={"GET", "POST"}, requirements={"restaurant"="\d+"})
     * @param Request $request
     * @param Restaurant $restaurant
     * @return Response
     */
    public function show(Request $request, Restaurant $restaurant)
    {

        /**
         * Gestion du formulaire Picture
         */
        // $picture = new RestaurantPicture();
        // $formPicture = $this->createForm(RestaurantPictureType::class, $picture);

        // $formPicture->handleRequest($request);

        // if ($formPicture->isSubmitted() && $formPicture->isValid()) {

        //     $file = $formPicture['filename']->getData();
        //     if ($file) {

        //         $filename = $fileUploader->upload($file);

        //         $picture->setFilename($filename);

        //         // Le restaurant de l'image est le restaurant qui est affiché sur la page
        //         $picture->setRestaurant($restaurant);

        //     }

        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($picture);
        //     $entityManager->flush();

        //     // On redirige vers la page du restaurant une fois l'image postée
        //     return $this->redirectToRoute('restaurant_show', ['restaurant' => $restaurant->getId()]);
        // }
        /**
         * // Fin de gestion du formulaire Picture
         */

        /**
         * Gestion du formulaire Review
         */

        $comment = new Comment();

        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment = $formComment->getData();

            // Le User de la review est le User connecté
            $comment->setUser($this->getUser());

            // Le restaurant de la review est le Restaurant qu'on affiche
            $comment->setRestaurant($restaurant);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            // On redirige vers la page du restaurant une fois la review postée
            return $this->redirectToRoute('restaurant_show', ['id' => $restaurant->getId()]);
        }

        /**
         * // Fin de gestion du formulaire Review
         */

        /**
         * Par défaut : on renvoie la vue restaurant/show.html.twig avec:
         * - le restaurant à afficher
         * - le formulaire d'images formPicture
         * - le formulaire de review formReview
         */
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
            // 'formPicture' => $formPicture->createView(),
            'formComment' => $formComment->createView()
        ]);
    }

    
    

    /**
     * Traite la requête d'un formulaire de création de restaurant
     * @Route("/restaurant", name="restaurant_create", methods={"POST"})
     */
    public function create()
    {
    }

    /**
     * Affiche le formulaire d'édition d'un restaurant (GET)
     * Traite le formulaire d'édition d'un restaurant (POST)
     * @Route("/restaurant/{restaurant}/edit", name="restaurant_edit", methods={"GET", "POST"})
     * @param Restaurant $restaurant
     */
    public function edit(Restaurant $restaurant)
    {
    }

    /**
     * Supprime un restaurant
     * @Route("/restaurant/{restaurant}", name="restaurant_delete", methods={"DELETE"})
     * @param Restaurant $restaurant
     */
    public function delete(Restaurant $restaurant)
    {
    }
}
