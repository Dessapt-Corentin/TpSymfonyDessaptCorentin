<?php

namespace App\DataFixtures;

use App\Entity\Age;
use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Note;
use App\Entity\Personne;
use App\Entity\Profession;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FilmFixtures extends Fixture
{
    /**
     * Méthode pour charger les données de fixtures
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadAges($manager);
        $this->loadGenres($manager);
        $this->loadNotes($manager);
        $this->loadProfessions($manager);
        $this->loadPersons($manager);
        $this->loadMovies($manager);
        $manager->flush();
    }


    /**
     * Méthode pour générer des ages
     * @param ObjectManager $manager
     * @return void
     */
    public function loadAges(ObjectManager $manager): void
    {
        $array_ages = ['7', '12', '16', '18'];
        /**['label' => '7', 'imagePath' => 'pegi7.png'],
    ['label' => '12', 'imagePath' => 'pegi12.png'],
    ['label' => '16', 'imagePath' => 'pegi16.png'],
    ['label' => '18', 'imagePath' => 'pegi18.png'],**/

        foreach ($array_ages as $key => $value) {
            $age = new Age();
            $age->setLabel($value);
            $age->setImagePath('pegi' . $value . '.png');
            $manager->persist($age);
            $this->addReference('age_' . $key + 1, $age);
        }
    }

    /**
     * Méthode pour générer des genre
     * @param ObjectManager $manager
     * @return void
     */
    public function loadGenres(ObjectManager $manager): void
    {
        $array_genres = ['Action', 'Horreur', 'Comique', 'Aventure', 'Science-fiction', 'Fantastique', 'Thriller', 'Drame', 'Policier', 'Historique', 'Animation', 'Documentaire', 'Biopic', 'Musical', 'Guerre', 'Western', 'Romantique', 'Comédie musicale', 'Sport', 'Jeunesse', 'Famille', 'Educatif', 'Autre'];

        foreach ($array_genres as $key => $value) {
            $genre = new Genre();
            $genre->setLabel($value);
            $manager->persist($genre);
            $this->addReference('genre_' . $key + 1, $genre);
        }
    }

    /**
     * Méthode pour générer les notes
     * @param ObjectManager $manager
     * @return void
     */
    public function loadNotes(ObjectManager $manager): void
    {
        // on va utiliser une bouvle for pour générer les 14 notes
        for ($i = 1; $i <= 14; $i++) {
            // on instancie une note
            $note = new Note();
            $note->setMediaNote($this->randomNote());
            $note->setViewerNote($this->randomNote());
            $manager->persist($note);
            // on définit une référence pour pouvoir faire nos relations
            $this->addReference('note_' . $i, $note);
        }
    }

    /**
     * Méthode pour générer des professions
     * @param ObjectManager $manager
     * @return void
     */
    public function loadProfessions(ObjectManager $manager): void
    {
        $array_professions = ['Acteur', 'Réalisateur', 'Scénariste', 'Producteur', 'Compositeur', 'Monteur', 'Directeur de la photographie', 'Ingénieur du son', 'Costumier', 'Maquilleur', 'Cascadeur', 'Autre'];

        foreach ($array_professions as $key => $value) {
            $profession = new Profession();
            $profession->setLabel($value);
            $manager->persist($profession);
            $this->addReference('profession_' . ($key + 1), $profession);
        }
    }

    /**
     * Méthode pour générer des personnes, une personne peut avoir plusieurs professions (nom, prénom , personne_profession)
     * @param ObjectManager $manager
     * @return void
     */
    public function loadPersons(ObjectManager $manager): void
    {
        $array_persons = [
            ['nom' => 'De Niro', 'prenom' => 'Robert', 'profession' => [1, 2]],
            ['nom' => 'Pacino', 'prenom' => 'Al', 'profession' => [1, 3]],
            ['nom' => 'Scorsese', 'prenom' => 'Martin', 'profession' => [2, 4]],
            ['nom' => 'Tarantino', 'prenom' => 'Quentin', 'profession' => [2, 3]],
            ['nom' => 'Eastwood', 'prenom' => 'Clint', 'profession' => [1, 2, 4]],
            ['nom' => 'Coppola', 'prenom' => 'Francis Ford', 'profession' => [2, 4]],
            ['nom' => 'Ford', 'prenom' => 'Harrison', 'profession' => [1]],
            ['nom' => 'Hitchcock', 'prenom' => 'Alfred', 'profession' => [2]],
            ['nom' => 'Spielberg', 'prenom' => 'Steven', 'profession' => [2, 4]],
            ['nom' => 'Kubrick', 'prenom' => 'Stanley', 'profession' => [2, 3]],
            ['nom' => 'Lynch', 'prenom' => 'David', 'profession' => [2, 3]],
        ];

        foreach ($array_persons as $key => $value) {
            $person = new Personne();
            $person->setNom($value['nom']);
            $person->setPrenom($value['prenom']);
            foreach ($value['profession'] as $professionId) {
                $person->addPersonneProfession($this->getReference('profession_' . $professionId, Profession::class));
            }
            $manager->persist($person);
            $this->addReference('person_' . ($key + 1), $person);
        }
    }

    /**
     * Méthode pour générer des films (titre, genre_id, synopsis, age_id, prod_id, dateSortie, note_id, imagePath)
     * @param ObjectManager $manager
     * @return void
     */
    public function loadMovies(ObjectManager $manager): void
    {
        $array_movies = [
            ['titre' => 'Les Affranchis', 'genre_id' => 1, 'synopsis' => 'Le film retrace la vie de Henry Hill, un petit voyou de Brooklyn, depuis son adolescence jusqu’à son arrestation pour trafic de drogue en passant par son ascension dans la mafia.', 'age_id' => 3, 'prod_id' => 3, 'dateSortie' => '1990-09-19', 'note_id' => 1, 'imagePath' => 'affranchis.jpg', 'time' => '145'],
            ['titre' => 'Le Parrain', 'genre_id' => 1, 'synopsis' => 'Le film raconte l’histoire de la famille Corleone, une famille de la mafia sicilienne installée à New York.', 'age_id' => 4, 'prod_id' => 3, 'dateSortie' => '1972-09-14', 'note_id' => 2, 'imagePath' => 'parrain.jpg', 'time' => '175'],
            ['titre' => 'Taxi Driver', 'genre_id' => 1, 'synopsis' => 'Le film raconte l’histoire de Travis Bickle, un vétéran de la guerre du Vietnam devenu chauffeur de taxi à New York.', 'age_id' => 3, 'prod_id' => 3, 'dateSortie' => '1976-02-09', 'note_id' => 3, 'imagePath' => 'taxi_driver.jpg', 'time' => '115'],
            ['titre' => 'Pulp Fiction', 'genre_id' => 1, 'synopsis' => 'Le film est une suite de plusieurs histoires qui se croisent et s’entrecroisent.', 'age_id' => 4, 'prod_id' => 4, 'dateSortie' => '1994-10-14', 'note_id' => 4, 'imagePath' => 'pulp_fiction.jpg', 'time' => '149'],
        ];

        foreach ($array_movies as $key => $value) {
            $movie = new Film();
            $movie->setTitre($value['titre']);
            $movie->addGenre($this->getReference('genre_' . $value['genre_id'], Genre::class));
            $movie->setSynopsis($value['synopsis']);
            $movie->setAge($this->getReference('age_' . $value['age_id'], Age::class));
            $movie->addProd($this->getReference('person_' . $value['prod_id'], Personne::class));
            $movie->setDateSortie(new \DateTime($value['dateSortie']));
            $movie->setNote($this->getReference('note_' . $value['note_id'], Note::class));
            $movie->setImagePath($value['imagePath']);
            $movie->setTime($value['time']);
            $manager->persist($movie);
        }
    }

    /**
     * Méthode qui génére un nombre aléatoire entre 10 et 20
     * @return int
     */
    public function randomNote(): int
    {
        return rand(10, 20);
    }
}
