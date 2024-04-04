<?php

namespace App\Controller;

use App\Repository\RestaurantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', 'index')]
    public function index(RestaurantsRepository $restaurantsRepository): Response
    {
        $restaurants = $restaurantsRepository->findAll();

        $randomRestaurant = $restaurants[array_rand($restaurants)];
        return $this->render('index.html.twig', [
            'restaurant' => $randomRestaurant
        ]);
    }

    #[Route('/orders', 'orders')]
    public function orders(): RedirectResponse
    {
       return  $this->redirectToRoute('index');
    }
}