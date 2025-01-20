<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    /**
     * @var Collection<int, Film>
     */
    #[ORM\ManyToMany(targetEntity: Film::class, mappedBy: 'prod')]
    private Collection $films;

    /**
     * @var Collection<int, Profession>
     */
    #[ORM\ManyToMany(targetEntity: Profession::class, inversedBy: 'personnes')]
    private Collection $personneProfession;

    public function __construct()
    {
        $this->films = new ArrayCollection();
        $this->personneProfession = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Film>
     */
    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function addFilm(Film $film): static
    {
        if (!$this->films->contains($film)) {
            $this->films->add($film);
            $film->addProd($this);
        }

        return $this;
    }

    public function removeFilm(Film $film): static
    {
        if ($this->films->removeElement($film)) {
            $film->removeProd($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Profession>
     */
    public function getPersonneProfession(): Collection
    {
        return $this->personneProfession;
    }

    public function addPersonneProfession(Profession $personneProfession): static
    {
        if (!$this->personneProfession->contains($personneProfession)) {
            $this->personneProfession->add($personneProfession);
        }

        return $this;
    }

    public function removePersonneProfession(Profession $personneProfession): static
    {
        $this->personneProfession->removeElement($personneProfession);

        return $this;
    }
}
