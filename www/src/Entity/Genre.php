<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    public function getFilm(): Collection
    {
        return $this->film;
    }
    #[ORM\Column(length: 50)]
    private ?string $label = null;

    /**
     * @var Collection<int, Film>
     */
    #[ORM\ManyToMany(targetEntity: Film::class, mappedBy: 'genre')]
    private Collection $film;

    public function __construct()
    {
        $this->film = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Film>
     */
    public function getFilms(): Collection
    {
        return $this->film;
    }

    public function addFilm(Film $film): static
    {
        if (!$this->film->contains($film)) {
            $this->film->add($film);
            $film->addGenre($this);
        }

        return $this;
    }

    public function removeFilm(Film $film): static
    {
        if ($this->film->removeElement($film)) {
            $film->removeGenre($this);
        }

        return $this;
    }
}
