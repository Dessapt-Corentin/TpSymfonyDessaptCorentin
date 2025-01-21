<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Film>
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    /**
     * Méthode qui retourne un film avec toutes ses informations
     * @param int $id
     * @return Film
     */
    public function getFilmWithInfo(int $id): array
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $query = $qb->select([
            'f.id',
            'f.titre',
            'f.synopsis',
            'f.time',
            'f.dateSortie',
            'f.imagePath',
            'a.id as ageId',
            'a.label',
            'a.imagePath as ageImagePath',
            'n.mediaNote',
            'n.viewerNote',
        ])
            ->from(Film::class, 'f')
            ->join('f.age', 'a')
            ->join('f.note', 'n')
            ->where('f.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Méthode qui retourne les genres d'un film
     * @param int $id
     * @return array
     */
    public function getGenresByFilm(int $id): array
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $query = $qb->select([
            'g.id',
            'g.label',
        ])
            ->from(Film::class, 'f')
            ->join('f.genre', 'g')
            ->where('f.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Méthode qui retourne les acteurs d'un film
     * @param int $id
     * @return array
     */
    public function getActorsByFilm(int $id): array
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $query = $qb->select([
            'p.id',
            'p.nom',
            'p.prenom',
        ])
            ->from(Film::class, 'f')
            ->join('f.prod', 'p')
            ->where('f.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getResult();
    }
}
