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

    /**
     * Méthode qui retourne les films par genre
     * @param int $id
     * @return array
     */
    public function getFilmByGenre(int $id): array
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
            'g.label as genre',
            'n.mediaNote',
            'n.viewerNote',
        ])
            ->from(Film::class, 'f')
            ->join('f.age', 'a')
            ->join('f.note', 'n')
            ->join('f.genre', 'g')
            ->where('g.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Méthode qui retourne le nombre de film par genre
     * @return array
     */
    public function getCountFilmByGenre(): array
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $query = $qb->select([
            'g.id',
            'g.label',
            'COUNT(f.id) as nbFilm',
            'COUNT(f.id) as total',
        ])
            ->from(Film::class, 'f')
            ->join('f.genre', 'g')
            ->groupBy('g.id')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Méthode qui retourne les films par genre
     * @param string $filter
     * @return array
     */
    public function getFilmByFilter(string $filter): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT f.id, f.titre, f.synopsis, f.time, f.dateSortie, f.imagePath, a.id as ageId, a.label, a.imagePath as ageImagePath, n.mediaNote, n.viewerNote
            FROM App\Entity\Film f
            JOIN f.age a
            JOIN f.note n
            ORDER BY ' . $filter
        );

        return $query->getResult();
    }

    /**
     * Méthode qui récupere tous les ages avec le nombre de films assosiés
     * @return array
     */
    public function getCountFilmsByAge(): array
    {
        $entityManager = $this->getEntityManager();

        $qb = $entityManager->createQueryBuilder();

        $query = $qb->select([
            'a.id',
            'a.label',
            'a.imagePath',
            'COUNT(g.id) as total'
        ])
            ->from(Film::class, 'f')
            ->join('f.age', 'a')
            ->groupBy('a.id')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Méthode qui récupère les jeux par age
     * @param int $id
     * @return array
     */
    public function getFilmsByAge(int $id): array
    {
        $entityManager = $this->getEntityManager();

        $qb = $entityManager->createQueryBuilder();

        $query = $qb->select([
            'g.id',
            'g.titre',
            'g.synopsis',
            'g.imagePath',
            'a.label',
            'a.imagePath as pegi'
        ])
            ->from(Film::class, 'g')
            ->join('g.age', 'a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getResult();
    }
}
