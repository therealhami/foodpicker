<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Repository\RestaurantsRepository;
use RestaurantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestaurantController extends AbstractController
{
    #[Route('/restaurants', 'restaurants')]
    public function restaurants(RestaurantsRepository $restaurantsRepository): Response
    {
        $restaurants = $restaurantsRepository->findAll();

        return $this->render('restaurants.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    #[Route(path: '/restaurant/add', name: 'restaurant_add', methods: ['POST', 'GET'])]
    public function restaurantAdd(Request $request, RestaurantsRepository $restaurantsRepository): Response
    {
        $restaurant = new Restaurants();
        $form = $this->createForm(RestaurantType::class, $restaurant)->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form->get('fileName')->getData();

            $image->move(
                $this->getParameter('kernel.project_dir') . '/assets/images/',
                $image->getClientOriginalName()
            );

            $restaurant->setCategories(array_map(fn($categories) => $categories->getName(), $restaurant->getCategories()));
            $restaurant->setFileName($image->getClientOriginalName());
            $restaurantsRepository->save($restaurant);

            return $this->redirectToRoute('restaurants');
        }

        return $this->render('restaurant_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/restaurant/{id}', name: 'restaurant_delete', methods: ['GET', 'DELETE'])]
    public function restaurantDelete(Restaurants $restaurant, RestaurantsRepository $restaurantsRepository)
    {
        $restaurantsRepository->delete($restaurant);

        return $this->redirectToRoute('restaurants');
    }
}