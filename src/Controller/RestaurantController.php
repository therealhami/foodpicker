<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}