<?php

namespace App\Twig\Runtime;

use App\Repository\FilmRepository;
use Twig\Extension\RuntimeExtensionInterface;

class NavExtensionRuntime implements RuntimeExtensionInterface
{
    // On va déclarer une variable en private pour stocker l'instance de filmRepository
    private $filmRepository;

    // public function __construct()
    // {
    // Inject dependencies if needed
    // }
    public function __construct(FilmRepository $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    // public function doSomething($value)
    // {
    // ...
    // }
    public function menuItems()
    {
        return $this->filmRepository->getCountFilmByGenre();
    }
    
    public function filtersItems()
    {
        return [
            ['label' => 'Date de sortie', 'filter' => 'f.dateSortie Asc', 'icon' => 'fa-sharp fa-solid fa-arrow-up'],
            ['label' => 'Date de sortie', 'filter' => 'f.dateSortie Desc', 'icon' => 'fa-sharp fa-solid fa-arrow-down'],
            ['label' => 'Note presse', 'filter' => 'n.mediaNote Asc', 'icon' => 'fa-sharp fa-solid fa-arrow-up'],
            ['label' => 'Note presse', 'filter' => 'n.mediaNote Desc', 'icon' => 'fa-sharp fa-solid fa-arrow-down'],
            ['label' => 'Note spectateur', 'filter' => 'n.viewerNote Asc', 'icon' => 'fa-sharp fa-solid fa-arrow-up'],
            ['label' => 'Note spectateur', 'filter' => 'n.viewerNote Desc', 'icon' => 'fa-sharp fa-solid fa-arrow-down'],
        ];
    }

}
