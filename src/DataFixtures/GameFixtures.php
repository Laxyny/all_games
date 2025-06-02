<?php
// src/DataFixtures/GameFixtures.php
namespace App\DataFixtures;

use App\Entity\Editor;
use App\Entity\Game;
use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $gamesData = [
            [
                'name' => 'Rocket League',
                'description' => 'A high-paced hybrid of arcade-style soccer and vehicular mayhem...',
                'releaseDate' => '2015-07-07',
                'editorReference' => 'editor-0',
                'genreReferences' => ['genre-0', 'genre-3'],
            ],
            [
                'name' => 'Undertale',
                'description' => 'A unique role-playing game that allows the player to fight or talk their way through...',
                'releaseDate' => '2015-09-15',
                'editorReference' => 'editor-1',
                'genreReferences' => ['genre-1', 'genre-2'],
            ],
            [
                'name' => 'Fortnite',
                'description' => 'A battle royale game where players fight to be the last person standing...',
                'releaseDate' => '2017-07-25',
                'editorReference' => 'editor-2',
                'genreReferences' => ['genre-5', 'genre-9', 'genre-11'],
            ],
            [
                'name' => 'PUBG',
                'description' => 'A competitive survival shooter where players fight to be the last alive...',
                'releaseDate' => '2017-12-20',
                'editorReference' => 'editor-3',
                'genreReferences' => ['genre-5', 'genre-9', 'genre-11', 'genre-8'],
            ],
            [
                'name' => 'GTA V',
                'description' => 'An action-adventure game set in a vast open world filled with opportunities...',
                'releaseDate' => '2013-09-17',
                'editorReference' => 'editor-4',
                'genreReferences' => ['genre-0', 'genre-1', 'genre-12'],
            ],
            [
                'name' => 'The Witcher 3',
                'description' => 'An action role-playing game set in an open world with a compelling narrative...',
                'releaseDate' => '2015-05-19',
                'editorReference' => 'editor-5',
                'genreReferences' => ['genre-2', 'genre-1', 'genre-12'],
            ],
            [
                'name' => 'Minecraft',
                'description' => 'A sandbox video game where players can build and explore in a procedurally generated world...',
                'releaseDate' => '2011-11-18',
                'editorReference' => 'editor-6',
                'genreReferences' => ['genre-10', 'genre-1', 'genre-8'],
            ],
            [
                'name' => 'Among Us',
                'description' => 'A multiplayer game where players take on the role of a crewmate or imposter on a spaceship...',
                'releaseDate' => '2018-06-15',
                'editorReference' => 'editor-7',
                'genreReferences' => ['genre-11', 'genre-4', 'genre-7'],
            ],
            [
                'name' => 'Cyberpunk 2077',
                'description' => 'An open-world, action-adventure story set in Night City...',
                'releaseDate' => '2020-12-10',
                'editorReference' => 'editor-5',
                'genreReferences' => ['genre-2', 'genre-0', 'genre-1', 'genre-12'],
            ],
            [
                'name' => 'Red Dead Redemption 2',
                'description' => 'An epic tale of life in America’s unforgiving heartland...',
                'releaseDate' => '2018-10-26',
                'editorReference' => 'editor-4',
                'genreReferences' => ['genre-0', 'genre-1', 'genre-12'],
            ],
            [
                'name' => 'The Elder Scrolls V: Skyrim',
                'description' => 'An open-world action RPG where players can explore and adventure...',
                'releaseDate' => '2011-11-11',
                'editorReference' => 'editor-11',
                'genreReferences' => ['genre-2', 'genre-0', 'genre-1', 'genre-12'],
            ],
            [
                'name' => 'Counter-Strike: Global Offensive',
                'description' => 'A multiplayer first-person shooter with a strong competitive scene...',
                'releaseDate' => '2012-08-21',
                'editorReference' => 'editor-8',
                'genreReferences' => ['genre-5', 'genre-11', 'genre-13'],
            ],
            [
                'name' => 'League of Legends',
                'description' => 'A multiplayer online battle arena with a vast roster of champions...',
                'releaseDate' => '2009-10-27',
                'editorReference' => 'editor-9',
                'genreReferences' => ['genre-4', 'genre-11', 'genre-13'],
            ],
            [
                'name' => 'World of Warcraft',
                'description' => 'A massively multiplayer online role-playing game set in the Warcraft universe...',
                'releaseDate' => '2004-11-23',
                'editorReference' => 'editor-10',
                'genreReferences' => ['genre-2', 'genre-1', 'genre-11'],
            ],
            [
                'name' => 'Half-Life 2',
                'description' => 'A first-person shooter that combines shooting, puzzles, and storytelling...',
                'releaseDate' => '2004-11-16',
                'editorReference' => 'editor-8',
                'genreReferences' => ['genre-5', 'genre-0', 'genre-1', 'genre-7'],
            ],
        ];

        foreach ($gamesData as $data) {
            $game = new Game();
            $game->setName($data['name']);
            $game->setDescription($data['description']);
            $game->setReleaseDate(new \DateTimeImmutable($data['releaseDate']));
            $game->setEditor($this->getReference($data['editorReference'], Editor::class));

            foreach ($data['genreReferences'] as $genreReference) {
                $game->addGenre($this->getReference($genreReference, Genre::class));
            }

            $manager->persist($game);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EditorFixtures::class,
            GenreFixtures::class,
        ];
    }
}
