<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Repository\RestaurantsRepository;
use RestaurantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestaurantController extends AbstractController
{
    #[Route('/restaurants', 'restaurants')]
    public function index(RestaurantsRepository $restaurantsRepository): Response
    {
        $restaurants = $restaurantsRepository->findAll();

        return $this->render('restaurants.html.twig', [
            'restaurants' => $restaurants
        ]);
    }

    #[Route(path: '/restaurant/add', name: 'restaurant_add', methods: ['POST', 'GET'])]
    public function addRestaurant(Request $request, RestaurantsRepository $restaurantsRepository): Response
    {
        $restaurant = new Restaurants();
        $restaurant->setCategories([]);
        $form = $this->createForm(RestaurantType::class, $restaurant)->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $restaurant = $form->getData();
        }

        return $this->render('restaurant_add.html.twig', [
            'form' => $form,
        ]);
    }
}