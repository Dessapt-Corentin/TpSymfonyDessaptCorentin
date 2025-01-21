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
        $film = $filmRepository->findAll();
        return $this->render('home/index.html.twig', [
            'title' => $title,
            'film' => $film,
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

    /**
     * Méthode qui retourne la liste des jeux par console
     * @Route("/console/{id}", name="app_genre")
     * @param FilmRepository $filmRepository
     * @param int $id
     * @return Response
     */
    #[Route('/film/genre/{id}', name: 'app_genre')]
    public function filmByGenre(FilmRepository $filmRepository, int $id): Response
    {
        //on récupére les films filtré par consoles : $film
        $film = $filmRepository->getFilmByGenre($id);
        //on définire le titre avec le nom du genre (action,horreur...) : $title
        $title = 'Tous les films';
        if (isset($film[0]['genre'])) {
            $title .= ' : ' . $film[0]['genre'];
        }


        return $this->render('home/index.html.twig', [
            'film' => $film,
            'title' => $title
        ]);
    }

    /**
     * Méthode qui retourne la liste des jeux par age
     * @Route("/pegi/{id}", name="app_pegi")
     * @param FilmRepository $filmRepository
     * @param int $id
     * @return Response
     */
    #[Route('/film/pegi/{id}', name: 'app_age')]
    public function gameByPegi(FilmRepository $filmRepository, int $id): Response
    {
        //on récupére les jeux filtré par age : $film
        $film = $filmRepository->getGamesByAge($id);
        //on définire le titre avec le label de l'age : $title
        $title = 'Tous les jeux : ' . $film[0]['label'] . ' +';

        return $this->render('home/index.html.twig', [
            'film' => $film,
            'title' => $title
        ]);
    }

    /**
     * Méthode qui retourne la liste des jeux filtre
     * @param FilmRepository $filmRepository
     * @param string $field
     * @return Response
     */
    #[Route('/film/filter/{field}', name: 'app_filter')]
    public function getByFilter(FilmRepository $filmRepository, string $field): Response
    {
        // on récupere les jeux filtré par $fields
        $film = $filmRepository->getFilmByFilter($field);

        return $this->render('home/index.html.twig', [
            'film' => $film,
        ]);
    }
}
