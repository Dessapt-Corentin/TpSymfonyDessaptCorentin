<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    /**
     * Méthode qui retourne la page d'accueil avec tous les films
     * @Route("/", name="app_home")
     * @param FilmRepository $filmRepository
     * @return Response
     */
    #[Route('/', name: 'app_home')]
    public function index(FilmRepository $filmRepository): Response
    {
        $title = 'Tous les films';
        $films = $filmRepository->findAll();
        return $this->render('home/index.html.twig', [
            'title' => $title,
            'films' => $films,
        ]);
    }

    /**
     * Méthode qui retourne le détail d'un film avec toutes ses informations
     * @Route("/film/{id}", name="app_detail")
     * @param FilmRepository $filmRepository
     * @param int $id
     * @return Response
     */
    #[Route('/film/{id}', name: 'app_detail')]
    public function filmById(FilmRepository $filmRepository, int $id): Response
    {
        $film = $filmRepository->getFilmWithInfo($id);
        $genre = $filmRepository->getGenresByFilm($id);
        $prod = $filmRepository->getActorsByFilm($id);
        return $this->render('home/detail.html.twig', [
            'film' => $film,
            'prod' => $prod,
            'genre' => $genre,
        ]);
    }
}
