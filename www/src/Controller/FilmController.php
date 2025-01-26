<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/film')]
final class FilmController extends AbstractController
{
    #[Route(name: 'app_film_index', methods: ['GET'])]
    public function index(FilmRepository $filmRepository): Response
    {
        return $this->render('film/index.html.twig', [
            'films' => $filmRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_film_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($film);
            $entityManager->flush();

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('film/new.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_film_show', methods: ['GET'])]
    public function show(Film $film, FilmRepository $filmRepository, int $id): Response
    {
        $film = $filmRepository->getFilmWithInfo($id);
        $genre = $filmRepository->getGenresByFilm($id);
        $prod = $filmRepository->getActorsByFilm($id);
        return $this->render('film/show.html.twig', [
            'film' => $film,
            'genre' => $genre,
            'prod' => $prod,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_film_edit', methods: ['GET', 'POST'])]
    public function edit(Film $film, Request $request, FilmRepository $filmRepository): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        //partie gestion du formulaire
        if($form->isSubmitted() && $form->isValid()){
            //gestion de l'image uploadé
            $imageFile = $form->get('imagePath')->getData();
            if($imageFile instanceof UploadedFile){
                //si j'ai une image uploader, on récupère son nom d'origine
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                //on genere un nom unique pour éviter d'ecraser des images du meme nom
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                   //on déplace l'image uploadé vers le dossier de destination (public/images/games)
                   $imageFile->move(
                    //game_images_directory est configuré dans config/services.yaml
                    $this->getParameter('film_images_directory'),
                    $newFilename
                   );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Une erreur est survenue lors de l\'upload de l\'image');
                }

                //on set le nom de l'image dans l'entité
                $film->setImagePath($newFilename);
            }

            //on enregistre le jeu dans la bdd
            $filmRepository->save($film, true);

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }

        //partie ou on renvoie la vue du formulaire
        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_film_delete', methods: ['POST'])]
    public function delete(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$film->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
    }
}
